<?php
namespace MobilizonConnector;

final class EventsCache {

  private static $MAX_AGE_IN_S = 120;

  public static function set(array $parameters, mixed $data): void {
    // md5 is used as key must be 172 characters or fewer in length.
    $key = md5(json_encode($parameters));
    set_transient($key, $data, self::$MAX_AGE_IN_S);
  }

  public static function get(array $parameters): mixed {
    $key = md5(json_encode($parameters));
    $data = get_transient($key);
    return $data;
  }
}
