<?php
declare(strict_types=1);

use MobilizonConnector\LocalDateTime;
use PHPUnit\Framework\TestCase;

final class LocalDateTimeTest extends TestCase {
  public function testCanGet24TimeForUsualTime(): void {
    $d = new LocalDateTime('2020-12-24T16:45:00Z', new DateTimeZone("utc"));
    $this->assertEquals(new DateTimeImmutable('2020-12-24T16:45:00Z'), $d->getValue());
  }
}
