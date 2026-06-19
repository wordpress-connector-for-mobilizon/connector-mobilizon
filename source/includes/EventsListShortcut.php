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
        'show-participate-button' => 'false',
      ), $atts
    );

    $url = Settings::getUrl();
    $eventsCount = $atts_with_overriden_defaults['events-count'];
    $groupUsername = $atts_with_overriden_defaults['group-name'];
    $showParticipateButton = filter_var($atts_with_overriden_defaults['show-participate-button'], FILTER_VALIDATE_BOOLEAN);
    $classNamePrefix = NAME;

    ob_start();
    try {
      $showMoreUrl = Settings::getUrl();
      if ($groupUsername) {
        $groupUsernames = GroupNameHelper::extractAndTrimNames($groupUsername);
        $result = GraphQlClient::get_upcoming_events_and_group_names($url, (int) $eventsCount, $groupUsernames);
        $events = $result['events'];
        $groups = GroupNameHelper::convertToGroupsObject($groupUsernames, $showMoreUrl, $result['groups']);
      } else {
        $events = GraphQlClient::get_upcoming_events($url, (int) $eventsCount);
      }

      $dateFormat = SiteSettings::getDateFormat();
      $timeFormat = SiteSettings::getTimeFormat();
      $timeZone = SiteSettings::getTimeZone();

      require dirname(__DIR__) . '/view/events-list.php';
    } catch (GeneralException $e) {
      require dirname(__DIR__) . '/view/events-list-not-loaded.php';
    } catch (GroupNotFoundException $e) {
      require dirname(__DIR__) . '/view/events-list-group-not-found.php';
    }
    $output = ob_get_clean();
    return $output;
  }
}
