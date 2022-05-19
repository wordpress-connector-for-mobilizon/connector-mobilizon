<?php
use PHPUnit\Framework\TestCase;

final class FormatterTest extends TestCase
{
  public function testCanDateFormatOneDate(): void {
    $this->assertEquals('15/04/2021 10:30 - 15:30', Formatter::format_date('en-GB', 'UTC', '2021-04-15T10:30:00Z', '2021-04-15T15:30:00Z', false));
  }

  public function testCanDateFormatOneDateWithOffset(): void {
    $this->assertEquals('15/04/2021 10:30 - 15:30 (0)', Formatter::format_date('en-GB', 'UTC', '2021-04-15T10:30:00Z', '2021-04-15T15:30:00Z', true));
  }
  
  public function testCanDateFormatTwoDates(): void {
    $this->assertEquals('15/04/2021 10:30 - 16/04/2021 15:30', Formatter::format_date('en-GB', 'UTC', '2021-04-15T10:30:00Z', '2021-04-16T15:30:00Z', false));
  }
  
  public function testCanDateFormatTwoDatesWithOffset(): void {
    $this->assertEquals('15/04/2021 10:30 - 16/04/2021 15:30 (0)', Formatter::format_date('en-GB', 'UTC', '2021-04-15T10:30:00Z', '2021-04-16T15:30:00Z', true));
  }
  
  public function testCanDateFormatWhenSecondDateIsNull(): void {
    $this->assertEquals('15/04/2021 10:30', Formatter::format_date('en-GB', 'UTC', '2021-04-15T10:30:00Z', null, false));
  }
  
  public function testCanDateFormatWhenSecondDateIsNullWithOffset(): void {
    $this->assertEquals('15/04/2021 10:30 (0)', Formatter::format_date('en-GB', 'UTC', '2021-04-15T10:30:00Z', null, true));
  }

  public function testCanLocationFormatBothParameters(): void {
    $this->assertEquals('a, b', Formatter::format_location('a', 'b'));
  }

  public function testLocationFormatDescriptionOnly(): void {
    $this->assertEquals('a', Formatter::format_location('a', ''));
  }

  public function testLocationFormatDescriptionWithSpaceOnly() {
    $this->assertEquals('', Formatter::format_location(' ', ''));
  }

  public function testLocationFormatLocalityOnly(): void {
    $this->assertEquals('a', Formatter::format_location('', 'a'));
  }
}
