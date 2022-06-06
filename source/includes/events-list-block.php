<?php
namespace MobilizonConnector;

// Exit if this file is called directly.
if (!defined('ABSPATH')) {
  exit;
}

class EventsListBlock {

  public static function render($block_attributes, $content) {
    $classNamePrefix = NAME;
    $eventsCount = $block_attributes['eventsCount'];
    $groupName = isset($block_attributes['groupName']) ? $block_attributes['groupName'] : '';

    ob_start();
    require dirname(__DIR__) . '/view/events-list.php';
    $output = ob_get_clean();
    return $output;
  }
}
