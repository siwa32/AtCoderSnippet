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

    function testGcd()
    {
        self::assertThat(gcd(10, 2), self::equalTo(2));
        self::assertThat(gcd(19472620, 19105), self::equalTo(5));
        self::assertThat(gcd(19, 11), self::equalTo(1));
        self::assertThat(gcd(17386, 17386), self::equalTo(17386));
        self::assertThat(gcd(1, 17386), self::equalTo(1));
        self::assertThat(gcd(17386, 1), self::equalTo(1));
    }

    function testLcm()
    {
        self::assertThat(lcm(1, 2), self::equalTo(2));
        self::assertThat(lcm(7, 1), self::equalTo(7));
        self::assertThat(lcm(6, 4), self::equalTo(12));
        self::assertThat(lcm(10, 3), self::equalTo(30));
        self::assertThat(lcm(17386, 17386), self::equalTo(17386));
        self::assertThat(lcm(111, 157), self::equalTo(111 * 157));
    }
}
