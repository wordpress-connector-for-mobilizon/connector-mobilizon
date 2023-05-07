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

    $endpoint = $url . '/api';
    // const dataInCache = SessionCache.get(sessionStorage, {
    //   url,
    //   query,
    //   variables: { limit },
    // })
    // if (dataInCache !== null) {
    //   return Promise.resolve(dataInCache)
    // }
    $data = self::query($endpoint, $query, ['limit' => $limit]);
      // SessionCache.add(sessionStorage, { url, query, variables: { limit } }, data)
    return $data;
  }

  public static function get_upcoming_events_by_group_name(string $url, int $limit, string $groupName): array {
    $query = <<<'GRAPHQL'
      query ($afterDatetime: DateTime, $groupName: String, $limit: Int) {
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

    $endpoint = $url . '/api';

    // const afterDatetime = DateTimeWrapper.getCurrentDatetimeAsString()
    // const dataInCache = SessionCache.get(sessionStorage, {
    //   url,
    //   query,
    //   variables: { afterDatetime, groupName, limit },
    // })
    // if (dataInCache !== null) {
    //   return Promise.resolve(dataInCache)
    // }
    $afterDatetime = date(\DateTime::ISO8601);
    $data = self::query($endpoint, $query, ['afterDatetime'=> $afterDatetime, 'groupName' => $groupName, 'limit' => $limit]);
    // return request(url, query, { afterDatetime, groupName, limit }).then(
    //   (data) => {
    //     SessionCache.add(
    //       sessionStorage,
    //       { url, query, variables: { afterDatetime, groupName, limit } },
    //       data
    //     )
    //     return Promise.resolve(data)
    //   }
    // )
    return $data;
  }
}
