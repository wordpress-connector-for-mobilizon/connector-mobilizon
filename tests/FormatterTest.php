<?php
declare(strict_types=1);

use MobilizonConnector\Formatter;
use PHPUnit\Framework\TestCase;

final class FormatterTest extends PHPUnit\Framework\TestCase
{
  public function testCanDateFormatOneDate(): void {
    $this->assertSame('15/04/2021 10:30 - 15:30', Formatter::format_date('en-GB', 'UTC', '2021-04-15T10:30:00Z', '2021-04-15T15:30:00Z', false));
  }

  public function testCanDateFormatOneDateWithOffset(): void {
    $this->assertSame('15/04/2021 10:30 - 15:30 (UTC)', Formatter::format_date('en-GB', 'UTC', '2021-04-15T10:30:00Z', '2021-04-15T15:30:00Z', true));
  }

  public function testCanDateFormatOneDateWithTimeZoneOffset(): void {
    $this->assertSame('15/04/2021 11:30 - 16:30', Formatter::format_date('en-GB', '+01:00', '2021-04-15T10:30:00Z', '2021-04-15T15:30:00Z', false));
  }

  public function testCanDateFormatTwoDates(): void {
    $this->assertSame('15/04/2021 10:30 - 16/04/2021 15:30', Formatter::format_date('en-GB', 'UTC', '2021-04-15T10:30:00Z', '2021-04-16T15:30:00Z', false));
  }

  public function testCanDateFormatTwoDatesWithOffset(): void {
    $this->assertSame('15/04/2021 10:30 - 16/04/2021 15:30 (UTC)', Formatter::format_date('en-GB', 'UTC', '2021-04-15T10:30:00Z', '2021-04-16T15:30:00Z', true));
  }

  public function testCanDateFormatWhenSecondDateIsNull(): void {
    $this->assertSame('15/04/2021 10:30', Formatter::format_date('en-GB', 'UTC', '2021-04-15T10:30:00Z', null, false));
  }

  public function testCanDateFormatWhenSecondDateIsNullWithOffset(): void {
    $this->assertSame('15/04/2021 10:30 (UTC)', Formatter::format_date('en-GB', 'UTC', '2021-04-15T10:30:00Z', null, true));
  }

  public function testCanLocationFormatBothParameters(): void {
    $this->assertSame('a, b', Formatter::format_location('a', 'b'));
  }

  public function testLocationFormatDescriptionOnly(): void {
    $this->assertSame('a', Formatter::format_location('a', ''));
  }

  public function testLocationFormatDescriptionWithSpaceOnly(): void {
    $this->assertSame('', Formatter::format_location(' ', ''));
  }

  public function testLocationFormatLocalityOnly(): void {
    $this->assertSame('a', Formatter::format_location('', 'a'));
  }
}
