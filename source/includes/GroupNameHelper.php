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

  public static function convertToGroupsObject(array $groupNames, string $showMoreUrl, array $nameMap = []) {
    $groups = [];
    foreach ($groupNames as $handle) {
      $groups[] = array(
        'name' => !empty($nameMap[$handle]) ? $nameMap[$handle] : $handle,
        'url' => $showMoreUrl . '/@' . $handle . '/events'
      );
    }
    return $groups;
  }
}
