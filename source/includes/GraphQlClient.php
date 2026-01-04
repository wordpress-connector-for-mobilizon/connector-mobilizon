<?php
namespace MobilizonConnector;

// Exit if this file is called directly.
if (!defined('ABSPATH')) {
  exit;
}

final class GraphQlClient {

  public static function query(string $endpoint, string $query, array $variables = [], ?string $token = null): array
  {
    $headers = ['Content-Type: application/json'];
    if ($token !== null) {
        $headers[] = "Authorization: bearer $token";
    }

    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => $headers,
            'content' => json_encode(['query' => $query, 'variables' => $variables]),
        ]
      ]);
    $data = @file_get_contents($endpoint, false, $context);

    if ($data === false) {
      $error = error_get_last();
      throw new \ErrorException(esc_html($error['message']), esc_html($error['type']));
    }

    return json_decode($data, true);
  }

  public static function get_upcoming_events(string $url, int $limit): array {
    $query = <<<'GRAPHQL'
      query ($limit: Int) {
        events(limit: $limit) {
          elements {
            id,
            title,
            url,
            beginsOn,
            endsOn,
            physicalAddress {
              description,
              locality
            },
            picture {
              alt,
              contentType,
              url
            }
          },
          total
        }
      }
      GRAPHQL;

    $cachedEvents = EventsCache::get(['url' => $url, 'query' => $query, 'limit' => $limit]);
    if ($cachedEvents !== false) {
      return $cachedEvents;
    }

    $endpoint = $url . '/api';
    $data = self::query($endpoint, $query, ['limit' => $limit]);
    self::checkData($data);

    $events = $data['data']['events']['elements'];
    foreach ($events as &$event) {
      if ($event['picture']) {
        $picture_response = self::download_image($event['picture']['url']);
        if ($picture_response !== false) {
          $picture_encoded = 'data:' . $event['picture']['contentType'] . ';base64,' . base64_encode($picture_response);
          $event['picture']['base64'] = $picture_encoded;
        }
      }
      unset($event);
    }

    EventsCache::set(['url' => $url, 'query' => $query, 'limit' => $limit], $events);
    return $events;
  }

  public static function get_upcoming_events_by_group_names(string $url, int $limit, array $groupNames): array {
    $queryParts = [];
    $variables = ['afterDatetime' => 'DateTime', 'limit' => 'Int'];

    foreach ($groupNames as $index => $groupName) {
      $varName = "group{$index}";
      $variables[$varName] = 'String!';

      $queryParts[] = <<<GRAPHQL
        {$varName}: group(preferredUsername: \${$varName}) {
          organizedEvents(afterDatetime: \$afterDatetime, limit: \$limit) {
            elements {
              id,
              title,
              url,
              beginsOn,
              endsOn,
              physicalAddress {
                description,
                locality
              },
              picture {
                alt,
                contentType,
                url
              }
            },
            total
          }
        }
        GRAPHQL;
    }

    $variableDefinitions = [];
    foreach ($variables as $name => $type) {
        $variableDefinitions[] = "\${$name}: {$type}";
    }

    $query = sprintf(
        "query (%s) {\n%s\n}",
        implode(', ', $variableDefinitions),
        implode("\n", $queryParts)
    );

    $afterDatetime = gmdate(\DateTime::ATOM);
    $queryVariables = [
      'afterDatetime' => $afterDatetime,
      'limit' => $limit
    ];
    foreach ($groupNames as $index => $groupName) {
      $queryVariables["group{$index}"] = $groupName;
    }

    $cachedEvents = EventsCache::get(['url' => $url, 'query' => $query, 'afterDatetime' => $afterDatetime, 'groupNames' => implode(',', $groupNames), 'limit' => $limit]);
    if ($cachedEvents !== false) {
      return $cachedEvents;
    }

    $endpoint = $url . '/api';
    $data = self::query($endpoint, $query, $queryVariables);
    self::checkData($data);

    $events = [];
    foreach ($data['data'] as $groupData) {
      if ($groupData && isset($groupData['organizedEvents']['elements'])) {
        $events = array_merge($events, $groupData['organizedEvents']['elements']);
      }
    }
    usort($events, function($a, $b) {
      return strtotime($a['beginsOn']) - strtotime($b['beginsOn']);
    });
    $events = array_slice($events, 0, $limit);
    
    foreach ($events as &$event) {
      if ($event['picture']) {
        $picture_response = self::download_image($event['picture']['url']);
        if ($picture_response !== false) {
          $picture_encoded = 'data:' . $event['picture']['contentType'] . ';base64,' . base64_encode($picture_response);
          $event['picture']['base64'] = $picture_encoded;
        }
      }
      unset($event);
    }

    EventsCache::set(['url' => $url, 'query' => $query, 'afterDatetime' => $afterDatetime, 'groupNames' => implode(',', $groupNames), 'limit' => $limit], $events);
    return $events;
  }

  private static function checkData($data) {
    if (isset($data['errors'])) {
      if (count($data['errors']) > 0 &&
          isset($data['errors'][0]['code']) &&
          $data['errors'][0]['code'] === 'group_not_found') {
        throw new GroupNotFoundException(esc_html(serialize($data['errors'][0])));
      } else {
        throw new GeneralException(esc_html(serialize($data['errors'])));
      }
    }
  }

  private static function download_image($url) {
    $response = wp_remote_get($url);
    $image_data = $response['body'];
    return $image_data;
  }
}
