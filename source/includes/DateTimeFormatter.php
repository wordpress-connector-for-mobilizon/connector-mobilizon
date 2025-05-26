<?php
namespace MobilizonConnector;

final class DateTimeFormatter
{
  public static function format(\DateTimeImmutable $dateTime, string $format) {
    $timestamp = $dateTime->getTimestamp();
    return date_i18n($format, $timestamp);
  }
}
