<?php
namespace MobilizonConnector;

// Exit if this file is called directly.
if (!defined('ABSPATH')) {
  exit;
}

class EventsListShortcut {
  
  public static function init() {
    add_shortcode(NAME . '-events-list', 'MobilizonConnector\EventsListShortcut::inflate');
  }

  public static function inflate($atts = [], $content = null) {
    // Normalize attribute keys, lowercase.
    $atts = array_change_key_case((array) $atts, CASE_LOWER);
 
    // Override default attributes with user attributes.
    $atts_with_overriden_defaults = shortcode_atts(
      array(
        'events-count' => DEFAULT_EVENTS_COUNT,
        'group-name' => '',
      ), $atts
    );

    $classNamePrefix = NAME;
    $eventsCount = $atts_with_overriden_defaults['events-count'];
    $locale = str_replace('_', '-', get_locale());
    $groupName = $atts_with_overriden_defaults['group-name'];
    $url = Settings::getUrl();
    $textDomain = TEXT_DOMAIN;
    $timeZone = get_option('timezone_string');

    ob_start();
    require dirname(__DIR__) . '/view/events-list.php';
    $output = ob_get_clean();
    return $output;
  }
}
