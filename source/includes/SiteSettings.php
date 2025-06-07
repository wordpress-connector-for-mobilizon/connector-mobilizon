<?php
namespace MobilizonConnector;

class SiteSettings {

  private static $OPTION_NAME_DATE_FORMAT = 'date_format';
  private static $OPTION_NAME_TIME_FORMAT = 'time_format';

  public static function getDateFormat() {
    return get_option(self::$OPTION_NAME_DATE_FORMAT);
  }

  public static function getTimeFormat() {
    return get_option(self::$OPTION_NAME_TIME_FORMAT);
  }

  public static function getTimeZone() {
    return wp_timezone();
  }

}
