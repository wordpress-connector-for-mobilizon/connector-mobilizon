<?php
namespace MobilizonConnector;

class Api {
  public static function init() {
    add_action('rest_api_init', 'MobilizonConnector\Api::init_api');
  }

  public static function init_api() {
    register_rest_route(
      NAME . '/v1',
      '/events',
      [
        'methods' => 'GET',
        'callback' => 'MobilizonConnector\Api::get_events',
        'args' => [
          'eventsCount' => [
            'required' => true,
            'validate_callback' => function($param, $request, $key) {
              return is_numeric($param) && $param > 0;
            }
          ],
          'groupName' => [
            'validate_callback' => function($param, $request, $key) {
              return !is_numeric($param);
            }
          ]
        ],
        'permission_callback' => '__return_true',
      ]
      );
  }

  public static function get_events($request) {
    $eventsCount = $request['eventsCount'];
    $groupName = isset($request['groupName']) ? $request['groupName'] : '';

    $url = Settings::getUrl();

    try {
      if ($groupName) {
        $groupNames = [];
        if (str_contains($groupName, ',')) {
          $groupNames = explode(',', $groupName);
        } else {
          $groupNames[] = $groupName;
        }
        $events = GraphQlClient::get_upcoming_events_by_group_name($url, (int) $eventsCount, $groupNames);
      } else {
        $events = GraphQlClient::get_upcoming_events($url, (int) $eventsCount);
      }
      $events = array_map([self::class, 'addDateAndTimeFormats'], $events);
      return $events;
    } catch (GeneralException $e) {
      return new \WP_Error('events_not_loading', 'The events could not be loaded!', array('status' => 500));
    } catch (GroupNotFoundException $e) {
      return new \WP_Error('group_not_found', sprintf('The group "%s" could not be found!', $groupName), array('status' => 404));
    }
  }

  public static function addDateAndTimeFormats($event) {
    $dateFormat = SiteSettings::getDateFormat();
    $timeFormat = SiteSettings::getTimeFormat();
    $timeZone = SiteSettings::getTimeZone();

    $startDateTime = new LocalDateTime($event['beginsOn'], $timeZone);
    $event['startDateFormatted'] = LocalDateTimeFormatter::format($startDateTime, $dateFormat);
    $event['startTimeFormatted'] = LocalDateTimeFormatter::format($startDateTime, $timeFormat);

    if ($event['endsOn']) {
      $endDateTime = new LocalDateTime($event['endsOn'], $timeZone);
      $event['endDateFormatted'] = LocalDateTimeFormatter::format($endDateTime, $dateFormat);
      $event['endTimeFormatted'] = LocalDateTimeFormatter::format($endDateTime, $timeFormat);
    }
    return $event;
  }
}
