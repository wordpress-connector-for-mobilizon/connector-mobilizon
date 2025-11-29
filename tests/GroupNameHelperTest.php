<?php
declare(strict_types=1);

use MobilizonConnector\GroupNameHelper;
use PHPUnit\Framework\TestCase;

final class GroupNameHelperTest extends TestCase
{
  public function test_extractAndTrimNames_handleOneName(): void {
    $this->assertSame(array('a'), GroupNameHelper::extractAndTrimNames('a'));
  }

  public function test_extractAndTrimNames_handleTwoNames(): void {
    $this->assertSame(array('a', 'b'), GroupNameHelper::extractAndTrimNames('a,b'));
  }
  
  public function test_extractAndTrimNames_handleTwoNamesWithSpaces(): void {
    $this->assertSame(array('a', 'b'), GroupNameHelper::extractAndTrimNames(' a , b '));
  }
  
  public function test_convertToGroupsObject_handleTwoNamesWithSpaces(): void {
    $this->assertSame(array(array('name' => 'a', 'url' => 'c/@a/events'), array('name' => 'b', 'url' => 'c/@b/events')), GroupNameHelper::convertToGroupsObject(array('a', 'b'), 'c'));
  }
}
