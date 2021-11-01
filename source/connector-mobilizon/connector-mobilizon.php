<?php
/**
 * Plugin Name:       <wordpress-nice-name>
 * Author:            <wordpress-author-name>
 * Author URI:        <wordpress-author-url>
 * Description:       <wordpress-description>
 * Version:           <wordpress-version>
 * Requires at least: <wordpress-minimum-version>
 * Requires PHP:      <wordpress-php-minimum-version>
 * License:           <wordpress-license>
 */

require_once __DIR__ . '/includes/constants.php';
require_once __DIR__ . '/includes/settings.php';
require_once __DIR__ . '/includes/events-list-shortcut.php';
require_once __DIR__ . '/includes/events-list-widget.php';

// Exit if this file is called directly.
if (!defined('ABSPATH')) {
  exit;
}

function mobilizon_connector_activate() {
	MobilizonConnector\Settings::setDefaultOptions();
}
register_activation_hook(__FILE__, 'mobilizon_connector_activate');

function mobilizon_connector_initialize() {
  MobilizonConnector\Settings::init();
  MobilizonConnector\EventsListShortcut::init();
}
add_action('init', 'mobilizon_connector_initialize');

function mobilizon_connector_load_scripts() {
  wp_enqueue_script(MobilizonConnector\NAME . '-js', plugins_url('front/events-loader.js', __FILE__ ));
}
add_action('wp_enqueue_scripts', 'mobilizon_connector_load_scripts');

function mobilizon_connector_register_events_list_widget() {
  register_widget('MobilizonConnector\EventsListWidget');
}
add_action('widgets_init', 'mobilizon_connector_register_events_list_widget');

function mobilizon_connector_initialize_blocks() {
  wp_register_script(MobilizonConnector\NAME . '-block-starter', plugins_url('front/block-events-loader.js', __FILE__ ), [
      'wp-blocks',
      'wp-components',
      'wp-editor',
      'wp-i18n'
    ]);
  register_block_type(MobilizonConnector\NAME . '/events-list', [
    'editor_script' => MobilizonConnector\NAME . '-block-starter'
  ]);
}
add_action('init', 'mobilizon_connector_initialize_blocks');
