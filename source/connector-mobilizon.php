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

require_once __DIR__ . '/includes/exceptions/GeneralException.php';
require_once __DIR__ . '/includes/exceptions/GroupNotFoundException.php';
require_once __DIR__ . '/includes/Constants.php';
require_once __DIR__ . '/includes/Api.php';
require_once __DIR__ . '/includes/EventsCache.php';
require_once __DIR__ . '/includes/Settings.php';
require_once __DIR__ . '/includes/DateTimeWrapper.php';
require_once __DIR__ . '/includes/Formatter.php';
require_once __DIR__ . '/includes/GraphQlClient.php';
require_once __DIR__ . '/includes/EventsListBlock.php';
require_once __DIR__ . '/includes/EventsListShortcut.php';
require_once __DIR__ . '/includes/EventsListWidget.php';

// Exit if this file is called directly.
if (!defined('ABSPATH')) {
  exit;
}

final class Mobilizon_Connector {

  private function __construct() {
    add_action('init', [$this, 'register_api']);
    add_action('init', [$this, 'register_blocks']);
    add_action('init', [$this, 'register_settings'], 1); // required for register_blocks
    add_action('init', [$this, 'register_shortcut']);
    add_action('widgets_init', [$this, 'register_widget']);
    register_activation_hook(__FILE__, [$this, 'enable_activation']);
    add_filter('plugin_action_links_connector-mobilizon/connector-mobilizon.php', [$this, 'add_donation_link_to_plugins_page']);
    add_filter('plugin_action_links_connector-mobilizon/connector-mobilizon.php', [$this, 'add_settings_link_to_plugins_page']);
  }

  public static function init() {
    // Create singleton instance.
    static $instance = false;
    if(!$instance) {
        $instance = new self();
    }
    return $instance;
  }

  public function add_donation_link_to_plugins_page(array $links) {
    $url = esc_url('<wordpress-donation-link>');
    $settings_link = "<a href='$url'>" . esc_html__('Donate', 'connector-mobilizon') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
  }

  public function add_settings_link_to_plugins_page(array $links) {
    $url = esc_url(
      add_query_arg(
        'page',
        'connector-mobilizon-settings',
        get_admin_url() . 'options-general.php'
      )
    );
    $settings_link = "<a href='$url'>" . esc_html__('Settings', 'connector-mobilizon') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
  }

  public function enable_activation() {
    MobilizonConnector\Settings::setDefaultOptions();
  }

  private function load_settings_globally_before_script($scriptName) {
    $settings = array(
      'isShortOffsetNameShown' => MobilizonConnector\Settings::isShortOffsetNameShown(),
      'locale' => str_replace('_', '-', get_locale()),
      'timeZone' => wp_timezone_string(),
      'url' => MobilizonConnector\Settings::getUrl()
    );
    wp_add_inline_script($scriptName, 'var MOBILIZON_CONNECTOR = ' . json_encode($settings), 'before');
  }

  public function register_api() {
    MobilizonConnector\Api::init();
  }

  public function register_blocks() {
    $scriptName = MobilizonConnector\EventsListBlock::initAndReturnScriptName();
    $this->load_settings_globally_before_script($scriptName);
  }

  public function register_settings() {
    MobilizonConnector\Settings::init();
  }

  public function register_shortcut() {
    MobilizonConnector\EventsListShortcut::init();
  }

  public function register_widget() {
    register_widget('MobilizonConnector\EventsListWidget');
  }
}

function mobilizon_connector_run_plugin() {
  return Mobilizon_Connector::init();
}

mobilizon_connector_run_plugin();
