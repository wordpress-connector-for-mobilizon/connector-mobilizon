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
        ]
      ]
      );
  }

  public static function get_events($request) {
    $eventsCount = $request['eventsCount'];
    $groupName = isset($request['groupName']) ? $request['groupName'] : '';

    $url = Settings::getUrl();

    try {
      if ($groupName) {
        $events = GraphQlClient::get_upcoming_events_by_group_name($url, (int) $eventsCount, $groupName);
      } else {
        $events = GraphQlClient::get_upcoming_events($url, (int) $eventsCount);
      }
      return $events;
    } catch (GeneralException $e) {
      return new \WP_Error('events_not_loading', 'The events could not be loaded!', array('status' => 500));
    } catch (GroupNotFoundException $e) {
      return new \WP_Error('group_not_found', sprintf('The group "%s" could not be found!', $groupName), array('status' => 404));
    }
  }
}
