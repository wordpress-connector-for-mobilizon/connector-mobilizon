<?php
namespace MobilizonConnector;

final class LocalDateTimeFormatter
{
  public static function format(LocalDateTime $dateTime, string $format) {
    $timestamp = $dateTime->getValue()->getTimestamp();
    return date_i18n($format, $timestamp);
  }
}
