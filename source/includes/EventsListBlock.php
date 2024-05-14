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
      ]);
    register_block_type(NAME . '/events-list', [
      'api_version' => 2,
      'title' => __('Events List', 'connector-mobilizon'),
      'description' =>  __('A list of the upcoming events of the connected Mobilizon instance.', 'connector-mobilizon'),
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
      if ($groupName) {
        $events = GraphQlClient::get_upcoming_events_by_group_name($url, (int) $eventsCount, $groupName);
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
    $output = ob_get_clean();
    return $output;
  }
}
