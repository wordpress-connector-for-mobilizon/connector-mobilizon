<?php
namespace MobilizonConnector;

// Exit if this file is called directly.
if (!defined('ABSPATH')) {
  exit;
}

class Settings {

  private static $DEFAULT_OPTION_URL = 'https://mobilizon.fr';
  private static $PAGE_NAME = 'wordpress_mobilizon';
  private static $OPTIONS_GROUP_NAME = 'wordpress_mobilizon';
  private static $OPTION_NAME_IS_SHORT_OFFSET_NAME_SHOWN = 'wordpress_mobilizon_is_short_offset_name_shown';
  private static $OPTION_NAME_PLUGIN_VERSION = 'wordpress_mobilizon_plugin_version';
  private static $OPTION_NAME_URL = 'wordpress_mobilizon_url';
  private static $SETTING_FIELD_NAME_URL = 'wordpress_mobilizon_field_url';
  private static $SETTINGS_SECTION_NAME = 'wordpress_mobilizon_section_general';

  public static function init() {
    add_action('admin_init', 'MobilizonConnector\Settings::init_settings');
    add_action('admin_menu', 'MobilizonConnector\Settings::register_settings_page');
  }

  public static function init_settings() {
    register_setting(
      self::$OPTIONS_GROUP_NAME,
      self::$OPTION_NAME_URL,
      'MobilizonConnector\Settings::validate_field_url'
    );

    add_settings_section(
      self::$SETTINGS_SECTION_NAME,
      esc_html__('General Settings', 'connector-mobilizon'),
      '',
      self::$PAGE_NAME
    );

    add_settings_field(
      self::$SETTING_FIELD_NAME_URL,
      esc_html__('URL', 'connector-mobilizon'),
      'MobilizonConnector\Settings::output_field_url',
      self::$PAGE_NAME,
      self::$SETTINGS_SECTION_NAME,
      array(
        'label_for' => self::$SETTING_FIELD_NAME_URL
      )
    );
  }

  public static function output_field_url($args) {
    $url = self::getUrl();
    require dirname(__DIR__) . '/view/settings/url-field.php';
  }

  public static function validate_field_url($input) {
    $validated = esc_url_raw($input);
    if ($validated !== $input) {
      add_settings_error(
        self::$OPTION_NAME_URL,
        'wordpress_mobilizon_field_url_error',
        esc_html__('The URL is invalid.', 'connector-mobilizon'),
        'error'
      );
    }
    if(substr($validated, -1) == '/') {
      $validated = substr($validated, 0, strlen($validated) - 1);
    }
    return $validated;
  }

  public static function register_settings_page() {
    add_options_page(
      NICE_NAME . ' ' . esc_html__('Settings', 'connector-mobilizon'),
      NICE_NAME,
      'manage_options',
      NAME . '-settings',
      'MobilizonConnector\Settings::output_settings_page'
    );
  }

  public static function output_settings_page() {
    if (!current_user_can('manage_options')) {
      return;
    }
    require dirname(__DIR__) . '/view/settings/page.php';
  }

  public static function getUrl() {
    return get_option(self::$OPTION_NAME_URL);
  }

  public static function setDefaultOptions() {
    add_option(self::$OPTION_NAME_URL, self::$DEFAULT_OPTION_URL);
  }

  public static function deleteAllOptions() {
    delete_option(self::$OPTION_NAME_URL);
  }

  public static function removeObsoleteOptionsIfNeeded() {
    $storedPluginVersion = get_option(self::$OPTION_NAME_PLUGIN_VERSION);
    if ($storedPluginVersion !== PLUGIN_VERSION) {
      if (!$storedPluginVersion || version_compare($storedPluginVersion, '2.0.0', '<') ) {
        delete_option(self::$OPTION_NAME_IS_SHORT_OFFSET_NAME_SHOWN);
      }
      update_option(self::$OPTION_NAME_PLUGIN_VERSION, PLUGIN_VERSION);
    }    
  }

}
