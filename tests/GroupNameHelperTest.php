<?php
declare(strict_types=1);

use MobilizonConnector\GroupNameHelper;
use PHPUnit\Framework\TestCase;

final class GroupNameHelperTest extends TestCase
{
  public function testExtractAndTrimNamesHandleOneName(): void {
    $this->assertSame(array('a'), GroupNameHelper::extractAndTrimNames('a'));
  }

  public function testExtractAndTrimNamesHandleTwoNames(): void {
    $this->assertSame(array('a', 'b'), GroupNameHelper::extractAndTrimNames('a,b'));
  }
  
  public function testExtractAndTrimNamesHandleTwoNamesWithSpaces(): void {
    $this->assertSame(array('a', 'b'), GroupNameHelper::extractAndTrimNames(' a , b '));
  }
  
  public function testConvertToGroupsObjectHandleTwoNamesWithSpaces(): void {
    $this->assertSame(array(array('name' => 'a', 'url' => 'c/@a/events'), array('name' => 'b', 'url' => 'c/@b/events')), GroupNameHelper::convertToGroupsObject(array('a', 'b'), 'c'));
  }

  public function testConvertToGroupsObjectUsesDisplayNameFromMap(): void {
    $this->assertSame(
      array(array('name' => 'Group A', 'url' => 'c/@a/events')),
      GroupNameHelper::convertToGroupsObject(array('a'), 'c', array('a' => 'Group A'))
    );
  }

  public function testConvertToGroupsObjectFallsBackToHandleWhenMapValueEmpty(): void {
    $this->assertSame(
      array(array('name' => 'a', 'url' => 'c/@a/events')),
      GroupNameHelper::convertToGroupsObject(array('a'), 'c', array('a' => ''))
    );
  }

  public function testConvertToGroupsObjectFallsBackToHandleWhenKeyMissing(): void {
    $this->assertSame(
      array(array('name' => 'a', 'url' => 'c/@a/events')),
      GroupNameHelper::convertToGroupsObject(array('a'), 'c', array('b' => 'Group B'))
    );
  }
}
