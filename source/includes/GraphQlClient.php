<?php
namespace MobilizonConnector;

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
      throw new \ErrorException($error['message'], $error['type']);
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
    EventsCache::set(['url' => $url, 'query' => $query, 'limit' => $limit], $events);
    return $events;
  }

  public static function get_upcoming_events_by_group_name(string $url, int $limit, string $groupName): array {
    $query = <<<'GRAPHQL'
      query ($afterDatetime: DateTime, $groupName: String!, $limit: Int) {
        group(preferredUsername: $groupName) {
          organizedEvents(afterDatetime: $afterDatetime, limit: $limit) {
            elements {
              id,
              title,
              url,
              beginsOn,
              endsOn,
              physicalAddress {
                description,
                locality
              }
            },
            total
          }
        }
      }
      GRAPHQL;

    $afterDatetime = date(\DateTime::ISO8601);

    $cachedEvents = EventsCache::get(['url' => $url, 'query' => $query, 'afterDatetime' => $afterDatetime, 'groupName' => $groupName, 'limit' => $limit]);
    if ($cachedEvents !== false) {
      return $cachedEvents;
    }

    $endpoint = $url . '/api';
    $data = self::query($endpoint, $query, ['afterDatetime' => $afterDatetime, 'groupName' => $groupName, 'limit' => $limit]);
    self::checkData($data);

    $events = $data['data']['group']['organizedEvents']['elements'];
    EventsCache::set(['url' => $url, 'query' => $query, 'afterDatetime' => $afterDatetime, 'groupName' => $groupName, 'limit' => $limit], $events);
    return $events;
  }

  private static function checkData($data) {
    if (isset($data['errors'])) {
      if (count($data['errors']) > 0 &&
          isset($data['errors'][0]['code']) &&
          $data['errors'][0]['code'] === 'group_not_found') {
        throw new GroupNotFoundException(serialize($data['errors'][0]));
      } else {
        throw new GeneralException(serialize($data['errors']));
      }
    }
  }
}
