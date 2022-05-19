<?php
use PHPUnit\Framework\TestCase;

final class DateTimeWrapperTest extends TestCase {
  public function testCanGetShortDateForUsualDate(): void {
    $d = new DateTimeWrapper('2020-12-24T16:45:00Z');
    $this->assertEquals('24/12/2020', $d->getShortDate());
  }

  public function testCanGetShortDateForUsualDateWithTimezoneString(): void {
    $d = new DateTimeWrapper('2020-12-24T16:45:00Z', 'en-GB', 'Europe/Rome');
    $this->assertEquals('24/12/2020', $d->getShortDate());
  }

  public function testCanGetShortDateForUsualDateWithNamedOffset(): void {
    $d = new DateTimeWrapper('2020-12-24T16:45:00Z', 'en-GB', 'UTC');
    $this->assertEquals('24/12/2020', $d->getShortDate());
  }

  public function testCanGetShortDateForUsualDateWithOffset(): void {
    $d = new DateTimeWrapper('2020-12-24T16:45:00Z', 'en-GB', '+02:00');
    $this->assertEquals('24/12/2020', $d->getShortDate());
  }

  public function testCanGetShortDateForUsualDateWithEmptyTimezone(): void {
    $d = new DateTimeWrapper('2020-12-24T16:45:00Z', 'en-GB', '');
    $this->assertEquals('24/12/2020', $d->getShortDate());
  }

  public function testCanGet24TimeForUsualTime(): void {
    $d = new DateTimeWrapper('2020-12-24T16:45:00Z');
    $this->assertEquals('16:45', $d->get24Time());
  }

  public function testCanGetShortOffsetNameForUsualTime(): void {
    $d = new DateTimeWrapper('2020-12-24T16:45:00Z');
    $this->assertEquals(0, $d->getOffset()); // TODO was UTC
  }  
}
