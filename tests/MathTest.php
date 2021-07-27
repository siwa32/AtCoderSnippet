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

    function testDivisor()
    {
        self::assertThat(divisor(1), self::equalTo([1]));
        self::assertThat(divisor(2), self::equalTo([1, 2]));
        self::assertThat(divisor(36), self::equalTo([1, 2, 3, 4, 6, 9, 12, 18, 36]));
        self::assertThat(divisor(97), self::equalTo([1, 97]));

        $expect = [
            1, 2, 4, 5, 8, 10, 16, 20, 25, 32, 40, 50, 64, 80,
            100, 125, 128, 160, 200, 250, 256, 320, 400, 500, 625, 640, 800,
            1000, 1250, 1280, 1600, 2000, 2500, 3125, 3200, 4000, 5000, 6250, 6400, 8000,
            10000, 12500, 15625, 16000, 20000, 25000, 31250, 32000, 40000, 50000, 62500, 78125, 80000,
            100000, 125000, 156250, 160000, 200000, 250000, 312500, 390625, 400000, 500000, 625000, 781250, 800000,
            1000000, 1250000, 1562500, 2000000, 2500000, 3125000, 4000000, 5000000, 6250000,
            10000000, 12500000, 20000000, 25000000, 50000000,
            100000000
        ];
        self::assertThat(divisor(100000000), self::equalTo($expect));

        $expect = [
            1, 1297, 77101, 99999997
        ];
        self::assertThat(divisor(99999997), self::equalTo($expect));

        $expect = [
            1, 14902357, 67103479, 1000000000000003
        ];
        self::assertThat(divisor(1000000000000003), self::equalTo($expect));
    }

    function testIsPrime_素数()
    {
        self::assertThat(is_prime(2), self::isTrue());
        self::assertThat(is_prime(3), self::isTrue());
        self::assertThat(is_prime(5), self::isTrue());
        self::assertThat(is_prime(7), self::isTrue());
        self::assertThat(is_prime(11), self::isTrue());
        self::assertThat(is_prime(97), self::isTrue());
        self::assertThat(is_prime(683), self::isTrue());
        self::assertThat(is_prime(2311), self::isTrue());
        self::assertThat(is_prime(3571), self::isTrue());
    }

    function testIsPrime_素数ではない()
    {
        self::assertThat(is_prime(1), self::isFalse());
        self::assertThat(is_prime(0), self::isFalse());
        self::assertThat(is_prime(-1), self::isFalse());
        self::assertThat(is_prime(36), self::isFalse());
        self::assertThat(is_prime(15342392), self::isFalse());
        self::assertThat(is_prime(99999997), self::isFalse());
        self::assertThat(is_prime(1000000000000003), self::isFalse());
    }

    function testPrimeFactor()
    {
        self::assertThat(prime_factor(2), self::equalTo([2 => 1]));
        self::assertThat(prime_factor(12), self::equalTo([2 => 2, 3 => 1]));
        self::assertThat(prime_factor(13), self::equalTo([13 => 1]));
        self::assertThat(prime_factor(93527), self::equalTo([7 => 1, 31 => 1, 431 => 1]));
        self::assertThat(prime_factor(3439198374012), self::equalTo([2 => 2, 3 => 3, 617 => 1, 51611717 => 1]));
        self::assertThat(prime_factor(1000000000000), self::equalTo([2 => 12, 5 => 12]));
    }
}
