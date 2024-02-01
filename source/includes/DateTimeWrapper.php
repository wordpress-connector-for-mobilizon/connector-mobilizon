<?php
namespace MobilizonConnector;

final class DateTimeWrapper {
  private $dateTime;
  private $locale;
  private $timeZone;

  public function __construct(string $text, string $locale = 'en-GB', string $timeZone = 'utc') {
    if (!$locale) {
      $locale = 'en-GB';
    }
    if (!$timeZone) {
      $timeZone = 'utc';
    }
    $this->dateTime = new \DateTime($text);
    $this->locale = $locale;
    $this->timeZone = new \DateTimeZone($timeZone);
  }

  public function get24Time(): string {
    $formatter = \IntlDateFormatter::create($this->locale, \IntlDateFormatter::NONE, \IntlDateFormatter::SHORT, $this->timeZone);
    return $formatter->format($this->dateTime);
  }

  public function getShortDate(): string {
    $formatter = \IntlDateFormatter::create($this->locale, \IntlDateFormatter::SHORT, \IntlDateFormatter::NONE, $this->timeZone);
    return $formatter->format($this->dateTime);
  }

  public function getTimeZoneName(): string {
    return $this->timeZone->getName();
  }
}
