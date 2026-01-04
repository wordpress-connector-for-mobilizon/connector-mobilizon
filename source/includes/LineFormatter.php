<?php
namespace MobilizonConnector;

// Exit if this file is called directly.
if (!defined('ABSPATH')) {
  exit;
}

final class LineFormatter
{
  public static function format_date_time(\DateTimeZone $timeZone, string $dateFormat, string $timeFormat, string $start, ?string $end): string {
    $startDateTime = new LocalDateTime($start, $timeZone);
    $startDate = LocalDateTimeFormatter::format($startDateTime, $dateFormat);
    $startTime = LocalDateTimeFormatter::format($startDateTime, $timeFormat);

    $dateText = $startDate . ' ' . $startTime;
    if ($end) {
      $endDateTime = new LocalDateTime($end, $timeZone);
      $endDate = LocalDateTimeFormatter::format($endDateTime, $dateFormat);
      $endTime = LocalDateTimeFormatter::format($endDateTime, $timeFormat);

      if ($startDate != $endDate) {
        $dateText .= ' - ';
        $dateText .= $endDate . ' ';
      } else {
        $dateText .= ' - ';
      }
      $dateText .= $endTime;
    }
    return $dateText;
  }

  public static function format_location(string $description, ?string $locality): string {
    $location = '';
    if ($description && trim($description)) {
      $location .= trim($description);
    }
    if ($location && $locality) {
      $location .= ', ';
    }
    if ($locality) {
      $location .= $locality;
    }
    return $location;
  }
}
