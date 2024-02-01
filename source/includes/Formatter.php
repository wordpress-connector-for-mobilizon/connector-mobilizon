<?php
namespace MobilizonConnector;

final class Formatter
{
  public static function format_date(string $locale, string $timeZone, string $start, ?string $end, bool $isShortOffsetNameShown): string {
    $startDateTime = new DateTimeWrapper($start, $locale, $timeZone);
    $dateText = $startDateTime->getShortDate();
    $dateText .= ' ' . $startDateTime->get24Time();
    if (!$end && $isShortOffsetNameShown) {
      $dateText .= ' (' . $startDateTime->getTimeZoneName() . ')';
    }
    if ($end) {
      $endDateTime = new DateTimeWrapper($end, $locale, $timeZone);
      if ($startDateTime->getShortDate() != $endDateTime->getShortDate()) {
        $dateText .= ' - ';
        $dateText .= $endDateTime->getShortDate() . ' ';
      } else {
        $dateText .= ' - ';
      }
      $dateText .= $endDateTime->get24Time();
      if ($isShortOffsetNameShown) {
        $dateText .= ' (' . $endDateTime->getTimeZoneName() . ')';
      }
    }
    return $dateText;
  }

  public static function format_location(string $description, string $locality): string {
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
