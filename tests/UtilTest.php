<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../snippets/util.php";

class UtilTest extends TestCase
{
    function setUp(): void
    {
        parent::setUp();
    }

    function tearDown(): void
    {
        parent::tearDown();
    }

    function testSwap()
    {
        $a = 1;
        $b = 2;
        swap($a, $b);
        self::assertThat($a, self::equalTo(2));
        self::assertThat($b, self::equalTo(1));
    }

    function testSwap_文字列の場合()
    {
        $a = "asd";
        $b = "zxc";
        swap($a, $b);
        self::assertThat($a, self::equalTo("zxc"));
        self::assertThat($b, self::equalTo("asd"));
    }
}
