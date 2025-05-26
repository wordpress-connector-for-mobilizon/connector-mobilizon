<?php
declare(strict_types=1);

use MobilizonConnector\LineFormatter;
use PHPUnit\Framework\TestCase;

function date_i18n(string $format, int $timestamp) {
  // Mock WordPress function.
  if ($format == 'H:i') {
    if ($timestamp == 1618482600) {
      return '10:30';
    } else if ($timestamp == 1618500600 || $timestamp == 1618587000) {
      return '15:30';
    }
  } else if ($format == 'd/m/Y') {
    if ($timestamp == 1618482600 || $timestamp == 1618500600) {
      return '15/04/2021';
    } else if ($timestamp == 1618587000) {
      return '16/04/2021';
    }
  }
  return '';
}

final class LineFormatterTest extends TestCase
{
  public function testCanDateFormatOneDate(): void {
    $this->assertSame('15/04/2021 10:30 - 15:30', LineFormatter::format_date_time(new \DateTimeZone('UTC'), 'd/m/Y', 'H:i', '2021-04-15T10:30:00Z', '2021-04-15T15:30:00Z'));
  }

  public function testCanDateFormatTwoDates(): void {
    $this->assertSame('15/04/2021 10:30 - 16/04/2021 15:30', LineFormatter::format_date_time(new \DateTimeZone('UTC'), 'd/m/Y', 'H:i', '2021-04-15T10:30:00Z', '2021-04-16T15:30:00Z'));
  }

  public function testCanDateFormatWhenSecondDateIsNull(): void {
    $this->assertSame('15/04/2021 10:30', LineFormatter::format_date_time(new \DateTimeZone('UTC'), 'd/m/Y', 'H:i', '2021-04-15T10:30:00Z', null));
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
