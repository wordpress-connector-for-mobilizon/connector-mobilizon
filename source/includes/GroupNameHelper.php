<?php
namespace MobilizonConnector;

// Exit if this file is called directly.
if (!defined('ABSPATH')) {
  exit;
}

final class GroupNameHelper {
  public static function extractAndTrimNames(string $groupUsername) {
    return array_map(fn($name): string => trim($name), explode(',', $groupUsername));
  }

  public static function convertToGroupsObject(array $groupUsernames, string $showMoreUrl, array $nameMap = []) {
    $groups = [];
    foreach ($groupUsernames as $handle) {
      $groups[] = [
        'name' => !empty($nameMap[$handle]) ? $nameMap[$handle] : $handle,
        'url' => $showMoreUrl . '/@' . $handle . '/events'
      ];
    }
    return $groups;
  }
}
