<?php
namespace MobilizonConnector;

// Exit if this file is called directly.
if (!defined('ABSPATH')) {
  exit;
}

class EventsListBlock {

  public static function initAndReturnScriptName(): string {
    $scriptName = NAME . '-block-starter';
    wp_register_script($scriptName, plugins_url(NAME . '/front/block-events-loader.js'), [
        'wp-block-editor',
        'wp-blocks',
        'wp-components',
        'wp-editor',
        'wp-i18n'
      ]);
    register_block_type(NAME . '/events-list', [
      'api_version' => 2,
      'editor_script' => $scriptName,
      'render_callback' => 'MobilizonConnector\EventsListBlock::render',
    ]);
    return $scriptName;
  }

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
