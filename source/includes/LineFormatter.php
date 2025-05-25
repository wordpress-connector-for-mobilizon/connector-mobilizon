<?php
namespace MobilizonConnector;

final class LineFormatter
{
  public static function format_date_time(\DateTimeZone $timeZone, string $dateFormat, string $timeFormat, string $start, ?string $end): string {
    $startDateTime = new LocalDateTime($start, $timeZone);
    $dateText = LocalDateTimeFormatter::format($startDateTime, $dateFormat);
    $dateText .= ' ' . LocalDateTimeFormatter::format($startDateTime, $timeFormat);
    if ($end) {
      $endDateTime = new LocalDateTime($end, $timeZone);
      if (LocalDateTimeFormatter::format($startDateTime, $dateFormat) != LocalDateTimeFormatter::format($endDateTime, $dateFormat)) {
        $dateText .= ' - ';
        $dateText .= LocalDateTimeFormatter::format($endDateTime, $dateFormat) . ' ';
      } else {
        $dateText .= ' - ';
      }
      $dateText .= LocalDateTimeFormatter::format($endDateTime, $timeFormat);
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
