<?php
namespace MobilizonConnector;

class EventsListBlock {

  public static function initAndReturnScriptName(): string {
    $scriptName = NAME . '-block-starter';
    wp_register_script($scriptName, plugins_url(NAME . '/front/block-events-loader.js'), [
        'wp-block-editor',
        'wp-blocks',
        'wp-components',
        'wp-i18n'
      ], '<wordpress-version>', array('in_footer' => true));
    register_block_type(NAME . '/events-list', [
      'api_version' => 2,
      'title' => esc_html__('Events List', 'connector-mobilizon'),
      'description' =>  esc_html__('A list of the upcoming events of the connected Mobilizon instance.', 'connector-mobilizon'),
      'category' => 'widgets',
      'icon' => 'list-view',
      'supports' => [
        'html' => false
      ],
      'attributes' => [
        'eventsCount' => [
          'type' => 'number',
          'default' => 3,
        ],
        'groupName' => [
          'type' => 'string',
        ],
      ],
      'editor_script' => $scriptName,
      'render_callback' => 'MobilizonConnector\EventsListBlock::render',
    ]);
    return $scriptName;
  }

  public static function render($block_attributes, $content) {
    $url = Settings::getUrl();
    $eventsCount = $block_attributes['eventsCount'];
    $groupName = isset($block_attributes['groupName']) ? $block_attributes['groupName'] : '';
    $classNamePrefix = NAME;

    ob_start();
    try {
      $showMoreUrl = Settings::getUrl();
      if ($groupName) {
        $groupNames = array_map(fn($name): string => trim($name), explode(',', $groupName));
        $events = GraphQlClient::get_upcoming_events_by_group_names($url, (int) $eventsCount, $groupNames);
        $groups = [];
        foreach ($groupNames as $name) {
          $groups[] = array(
            'name' => $name,
            'url' => $showMoreUrl . '/@' . $name . '/events'
          );
        }
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
