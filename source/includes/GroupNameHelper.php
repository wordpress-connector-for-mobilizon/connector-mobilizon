<?php
namespace MobilizonConnector;

// Exit if this file is called directly.
if (!defined('ABSPATH')) {
  exit;
}

final class GroupNameHelper {
  public static function extractAndTrimNames(string $groupName) {
    return array_map(fn($name): string => trim($name), explode(',', $groupName));
  }

  public static function convertToGroupsObject(array $groupNames, string $showMoreUrl) {
    $groups = [];
    foreach ($groupNames as $name) {
      $groups[] = array(
        'name' => $name,
        'url' => $showMoreUrl . '/@' . $name . '/events'
      );
    }
    return $groups;
  }
}
