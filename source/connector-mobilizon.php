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

final class Mobilizon_Connector {

  private function __construct() {
    add_action('init', [$this, 'register_blocks']);
    add_action('init', [$this, 'register_settings'], 1); // required for register_blocks
    add_action('init', [$this, 'register_shortcut']);
    add_action('widgets_init', [$this, 'register_widget']);
    add_action('wp_enqueue_scripts', [$this, 'register_scripts']);
    register_activation_hook(__FILE__, [$this, 'enable_activation']);
  }

  public static function init() {
    // Create singleton instance.
    static $instance = false;
    if(!$instance) {
        $instance = new self();
    }
    return $instance;
  }

  public function enable_activation() {
    MobilizonConnector\Settings::setDefaultOptions();
  }

  public function load_settings_globally_before_script($scriptName) {
    $settings = array(
      'isShortOffsetNameShown' => MobilizonConnector\Settings::isShortOffsetNameShown(),
      'locale' => str_replace('_', '-', get_locale()),
      'timeZone' => wp_timezone_string(),
      'url' => MobilizonConnector\Settings::getUrl()
    );
    wp_add_inline_script($scriptName, 'const SETTINGS = ' . json_encode($settings), 'before'); // TODO use different name
  }

  public function register_blocks() {
    $name = MobilizonConnector\NAME . '-block-starter';
    wp_register_script($name, plugins_url('front/block-events-loader.js', __FILE__ ), [
        'wp-blocks',
        'wp-components',
        'wp-editor',
        'wp-i18n'
      ]);
    register_block_type(MobilizonConnector\NAME . '/events-list', [
      'editor_script' => $name
    ]);
    $this->load_settings_globally_before_script($name);
  }

  public function register_settings() {
    MobilizonConnector\Settings::init();
  }

  public function register_scripts() {
    $name = MobilizonConnector\NAME . '-js';
    wp_enqueue_script($name, plugins_url('front/events-loader.js', __FILE__ ));
    $this->load_settings_globally_before_script($name);
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
