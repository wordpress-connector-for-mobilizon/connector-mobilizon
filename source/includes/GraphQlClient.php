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
      }
      GRAPHQL;

    $afterDatetime = date(\DateTime::ISO8601);

    // TODO
    // $cachedEvents = EventsCache::get(['url' => $url, 'query' => $query, 'afterDatetime' => $afterDatetime, 'groupName' => $groupName, 'limit' => $limit]);
    // if ($cachedEvents !== false) {
    //   return $cachedEvents;
    // }

    $endpoint = $url . '/api';
    $data = self::query($endpoint, $query, ['afterDatetime' => $afterDatetime, 'groupName' => $groupName, 'limit' => $limit]);
    self::checkData($data);

    $events = $data['data']['group']['organizedEvents']['elements'];
    
    foreach ($data['data']['group']['organizedEvents']['elements'] as &$event) {
      if ($event['picture']) {
        $picture_response = self::get_encoded_image($event['picture']['url']);
        if ($picture_response !== false) {
          $picture_encoded = 'data:' . $event['picture']['contentType'] . ';base64,' . base64_encode($picture_response);
          $event['picture']['base64'] = $picture_encoded;
          // TODO
          // EventsCache::set(['url' => $url, 'query' => $query, 'afterDatetime' => $afterDatetime, 'groupName' => $groupName, 'limit' => $limit, 'eventId' => $event['id']], $picture_encoded);
        }
      }
      unset($event);
    }

    EventsCache::set(['url' => $url, 'query' => $query, 'afterDatetime' => $afterDatetime, 'groupName' => $groupName, 'limit' => $limit], $data['data']['group']['organizedEvents']['elements']);

    return $data['data']['group']['organizedEvents']['elements'];
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

  private static function get_encoded_image($url) {
    // Initialize curl handle
    $ch = curl_init($url);

    // Set curl options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60); // Set timeout to 60 seconds (adjust as needed)
    curl_setopt($ch, CURLOPT_VERBOSE, 1); // TODO

    // Execute the request
    $image_data = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
      print_r(curl_error($ch));
      throw new \Error('Error: ' . curl_error($ch));
      // return false;
    }

    // Close curl handle
    curl_close($ch);

    // Encode image data (base64 in this example)
    // $encoded_image = base64_encode($image_data);

    return $image_data;
  }

}
