<?php
namespace MobilizonConnector;

class EventsListWidget extends \WP_Widget {

  public function __construct() {
    parent::__construct(
      NAME . '-events-list',
      NICE_NAME . ' ' . __('Events List', 'connector-mobilizon'),
      array(
        'description' => __('A list of the upcoming events of the connected Mobilizon instance.', 'connector-mobilizon'),
      ),
    );
  }

  public function widget($args, $options) {
    echo $args['before_widget'];

    if (!empty($options['title'])) {
      echo $args['before_title'].apply_filters('widget_title', $options['title']).$args['after_title'];
    }

    $url = Settings::getUrl();
    $eventsCount = $options['eventsCount'];
    $groupName = isset($options['groupName']) ? $options['groupName'] : '';
    $classNamePrefix = NAME;

    try {
      $showMoreUrl = Settings::getUrl();
      if ($groupName) {
        $events = GraphQlClient::get_upcoming_events_by_group_name($url, (int) $eventsCount, $groupName);
        $showMoreUrl .= '/@' . $groupName . '/events';
      } else {
        $events = GraphQlClient::get_upcoming_events($url, (int) $eventsCount);
      }

      $locale = get_locale();
      $isShortOffsetNameShown = Settings::isShortOffsetNameShown();
      $timeZone = wp_timezone_string();
  
      require dirname(__DIR__) . '/view/events-list.php';
    } catch (GeneralException $e) {
      require dirname(__DIR__) . '/view/events-list-not-loaded.php';
    } catch (GroupNotFoundException $e) {
      require dirname(__DIR__) . '/view/events-list-group-not-found.php';
    }

    echo $args['after_widget'];
  }

  public function form($options) {
    $title = !empty($options['title']) ? $options['title'] : __('Events', 'connector-mobilizon');
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
