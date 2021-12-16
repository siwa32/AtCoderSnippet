<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../snippets/PrimeChecker.php";

class PrimeCheckerTest extends TestCase
{
    function setUp(): void
    {
        parent::setUp();
    }

    function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @covers PrimeChecker::isPrime
     * @covers PrimeChecker::__construct
     * @covers PrimeChecker::makeInit
     */
    public function testIsPrime_素数()
    {
        $target = new PrimeChecker(5000000);

        self::assertThat($target->isPrime(2), self::isTrue(), "素数");
        self::assertThat($target->isPrime(3), self::isTrue(), "素数");
        self::assertThat($target->isPrime(5), self::isTrue(), "素数");
        self::assertThat($target->isPrime(7), self::isTrue(), "素数");
        self::assertThat($target->isPrime(11), self::isTrue(), "素数");
        self::assertThat($target->isPrime(97), self::isTrue(), "素数");
        self::assertThat($target->isPrime(683), self::isTrue(), "素数");
        self::assertThat($target->isPrime(2311), self::isTrue(), "素数");
        self::assertThat($target->isPrime(3571), self::isTrue(), "素数");
    }

    /**
     * @covers PrimeChecker::isPrime
     */
    public function testIsPrime_素数ではない()
    {
        $target = new PrimeChecker(5000000);

        self::assertThat($target->isPrime(1), self::isFalse(), "素数では無い");
        self::assertThat($target->isPrime(0), self::isFalse(), "素数では無い");
        self::assertThat($target->isPrime(-1), self::isFalse(), "素数では無い");
        self::assertThat($target->isPrime(36), self::isFalse(), "素数では無い");
        self::assertThat($target->isPrime(106834), self::isFalse(), "素数では無い");
        self::assertThat($target->isPrime(5000000), self::isFalse(), "素数では無い");
    }

    /**
     * @covers PrimeChecker::primes
     */
    public function testPrimes_1000以下の素数()
    {
        $target = new PrimeChecker(1000);

        $expected = [
            2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67, 71, 73, 79, 83, 89, 97,
            101, 103, 107, 109, 113, 127, 131, 137, 139, 149, 151, 157, 163, 167, 173, 179, 181, 191, 193, 197, 199,
            211, 223, 227, 229, 233, 239, 241, 251, 257, 263, 269, 271, 277, 281, 283, 293,
            307, 311, 313, 317, 331, 337, 347, 349, 353, 359, 367, 373, 379, 383, 389, 397,
            401, 409, 419, 421, 431, 433, 439, 443, 449, 457, 461, 463, 467, 479, 487, 491, 499,
            503, 509, 521, 523, 541, 547, 557, 563, 569, 571, 577, 587, 593, 599,
            601, 607, 613, 617, 619, 631, 641, 643, 647, 653, 659, 661, 673, 677, 683, 691,
            701, 709, 719, 727, 733, 739, 743, 751, 757, 761, 769, 773, 787, 797,
            809, 811, 821, 823, 827, 829, 839, 853, 857, 859, 863, 877, 881, 883, 887,
            907, 911, 919, 929, 937, 941, 947, 953, 967, 971, 977, 983, 991, 997
        ];
        self::assertThat($target->primes(), self::equalTo($expected));
    }

    /**
     * @covers PrimeChecker::primes
     */
    public function testPrimes_2以下の素数()
    {
        $target = new PrimeChecker(2);

        $expected = [
            2
        ];
        self::assertThat($target->primes(), self::equalTo($expected));
    }

    /**
     * @covers PrimeChecker::primeFactor
     */
    public function testPrimeFactor_10000以下()
    {
        $target = new PrimeChecker(10000);

        self::assertThat($target->primeFactor(2), self::equalTo([2 => 1]));
        self::assertThat($target->primeFactor(12), self::equalTo([2 => 2, 3 => 1]));
        self::assertThat($target->primeFactor(13), self::equalTo([13 => 1]));
        self::assertThat($target->primeFactor(2 ** 13), self::equalTo([2 => 13]));
        self::assertThat($target->primeFactor((7 ** 2) * (11 ** 2)), self::equalTo([7 => 2, 11 => 2]));
        self::assertThat($target->primeFactor(10000), self::equalTo([2 => 4, 5 => 4]));
    }

    /**
     * @covers PrimeChecker::primeFactor
     */
    public function testPrimeFactor_10000000以下()
    {
        $target = new PrimeChecker(10000000);

        for ($i = 1; $i < 100; ++$i) {
            if (2 ** $i > 10000000) {
                break;
            }
            self::assertThat($target->primeFactor(2 ** $i), self::equalTo([2 => $i]));
        }
        for ($i = 1; $i < 100; ++$i) {
            if (7 ** $i > 10000000) {
                break;
            }
            self::assertThat($target->primeFactor(7 ** $i), self::equalTo([7 => $i]));
        }
        self::assertThat($target->primeFactor(2 ** 3 * 3 ** 5 * 13 ** 2 * 23 * 1), self::equalTo([2 => 3, 3 => 5, 13 => 2, 23 => 1]));
        self::assertThat($target->primeFactor(10000000), self::equalTo([2 => 7, 5 => 7]));
    }
}
