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
require_once __DIR__ . '/includes/date-time-wrapper.php';
require_once __DIR__ . '/includes/formatter.php';
require_once __DIR__ . '/includes/graphql-client.php';
require_once __DIR__ . '/includes/events-list-shortcut.php';
require_once __DIR__ . '/includes/events-list-widget.php';

// Exit if this file is called directly.
if (!defined('ABSPATH')) {
  exit;
}

final class Mobilizon_Connector {

  private function __construct() {
    add_action('init', [$this, 'register_settings']);
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

  public function register_settings() {
    MobilizonConnector\Settings::init();
  }

  public function register_scripts() {
    wp_enqueue_script(MobilizonConnector\NAME . '-js', plugins_url('front/events-loader.js', __FILE__ ));
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
