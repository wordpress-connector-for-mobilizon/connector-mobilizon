<?php
namespace MobilizonConnector;

final class LineFormatter
{
  public static function format_date_time(string $dateFormat, string $timeFormat, string $start, ?string $end): string {
    $startDateTime = new \DateTimeImmutable($start);
    $startDate = DateTimeFormatter::format($startDateTime, $dateFormat);
    $startTime = DateTimeFormatter::format($startDateTime, $timeFormat);

    $dateText = $startDate . ' ' . $startTime;
    if ($end) {
      $endDateTime = new \DateTimeImmutable($end);
      $endDate = DateTimeFormatter::format($endDateTime, $dateFormat);
      $endTime = DateTimeFormatter::format($endDateTime, $timeFormat);

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
