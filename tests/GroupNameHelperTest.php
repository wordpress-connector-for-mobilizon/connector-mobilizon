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

  public function test_convertToGroupsObject_usesDisplayNameFromMap(): void {
    $this->assertSame(
      array(array('name' => 'Group A', 'url' => 'c/@a/events')),
      GroupNameHelper::convertToGroupsObject(array('a'), 'c', array('a' => 'Group A'))
    );
  }

  public function test_convertToGroupsObject_fallsBackToHandleWhenMapValueEmpty(): void {
    $this->assertSame(
      array(array('name' => 'a', 'url' => 'c/@a/events')),
      GroupNameHelper::convertToGroupsObject(array('a'), 'c', array('a' => ''))
    );
  }

  public function test_convertToGroupsObject_fallsBackToHandleWhenKeyMissing(): void {
    $this->assertSame(
      array(array('name' => 'a', 'url' => 'c/@a/events')),
      GroupNameHelper::convertToGroupsObject(array('a'), 'c', array('b' => 'Group B'))
    );
  }
}
