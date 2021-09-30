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
        self::assertThat(gcd(0, 17386), self::equalTo(17386));
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

    function testXPow()
    {
        self::assertThat(xpow(36382334237429, 0), self::equalTo(1));
        self::assertThat(xpow(0, 1), self::equalTo(0));
        self::assertThat(xpow(2, 10), self::equalTo(2 ** 10));
        self::assertThat(xpow(1, 12342361729), self::equalTo(1));
        self::assertThat(xpow(2, 32), self::equalTo(2 ** 32));
        self::assertThat(xpow(11, 9), self::equalTo(11 ** 9));
        self::assertThat(xpow(3246, 5), self::equalTo(3246 ** 5));
        self::assertThat(xpow(-1, 32673276), self::equalTo(1));
        self::assertThat(xpow(-1, 32673277), self::equalTo(-1));
        self::assertThat(xpow(-2, 10), self::equalTo((-2) ** 10));
        self::assertThat(xpow(-5, 21), self::equalTo((-5) ** 21));
    }

    function testXPowMod()
    {
        self::assertThat(xpow_mod(36382334237429, 0, 1000000007), self::equalTo(1));
        self::assertThat(xpow_mod(0, 1, 1000000007), self::equalTo(0));
        self::assertThat(xpow_mod(2, 10, 7), self::equalTo(2));
        self::assertThat(xpow_mod(1, 12342361729, 1000000007), self::equalTo(1));
        self::assertThat(xpow_mod(2, 32, 8), self::equalTo(0));
        self::assertThat(xpow_mod(11, 9, 13), self::equalTo((11 ** 9) % 13));
        self::assertThat(xpow_mod(3246, 5, 3), self::equalTo((3246 ** 5) % 3));
        self::assertThat(xpow_mod(-1, 32673276, 3), self::equalTo(1));
        self::assertThat(xpow_mod(-1, 32673277, 3), self::equalTo(-1));
        self::assertThat(xpow_mod(-2, 10, 3), self::equalTo(((-2) ** 10) % 3));
        self::assertThat(xpow_mod(-5, 21, 3), self::equalTo(((-5) ** 21) % 3));
        self::assertThat(xpow_mod(7844007021201716725, 1000000005, 1000000007), self::equalTo(6685840));
    }

    function testNCk()
    {
        self::assertThat(nCk(31, 12, PHP_INT_MAX), self::equalTo(141120525));
        self::assertThat(nCk(316, 10, PHP_INT_MAX), self::equalTo(2369369738881102958));
        self::assertThat(nCk(43, 2, PHP_INT_MAX), self::equalTo(43 * 42 / 2));
        self::assertThat(nCk(31, 12, 997), self::equalTo(141120525 % 997));
        self::assertThat(nCk(316, 10, 1000000007), self::equalTo(2369369738881102958 % 1000000007));
        self::assertThat(nCk(43, 2, 100), self::equalTo((43 * 42 / 2) % 100));

        self::assertThat(nCk(0, 0, PHP_INT_MAX), self::equalTo(1));
        self::assertThat(nCk(16417239, 0, PHP_INT_MAX), self::equalTo(1));
        self::assertThat(nCk(1242353636, 1242353636, PHP_INT_MAX), self::equalTo(1));
        self::assertThat(nCk(51936102, 1, PHP_INT_MAX), self::equalTo(51936102));
        self::assertThat(nCk(0, 0, 1000000007), self::equalTo(1));
        self::assertThat(nCk(16417239, 0,1000000007 ), self::equalTo(1));
        self::assertThat(nCk(1242353636, 1242353636, 1000000007), self::equalTo(1));
        self::assertThat(nCk(51936102, 1, 997), self::equalTo(51936102 % 997));
    }

    function testNC2()
    {
        self::assertThat(nC2(1), self::equalTo(0));
        self::assertThat(nC2(2), self::equalTo(1));
        self::assertThat(nC2(31), self::equalTo(31 * 30 / 2));
        self::assertThat(nC2(100000000), self::equalTo(100000000 * 99999999 / 2));
        self::assertThat(nC2(2 ** 32), self::equalTo((2 ** 32) / 2 * (2 ** 32 - 1)));
        self::assertThat(nC2(2 ** 32 - 1), self::equalTo((2 ** 32 - 1) * (2 ** 32 - 2) / 2));
    }

    function testNCkModPrime()
    {
        $testCases = [
            [1, 1, 1],
            [1000000000, 0, 1],
            [100000000, 100, 501016086],
            [1000000000, 1000, 624274358],
            [746384163, 41268, 251861790],
            [1000000000, 1, 1000000000],
            [1000000000, 10000, 514182778],
            [999999999, 50000, 429939171],
            [1000000000, 10000000, 845332812],
        ];
        foreach ($testCases as $testCase) {
            [$n, $k, $expected] = $testCase;
            self::assertThat(nCk_mod_prime($n, $k, 1000000007), self::equalTo($expected));
        }
    }

    function testNPk()
    {
        self::markTestIncomplete();
    }

    function testFactorial()
    {
        self::assertThat(factorial(1, PHP_INT_MAX), self::equalTo(1));
        self::assertThat(factorial(2, PHP_INT_MAX), self::equalTo(2));
        self::assertThat(factorial(10, PHP_INT_MAX), self::equalTo(3628800));
        self::assertThat(factorial(20, PHP_INT_MAX), self::equalTo(2432902008176640000));
        self::assertThat(factorial(9388776, 1000000007), self::equalTo(561783844));
        self::assertThat(factorial(10000000, 1000000007), self::equalTo(682498929));
    }

    function testSumAtoB()
    {
        self::assertThat(sum_AtoB(1, 10), self::equalTo(55));
        self::assertThat(sum_AtoB(-4, 10), self::equalTo(45));
        self::assertThat(sum_AtoB(-10, -1), self::equalTo(-55));
        self::assertThat(sum_AtoB(100, 107), self::equalTo(828));
        self::assertThat(sum_AtoB(1, 1000000000), self::equalTo(500000000500000000));
        self::assertThat(sum_AtoB(1, 4294967295), self::equalTo(9223372034707292160));
    }

    function testSumAtoB_開始と終了が同じ場合()
    {
        self::assertThat(sum_AtoB(1, 1), self::equalTo(1));
        self::assertThat(sum_AtoB(1000000000000, 1000000000000), self::equalTo(1000000000000));
        self::assertThat(sum_AtoB(0, 0), self::equalTo(0));
        self::assertThat(sum_AtoB(-1426362340, -1426362340), self::equalTo(-1426362340));
    }

    function testSumAtoBMod()
    {
        $mod = 10 ** 9 + 7;
        self::assertThat(sum_AtoB_mod(1, 10, 2), self::equalTo(1));
        self::assertThat(sum_AtoB_mod(-4, 10, 3), self::equalTo(0));
        self::assertThat(sum_AtoB_mod(-10, -1, $mod), self::equalTo(-55));
        self::assertThat(sum_AtoB_mod(100, 107, $mod), self::equalTo(828));
        self::assertThat(sum_AtoB_mod(1, 1000000000, $mod), self::equalTo(500000000500000000 % $mod));
        self::assertThat(sum_AtoB_mod(1, 4294967295, $mod), self::equalTo(9223372034707292160 % $mod));
    }

    function testSumAP()
    {
        self::assertThat(sum_ap(1, 10, 2), self::equalTo(100));
        self::assertThat(sum_ap(77, 21, -4), self::equalTo(777));
        self::assertThat(sum_ap(4, 409930701, 11), self::equalTo(924237487308036654));
    }

    function testSumAP_公差が1()
    {
        self::assertThat(sum_ap(1, 10, 1), self::equalTo(55));
        self::assertThat(sum_ap(-4, 15, 1), self::equalTo(45));
        self::assertThat(sum_ap(-10, 10, 1), self::equalTo(-55));
        self::assertThat(sum_ap(100, 8, 1), self::equalTo(828));
        self::assertThat(sum_ap(1, 1000000000, 1), self::equalTo(500000000500000000));
        self::assertThat(sum_ap(1, 4294967295, 1), self::equalTo(9223372034707292160));
    }

    function testSumAP_公差が0()
    {
        self::assertThat(sum_ap(1, 1000, 0), self::equalTo(1000));
        self::assertThat(sum_ap(678, 1000, 0), self::equalTo(678000));
        self::assertThat(sum_ap(-45, 1000, 0), self::equalTo(-45000));
    }

    function testSumAP_公数が1()
    {
        self::assertThat(sum_ap(1, 1, 4), self::equalTo(1));
        self::assertThat(sum_ap(3579733, 1, 4), self::equalTo(3579733));
        self::assertThat(sum_ap(-3533, 1, 4), self::equalTo(-3533));
    }

    function testSumAP_公数が0()
    {
        self::assertThat(sum_ap(1, 0, 4), self::equalTo(0));
        self::assertThat(sum_ap(3579733, 0, 4), self::equalTo(0));
        self::assertThat(sum_ap(-3533, 0, 4), self::equalTo(0));
    }

    function testGcdExt()
    {
        $x = $y = 0;
        self::assertThat(gcd_ext(48, 32, $x, $y), self::equalTo(16));
        self::assertThat($x, self::equalTo(1));
        self::assertThat($y, self::equalTo(-1));

        self::assertThat(gcd_ext(4122987234, 10 ** 9 + 7, $x, $y), self::equalTo(1));
        self::assertThat($x, self::equalTo(369426681));
        self::assertThat($y, self::equalTo(-1523141479));

        self::assertThat(gcd_ext(0, 32, $x, $y), self::equalTo(32));
        self::assertThat($x, self::equalTo(0));
        self::assertThat($y, self::equalTo(1));
    }

    function testInvertMod()
    {
        $testCases = [
            [1082396814608512382, 1000000007, 224931341],
            [6413641274691060162, 1000000007, 760482925],
            [2875776427995232122, 1000000007, 969716810],
            [5810373188433159683, 1000000007, 394978623],
            [7840560892044184555, 1000000007, 206522991],
            [8466510191643191251, 1000000007, 64022179],
            [1000000007, 17243, 4068],
            [1000000007, 36964, 23515],
            [1000000007, 99920, 6023],
            [1000000007, 6246386609709379669, 4285395355313561777],
            [1000000007, 770691046837931757, 191401036907760035],
            [1000000007, 3484321914187639107, 1801768880583066914],
            [36964, 991, 327],
            [12189, 991, 327],
            [99920, 991, 736],
            [89255, 991, 61],
            [50089, 991, 524],
            [47570, 991, 496],
            [123491, 2, 1],
            [43783, 3, 1],
        ];
        foreach ($testCases as $testCase) {
            [$x, $mod, $expected] = $testCase;
            self::assertThat(invert_mod($x, $mod), self::equalTo($expected));
        }
    }

    function testInvertMod_逆元が無い場合()
    {
        self::assertThat(invert_mod(7638877640969221628, 54478), self::equalTo(0));
        self::assertThat(invert_mod(54478, 7638877640969221628), self::equalTo(0));
        self::assertThat(invert_mod(5827554886110048175, 60116), self::equalTo(0));
        self::assertThat(invert_mod(60116, 5827554886110048175), self::equalTo(0));
        self::assertThat(invert_mod(1000000007, 1000000007), self::equalTo(0));
        self::assertThat(invert_mod(4567894, 2), self::equalTo(0));
        self::assertThat(invert_mod(2, 3456), self::equalTo(0));
    }

    function testInvertModPrime()
    {
        $testCases = [
            [1082396814608512382, 1000000007, 224931341],
            [6413641274691060162, 1000000007, 760482925],
            [2875776427995232122, 1000000007, 969716810],
            [5810373188433159683, 1000000007, 394978623],
            [7840560892044184555, 1000000007, 206522991],
            [8466510191643191251, 1000000007, 64022179],
            [36964, 991, 327],
            [12189, 991, 327],
            [99920, 991, 736],
            [89255, 991, 61],
            [50089, 991, 524],
            [47570, 991, 496],
            [123491, 2, 1],
            [43783, 3, 1],
        ];
        foreach ($testCases as $testCase) {
            [$x, $mod, $expected] = $testCase;
            self::assertThat(invert_mod_prime($x, $mod), self::equalTo($expected));
        }
    }

    function testInvertModPrime_逆元が無い場合()
    {
        self::assertThat(invert_mod_prime(1982, 991), self::equalTo(0));
        self::assertThat(invert_mod_prime(1000000007, 1000000007), self::equalTo(0));
        self::assertThat(invert_mod_prime(4567894, 2), self::equalTo(0));
        self::assertThat(invert_mod_prime(15327, 3), self::equalTo(0));
    }
}
