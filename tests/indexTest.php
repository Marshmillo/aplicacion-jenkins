<?php
use PHPUnit\Framework\TestCase;
require_once "src/index.php";

class IndexTest extends TestCase
{
  public function testGreet() {
    global $full_name;
    $expected = "Hello $full_name!";
    $actual = greet($full_name);
    $this->assertEquals($expected, $actual);
    }
}