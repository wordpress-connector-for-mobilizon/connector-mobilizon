<?php
namespace MobilizonConnector;

class EventsListWidget extends \WP_Widget {

  public function __construct() {
    parent::__construct(
      NAME . '-events-list',
      NICE_NAME . ' ' . esc_html__('Events List', 'connector-mobilizon'),
      array(
        'description' => esc_html__('A list of the upcoming events of the connected Mobilizon instance.', 'connector-mobilizon'),
      ),
    );
  }

  public function widget($args, $options) {
    echo wp_kses_post($args['before_widget']);

    if (!empty($options['title'])) {
      echo wp_kses_post($args['before_title']).wp_kses_post(apply_filters('widget_title', $options['title'])).wp_kses_post($args['after_title']);
    }

    $url = Settings::getUrl();
    $eventsCount = $options['eventsCount'];
    $groupName = isset($options['groupName']) ? $options['groupName'] : '';
    $classNamePrefix = NAME;

    try {
      $showMoreUrl = Settings::getUrl();
      if ($groupName) {
        $groupNames = GroupNameHelper::extractAndTrimNames($groupName);
        $events = GraphQlClient::get_upcoming_events_by_group_names($url, (int) $eventsCount, $groupNames);
        $groups = GroupNameHelper::convertToGroupsObject($groupNames, $showMoreUrl);
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

    echo wp_kses_post($args['after_widget']);
  }

  public function form($options) {
    $title = !empty($options['title']) ? $options['title'] : esc_html__('Events', 'connector-mobilizon');
    $eventsCount = !empty($options['eventsCount']) ? $options['eventsCount'] : DEFAULT_EVENTS_COUNT;
    $groupName = !empty($options['groupName']) ? $options['groupName'] : '';
    
    require dirname(__DIR__) . '/view/events-list-widget/form.php';
  }

  public function update($new_options, $old_options) {
    if (!current_user_can('edit_theme_options')) {
      return;
    }
    $options = array();
    $options['title'] = !empty($new_options['title']) ? sanitize_text_field($new_options['title']) : '';
    $options['eventsCount'] = !empty($new_options['eventsCount']) ? sanitize_text_field($new_options['eventsCount']) : 5;
    $options['groupName'] = !empty($new_options['groupName']) ? sanitize_text_field($new_options['groupName']) : '';
    return $options;
  }
}
