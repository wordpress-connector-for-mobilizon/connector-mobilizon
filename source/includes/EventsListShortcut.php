<?php
namespace MobilizonConnector;

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

    $url = Settings::getUrl();
    $eventsCount = $atts_with_overriden_defaults['events-count'];
    $groupName = $atts_with_overriden_defaults['group-name'];
    $classNamePrefix = NAME;

    ob_start();
    try {
      $showMoreUrl = Settings::getUrl();
      if ($groupName) {
        $events = GraphQlClient::get_upcoming_events_by_group_name($url, (int) $eventsCount, $groupName);
        $showMoreUrl .= '/@' . $groupName . '/events';
      } else {
        $events = GraphQlClient::get_upcoming_events($url, (int) $eventsCount);
      }

      $dateFormat = SiteSettings::getDateFormat();
      $timeFormat = SiteSettings::getTimeFormat();

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
