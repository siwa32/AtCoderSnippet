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

    function testChangeMax_更新される場合()
    {
        $a = 0;
        self::assertThat(change_max($a, 1), self::isTrue());
        self::assertThat($a, self::equalTo(1));

        $a = -100;
        self::assertThat(change_max($a, 0), self::isTrue());
        self::assertThat($a, self::equalTo(0));
    }

    function testChangeMax_更新されない場合()
    {
        $a = 100;
        self::assertThat(change_max($a, 1), self::isFalse());
        self::assertThat($a, self::equalTo(100));

        $a = 100;
        self::assertThat(change_max($a, 100), self::isFalse());
        self::assertThat($a, self::equalTo(100));
    }

    function testChangeMin_更新される場合()
    {
        $a = 100;
        self::assertThat(change_min($a, 1), self::isTrue());
        self::assertThat($a, self::equalTo(1));

        $a = 0;
        self::assertThat(change_min($a, -1), self::isTrue());
        self::assertThat($a, self::equalTo(-1));
    }

    function testChangeMin_更新されない場合()
    {
        $a = 0;
        self::assertThat(change_min($a, 1), self::isFalse());
        self::assertThat($a, self::equalTo(0));

        $a = -100;
        self::assertThat(change_min($a, 0), self::isFalse());
        self::assertThat($a, self::equalTo(-100));

        $a = 100;
        self::assertThat(change_min($a, 100), self::isFalse());
        self::assertThat($a, self::equalTo(100));
    }
}
