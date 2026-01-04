<?php
namespace MobilizonConnector;

// Exit if this file is called directly.
if (!defined('ABSPATH')) {
  exit;
}

final class LocalDateTimeFormatter
{
  public static function format(LocalDateTime $dateTime, string $format) {
    $timestamp = $dateTime->getValue()->getTimestamp();
    $offset = $dateTime->getValue()->getOffset();
    $timestampWithOffset = $timestamp + $offset;
    return date_i18n($format, $timestampWithOffset);
  }
}
