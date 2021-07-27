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

    function testArrayFlatten()
    {
        self::assertThat(array_flatten([1, 3, 5, 5, 6, 8, 10]), self::equalTo([1, 3, 5, 5, 6, 8, 10]));
        self::assertThat(array_flatten([1, [3, 5], 5, [6, 8], 10]), self::equalTo([1, 3, 5, 5, 6, 8, 10]));
        self::assertThat(array_flatten([1, [3, 5, [5, 6, 8], 10]]), self::equalTo([1, 3, 5, 5, 6, 8, 10]));
        self::assertThat(array_flatten([]), self::equalTo([]));
    }

    function testArrayCountIf_配列の要素が整数の場合()
    {
        self::assertThat(array_count_if([1, 3, 4, 7, 123, 63246, 2, 53, 1, 0, null], 1), self::equalTo(2));
        self::assertThat(array_count_if([1, 3, 4, 7, 123, 63246, 2, 53, 1, 0, null], 0), self::equalTo(1));
        self::assertThat(array_count_if([1, 3, 4, 7, 123, 63246, 2, 53, 1, 0, null], "1"), self::equalTo(0));
        self::assertThat(array_count_if([1, 3, 4, 7, 123, 63246, 2, 53, 1, 0, null], -8), self::equalTo(0));
        self::assertThat(array_count_if([1, 3, 4, 7, 123, 63246, 2, 53, 1, 0, null], 2.0), self::equalTo(0));
    }

    function testArrayCountIf_配列の要素が文字列の場合()
    {
        self::assertThat(array_count_if(["1", "3", "4", "7", "123", "63246", "2", "53", "1", "0", null], "1"), self::equalTo(2));
        self::assertThat(array_count_if(["1", "3", "4", "7", "123", "63246", "2", "53", "1", "0", null], 1), self::equalTo(0));
        self::assertThat(array_count_if(["1", "3", "4", "7", "123", "63246", "2", "53", "1", "0", null], ""), self::equalTo(0));
        self::assertThat(array_count_if(["1", "3", "4", "7", "123", "63246", "2", "53", "1", "0", null], "abc"), self::equalTo(0));
    }

    function testArrayCountIf_配列の要素が真偽値の場合()
    {
        self::assertThat(array_count_if([true, true, false, false, true], true), self::equalTo(3));
        self::assertThat(array_count_if([true, true, false, false, true], false), self::equalTo(2));
        self::assertThat(array_count_if([true, true, false, false, true], 1), self::equalTo(0));
        self::assertThat(array_count_if([true, true, false, false, true], 0), self::equalTo(0));
        self::assertThat(array_count_if([true, true, false, false, true], null), self::equalTo(0));
    }

    function testArrayCountIf_比較関数を渡す場合()
    {
        $actual = array_count_if([1, 3, 4, 7, null, 123, 63246, 2, 53, 1, 0, true], function ($item) {
            return !is_null($item) && $item < 100;
        });
        self::assertThat($actual, self::equalTo(8));
    }

}
