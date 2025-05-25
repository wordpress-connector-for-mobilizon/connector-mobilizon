<?php
declare(strict_types=1);

use MobilizonConnector\LocalDateTime;
use MobilizonConnector\LocalDateTimeFormatter;
use PHPUnit\Framework\TestCase;

final class LocalDateTimeFormatterTest extends TestCase
{
  public function testCanFormatDate(): void {
    $this->assertSame('15 April 2021', LocalDateTimeFormatter::format(new LocalDateTime('2021-04-15T10:30:00Z', new DateTimeZone("utc")), 'j F Y'));
  }

  public function testCanFormatTime(): void {
    $this->assertSame('10:30', LocalDateTimeFormatter::format(new LocalDateTime('2021-04-15T10:30:00Z', new DateTimeZone("utc")), 'H:i'));
  }
}
