<?php
namespace MobilizonConnector;

final class LocalDateTime {
  private $dateTime;

  public function __construct(string $dateTimeString, \DateTimeZone $timeZone) {
    $date = new \DateTimeImmutable($dateTimeString);
    $this->dateTime = $date->setTimezone($timeZone);
  }

  public function getValue() {
    return $this->dateTime;
  }
}
