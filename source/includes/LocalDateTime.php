<?php
namespace MobilizonConnector;

final class LocalDateTime {
  private $dateTime;

  public function __construct(string $text, \DateTimeZone $timeZone) {
    $date = new \DateTimeImmutable($text);
    $this->dateTime = $date->setTimezone($timeZone);
  }

  public function getValue() {
    return $this->dateTime;
  }
}
