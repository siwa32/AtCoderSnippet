<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../snippets/math.php";

class MathTest extends TestCase
{
    function setUp(): void
    {
        parent::setUp();
    }

    function tearDown(): void
    {
        parent::tearDown();
    }

    function testIntdivCeil()
    {
        self::assertThat(intdiv_ceil(3, 2), self::equalTo(2));
        self::assertThat(intdiv_ceil(0, 2), self::equalTo(0));
        self::assertThat(intdiv_ceil(12, 2), self::equalTo(6));
        self::assertThat(intdiv_ceil(124334456463, 13), self::equalTo(9564188959));
        self::assertThat(intdiv_ceil(1, 999999999999999999), self::equalTo(1));
        self::assertThat(intdiv_ceil(999999999999999999, 999999999999999999), self::equalTo(1));
        self::assertThat(intdiv_ceil(999999999999999999, 1), self::equalTo(999999999999999999));
        self::assertThat(intdiv_ceil(99999999999999999 * 3 + 1, 3), self::equalTo(99999999999999999 + 1));
        self::assertThat(intdiv_ceil(1, PHP_INT_MAX - 1), self::equalTo(1));
        self::assertThat(intdiv_ceil(PHP_INT_MAX - 1, 1), self::equalTo(PHP_INT_MAX - 1));
    }

}
