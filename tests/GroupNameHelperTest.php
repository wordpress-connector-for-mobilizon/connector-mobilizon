<?php
declare(strict_types=1);

use MobilizonConnector\GroupNameHelper;
use PHPUnit\Framework\TestCase;

final class GroupNameHelperTest extends TestCase
{
  public function testExtractAndTrimNamesHandleOneName(): void {
    $this->assertSame(['a'], GroupNameHelper::extractAndTrimNames('a'));
  }

  public function testExtractAndTrimNamesHandleTwoNames(): void {
    $this->assertSame(['a', 'b'], GroupNameHelper::extractAndTrimNames('a,b'));
  }
  
  public function testExtractAndTrimNamesHandleTwoNamesWithSpaces(): void {
    $this->assertSame(['a', 'b'], GroupNameHelper::extractAndTrimNames(' a , b '));
  }
  
  public function testConvertToGroupsObjectHandleTwoNamesWithSpaces(): void {
    $this->assertSame(
      [['name' => 'a', 'url' => 'c/@a/events'], ['name' => 'b', 'url' => 'c/@b/events']],
      GroupNameHelper::convertToGroupsObject(['a', 'b'], 'c')
    );
  }

  public function testConvertToGroupsObjectUsesDisplayNameFromMap(): void {
    $this->assertSame(
      [['name' => 'Group A', 'url' => 'c/@a/events']],
      GroupNameHelper::convertToGroupsObject(['a'], 'c', ['a' => 'Group A'])
    );
  }

  public function testConvertToGroupsObjectFallsBackToHandleWhenMapValueEmpty(): void {
    $this->assertSame(
      [['name' => 'a', 'url' => 'c/@a/events']],
      GroupNameHelper::convertToGroupsObject(['a'], 'c', ['a' => ''])
    );
  }

  public function testConvertToGroupsObjectFallsBackToHandleWhenKeyMissing(): void {
    $this->assertSame(
      [['name' => 'a', 'url' => 'c/@a/events']],
      GroupNameHelper::convertToGroupsObject(['a'], 'c', ['b' => 'Group B'])
    );
  }
}
