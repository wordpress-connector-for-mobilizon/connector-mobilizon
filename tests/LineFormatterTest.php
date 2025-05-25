<?php
declare(strict_types=1);

use MobilizonConnector\LineFormatter;
use PHPUnit\Framework\TestCase;

final class LineFormatterTest extends TestCase
{
  public function testCanDateFormatOneDate(): void {
    $this->assertSame('15/04/2021 10:30 - 15:30', LineFormatter::format_date_time(new \DateTimeZone('UTC'), '2021-04-15T10:30:00Z', '2021-04-15T15:30:00Z', false));
  }

  public function testCanDateFormatOneDateWithOffset(): void {
    $this->assertSame('15/04/2021 10:30 - 15:30 (UTC)', LineFormatter::format_date_time(new \DateTimeZone('UTC'), '2021-04-15T10:30:00Z', '2021-04-15T15:30:00Z', true));
  }

  public function testCanDateFormatOneDateWithTimeZoneOffset(): void {
    $this->assertSame('15/04/2021 11:30 - 16:30', LineFormatter::format_date_time(new \DateTimeZone('+01:00'), '2021-04-15T10:30:00Z', '2021-04-15T15:30:00Z', false));
  }

  public function testCanDateFormatTwoDates(): void {
    $this->assertSame('15/04/2021 10:30 - 16/04/2021 15:30', LineFormatter::format_date_time(new \DateTimeZone('UTC'), '2021-04-15T10:30:00Z', '2021-04-16T15:30:00Z', false));
  }

  public function testCanDateFormatTwoDatesWithOffset(): void {
    $this->assertSame('15/04/2021 10:30 - 16/04/2021 15:30 (UTC)', LineFormatter::format_date_time(new \DateTimeZone('UTC'), '2021-04-15T10:30:00Z', '2021-04-16T15:30:00Z', true));
  }

  public function testCanDateFormatWhenSecondDateIsNull(): void {
    $this->assertSame('15/04/2021 10:30', LineFormatter::format_date_time(new \DateTimeZone('UTC'), '2021-04-15T10:30:00Z', null, false));
  }

  public function testCanDateFormatWhenSecondDateIsNullWithOffset(): void {
    $this->assertSame('15/04/2021 10:30 (UTC)', LineFormatter::format_date_time(new \DateTimeZone('UTC'), '2021-04-15T10:30:00Z', null, true));
  }

  public function testCanLocationFormatBothParameters(): void {
    $this->assertSame('a, b', LineFormatter::format_location('a', 'b'));
  }

  public function testLocationFormatDescriptionOnly(): void {
    $this->assertSame('a', LineFormatter::format_location('a', ''));
  }

  public function testLocationFormatDescriptionOnlyWithNull(): void {
    $this->assertSame('a', LineFormatter::format_location('a', null));
  }

  public function testLocationFormatDescriptionWithSpaceOnly(): void {
    $this->assertSame('', LineFormatter::format_location(' ', ''));
  }

  public function testLocationFormatLocalityOnly(): void {
    $this->assertSame('a', LineFormatter::format_location('', 'a'));
  }
}
