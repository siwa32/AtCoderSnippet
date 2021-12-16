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

    /**
     * @covers ::swap
     */
    function testSwap()
    {
        $a = 1;
        $b = 2;
        swap($a, $b);
        self::assertThat($a, self::equalTo(2));
        self::assertThat($b, self::equalTo(1));
    }

    /**
     * @covers ::swap
     */
    function testSwap_文字列の場合()
    {
        $a = "asd";
        $b = "zxc";
        swap($a, $b);
        self::assertThat($a, self::equalTo("zxc"));
        self::assertThat($b, self::equalTo("asd"));
    }

    /**
     * @covers ::change_max
     */
    function testChangeMax_更新される場合()
    {
        $a = 0;
        self::assertThat(change_max($a, 1), self::isTrue());
        self::assertThat($a, self::equalTo(1));

        $a = -100;
        self::assertThat(change_max($a, 0), self::isTrue());
        self::assertThat($a, self::equalTo(0));
    }

    /**
     * @covers ::change_max
     */
    function testChangeMax_更新されない場合()
    {
        $a = 100;
        self::assertThat(change_max($a, 1), self::isFalse());
        self::assertThat($a, self::equalTo(100));

        $a = 100;
        self::assertThat(change_max($a, 100), self::isFalse());
        self::assertThat($a, self::equalTo(100));
    }

    /**
     * @covers ::change_min
     */
    function testChangeMin_更新される場合()
    {
        $a = 100;
        self::assertThat(change_min($a, 1), self::isTrue());
        self::assertThat($a, self::equalTo(1));

        $a = 0;
        self::assertThat(change_min($a, -1), self::isTrue());
        self::assertThat($a, self::equalTo(-1));
    }

    /**
     * @covers ::change_min
     */
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

    /**
     * @covers ::array_flatten
     */
    function testArrayFlatten()
    {
        self::assertThat(array_flatten([1, 3, 5, 5, 6, 8, 10]), self::equalTo([1, 3, 5, 5, 6, 8, 10]));
        self::assertThat(array_flatten([1, [3, 5], 5, [6, 8], 10]), self::equalTo([1, 3, 5, 5, 6, 8, 10]));
        self::assertThat(array_flatten([1, [3, 5, [5, 6, 8], 10]]), self::equalTo([1, 3, 5, 5, 6, 8, 10]));
        self::assertThat(array_flatten([]), self::equalTo([]));
    }

    /**
     * @covers ::array_count_if
     */
    function testArrayCountIf_配列の要素が整数の場合()
    {
        self::assertThat(array_count_if([1, 3, 4, 7, 123, 63246, 2, 53, 1, 0, null], 1), self::equalTo(2));
        self::assertThat(array_count_if([1, 3, 4, 7, 123, 63246, 2, 53, 1, 0, null], 0), self::equalTo(1));
        self::assertThat(array_count_if([1, 3, 4, 7, 123, 63246, 2, 53, 1, 0, null], "1"), self::equalTo(0));
        self::assertThat(array_count_if([1, 3, 4, 7, 123, 63246, 2, 53, 1, 0, null], -8), self::equalTo(0));
        self::assertThat(array_count_if([1, 3, 4, 7, 123, 63246, 2, 53, 1, 0, null], 2.0), self::equalTo(0));
    }

    /**
     * @covers ::array_count_if
     */
    function testArrayCountIf_配列の要素が文字列の場合()
    {
        self::assertThat(array_count_if(["1", "3", "4", "7", "123", "63246", "2", "53", "1", "0", null], "1"), self::equalTo(2));
        self::assertThat(array_count_if(["1", "3", "4", "7", "123", "63246", "2", "53", "1", "0", null], 1), self::equalTo(0));
        self::assertThat(array_count_if(["1", "3", "4", "7", "123", "63246", "2", "53", "1", "0", null], ""), self::equalTo(0));
        self::assertThat(array_count_if(["1", "3", "4", "7", "123", "63246", "2", "53", "1", "0", null], "abc"), self::equalTo(0));
    }

    /**
     * @covers ::array_count_if
     */
    function testArrayCountIf_配列の要素が真偽値の場合()
    {
        self::assertThat(array_count_if([true, true, false, false, true], true), self::equalTo(3));
        self::assertThat(array_count_if([true, true, false, false, true], false), self::equalTo(2));
        self::assertThat(array_count_if([true, true, false, false, true], 1), self::equalTo(0));
        self::assertThat(array_count_if([true, true, false, false, true], 0), self::equalTo(0));
        self::assertThat(array_count_if([true, true, false, false, true], null), self::equalTo(0));
    }

    /**
     * @covers ::array_count_if
     */
    function testArrayCountIf_比較関数を渡す場合()
    {
        $actual = array_count_if([1, 3, 4, 7, null, 123, 63246, 2, 53, 1, 0, true], function ($item) {
            return !is_null($item) && $item < 100;
        });
        self::assertThat($actual, self::equalTo(8));
    }

    /**
     * @covers ::lower_bound
     */
    function testLowerBound()
    {
        self::assertThat(lower_bound([1, 3, 5, 5, 6, 10], 5), self::equalTo(2));
        self::assertThat(lower_bound([1, 3, 5, 5, 6, 8, 10], 7), self::equalTo(5));
        self::assertThat(lower_bound([1, 3, 5, 5, 6, 8, 10], 0), self::equalTo(0));
        self::assertThat(lower_bound([1, 3, 5, 5, 6, 8, 10], 1), self::equalTo(0));
        self::assertThat(lower_bound([1, 3, 5, 5, 6, 8, 10], 10), self::equalTo(6));
        self::assertThat(lower_bound([6], 6), self::equalTo(0));
        self::assertThat(lower_bound([6, 7], 7), self::equalTo(1));
    }

    /**
     * @covers ::lower_bound
     */
    function testLowerBound_見つからない場合()
    {
        self::assertThat(lower_bound([1, 3, 5, 5, 6, 8, 10], 11), self::isFalse());
        self::assertThat(lower_bound([1, 3], 4), self::isFalse());
        self::assertThat(lower_bound([3], 4), self::isFalse());
        self::assertThat(lower_bound([], 1), self::isFalse());
    }

    /**
     * @covers ::lower_bound
     */
    function testLowerBound_開始位置指定する場合()
    {
        self::assertThat(lower_bound([1, 3, 5, 5, 6, 10], 5, 3), self::equalTo(3));
        self::assertThat(lower_bound([1, 3, 5, 5, 6, 8, 10], 7, 5), self::equalTo(5));
        self::assertThat(lower_bound([1, 3, 5, 5, 6, 8, 10], 0, 6), self::equalTo(6));
        self::assertThat(lower_bound([1, 3, 5, 5, 6, 8, 10], 1, 7), self::isFalse());
    }

    /**
     * @covers ::upper_bound
     */
    function testUpperBound()
    {
        self::assertThat(upper_bound([1, 3, 5, 6, 8, 10], 5), self::equalTo(3));
        self::assertThat(upper_bound([1, 3, 5, 5, 6, 8, 10], 7), self::equalTo(5));
        self::assertThat(upper_bound([1, 3, 5, 5, 6, 8, 10], 0), self::equalTo(0));
        self::assertThat(upper_bound([1, 3, 5, 5, 6, 8, 10], 1), self::equalTo(1));
        self::assertThat(upper_bound([1], 0), self::equalTo(0));
        self::assertThat(upper_bound([1, 2], 1), self::equalTo(1));
    }

    /**
     * @covers ::upper_bound
     */
    function testUpperBound_見つからない場合()
    {
        self::assertThat(upper_bound([1, 3, 5, 6, 8, 10], 10), self::isFalse());
        self::assertThat(upper_bound([1, 3, 5, 5, 6, 8, 10], 11), self::isFalse());
        self::assertThat(upper_bound([8], 8), self::isFalse());
        self::assertThat(upper_bound([8, 9], 9), self::isFalse());
        self::assertThat(upper_bound([], 1), self::isFalse());
    }

    /**
     * @covers ::upper_bound
     */
    function testUpperBound_開始位置を指定する場合()
    {
        self::assertThat(upper_bound([1, 3, 5, 6, 8, 10], 5, 4), self::equalTo(4));
        self::assertThat(upper_bound([1, 3, 5, 5, 6, 8, 10], 7, 7), self::isFalse());
        self::assertThat(upper_bound([1, 3, 5, 5, 6, 8, 10], 0, 6), self::equalTo(6));
        self::assertThat(upper_bound([1, 3, 5, 5, 6, 8, 10, 13], 4, 3), self::equalTo(3));
        self::assertThat(upper_bound([1], 0, 0), self::equalTo(0));
    }

    /**
     * @covers ::convert_int_base
     */
    function testConvertIntBase_0()
    {
        self::assertThat(convert_int_base(0, 2), self::equalTo('0'));
        self::assertThat(convert_int_base(0, 3), self::equalTo('0'));
        self::assertThat(convert_int_base(0, 4), self::equalTo('0'));
        self::assertThat(convert_int_base(0, 8), self::equalTo('0'));
        self::assertThat(convert_int_base(0, 9), self::equalTo('0'));
        self::assertThat(convert_int_base(0, 13), self::equalTo('0'));
        self::assertThat(convert_int_base(0, 16), self::equalTo('0'));
    }

    /**
     * @covers ::convert_int_base
     */
    function testConvertIntBase_base10()
    {
        self::assertThat(convert_int_base(10, 10), self::equalTo('10'));
        self::assertThat(convert_int_base(34572348, 10), self::equalTo('34572348'));
        self::assertThat(convert_int_base(9223372036854775807, 10), self::equalTo('9223372036854775807'));
    }

    /**
     * @covers ::convert_int_base
     */
    function testConvertIntBase_base2()
    {
        self::assertThat(convert_int_base(1, 2), self::equalTo('1'));
        self::assertThat(convert_int_base(2, 2), self::equalTo('10'));
        self::assertThat(convert_int_base(3, 2), self::equalTo('11'));
        self::assertThat(convert_int_base(255, 2), self::equalTo('11111111'));
        self::assertThat(convert_int_base(1023, 2), self::equalTo('1111111111'));
        self::assertThat(convert_int_base(1024, 2), self::equalTo('10000000000'));
        self::assertThat(convert_int_base(0b0111010101, 2), self::equalTo('111010101'));
        self::assertThat(convert_int_base(0b111000101010111010101, 2), self::equalTo('111000101010111010101'));
        self::assertThat(convert_int_base(0b111111111111111111111111111111111111111111111111111111111111111, 2), self::equalTo('111111111111111111111111111111111111111111111111111111111111111'));
        self::assertThat(convert_int_base(9223372036854775807, 2), self::equalTo('111111111111111111111111111111111111111111111111111111111111111'));
    }

    /**
     * @covers ::convert_int_base
     */
    function testConvertIntBase_base8()
    {
        self::assertThat(convert_int_base(1, 8), self::equalTo('1'));
        self::assertThat(convert_int_base(2, 8), self::equalTo('2'));
        self::assertThat(convert_int_base(8, 8), self::equalTo('10'));
        self::assertThat(convert_int_base(0377, 8), self::equalTo('377'));
        self::assertThat(convert_int_base(072351, 8), self::equalTo('72351'));
        self::assertThat(convert_int_base(066341537462416, 8), self::equalTo('66341537462416'));
        self::assertThat(convert_int_base(0777777777777777777777, 8), self::equalTo('777777777777777777777'));
        self::assertThat(convert_int_base(9223372036854775807, 8), self::equalTo('777777777777777777777'));
    }

    /**
     * @covers ::convert_int_base
     */
    function testConvertIntBase_base16()
    {
        self::assertThat(convert_int_base(1, 16), self::equalTo('1'));
        self::assertThat(convert_int_base(2, 16), self::equalTo('2'));
        self::assertThat(convert_int_base(16, 16), self::equalTo('10'));
        self::assertThat(convert_int_base(255, 16), self::equalTo('ff'));
        self::assertThat(convert_int_base(0xffff, 16), self::equalTo('ffff'));
        self::assertThat(convert_int_base(0xc3a8611ee, 16), self::equalTo('c3a8611ee'));
        self::assertThat(convert_int_base(0xc90acbb51423cc, 16), self::equalTo('c90acbb51423cc'));
        self::assertThat(convert_int_base(0x7fffffffffffffff, 16), self::equalTo('7fffffffffffffff'));
        self::assertThat(convert_int_base(9223372036854775807, 16), self::equalTo('7fffffffffffffff'));
    }

    /**
     * @covers ::convert_int_base
     */
    function testConvertIntBase_base9()
    {
        self::assertThat(convert_int_base(1, 9), self::equalTo('1'));
        self::assertThat(convert_int_base(2, 9), self::equalTo('2'));
        self::assertThat(convert_int_base(9, 9), self::equalTo('10'));
        self::assertThat(convert_int_base(80, 9), self::equalTo('88'));
        self::assertThat(convert_int_base(81, 9), self::equalTo('100'));
        self::assertThat(convert_int_base(intval('726143640372', 9), 9), self::equalTo('726143640372'));
        self::assertThat(convert_int_base(intval('888888888888888', 9), 9), self::equalTo('888888888888888'));
        self::assertThat(convert_int_base(intval('67404283172107811827', 9), 9), self::equalTo('67404283172107811827'));
        self::assertThat(convert_int_base(9223372036854775807, 9), self::equalTo('67404283172107811827'));
    }

    /**
     * @covers ::popcount
     */
    function testPopcount()
    {
        self::assertThat(popcount(0), self::equalTo(0));
        self::assertThat(popcount(0b0001), self::equalTo(1));
        self::assertThat(popcount(0b0101), self::equalTo(2));
        self::assertThat(popcount(0b100000100111011), self::equalTo(7));
        self::assertThat(popcount(0b11111111111111111111111111111111), self::equalTo(32));
        self::assertThat(popcount(-1), self::equalTo(64));
    }

    /**
     * @covers ::tzcount
     */
    function testTzcount()
    {
        self::assertThat(tzcount(0b00000000_01101010_00000000_00000001), self::equalTo(0));
        self::assertThat(tzcount(0b00000000_01101010_00000000_00000010), self::equalTo(1));
        self::assertThat(tzcount(0b00000000_01101010_00000000_01101010), self::equalTo(1));
        self::assertThat(tzcount(0b00000000_01101000_00000000_00000000), self::equalTo(19));
        self::assertThat(tzcount(0b01000000_00000000_00000000_00000000_00000000_00000000_00000000_00000000), self::equalTo(62));
    }

    /**
     * @covers ::tzcount
     */
    function testTzcount_最上位ビットが立っている場合()
    {
        self::assertThat(tzcount(-1), self::equalTo(0));
        self::assertThat(tzcount(~0b01111111_11111111_11111111_11111111_11111111_11111111_11111111_11111110), self::equalTo(0));
        self::assertThat(tzcount(~0b01111111_11111111_11111111_11111111_11111111_11111111_11111111_11111111), self::equalTo(63));
        self::assertThat(tzcount(~0b01111111_11111111_11111111_11110011_11111111_11111111_10111111_11111111), self::equalTo(14));
        self::assertThat(tzcount(~0b01111111_00000000_11111111_11110011_11111111_11111111_11111111_11111111), self::equalTo(34));
    }

    /**
     * @covers ::tzcount
     */
    function testTzcount_0の場合()
    {
        self::assertThat(tzcount(0), self::isFalse(), "立っているビットが無い場合はfalse");
    }

    /**
     * @covers ::str_sort
     */
    function testStrSort()
    {
        self::assertThat(str_sort("fwieha"), self::equalTo("aefhiw"));
        self::assertThat(str_sort("aza72e39fz"), self::equalTo("2379aaefzz"));
        self::assertThat(str_sort("abcdefghijklmn"), self::equalTo("abcdefghijklmn"));
    }

    /**
     * @covers ::median
     */
    function testMedian()
    {
        $list = [1 ,2, 3, 4, 5];
        self::assertThat(median($list), self::equalTo(3));
        $list = [5, 4, 3, 2, 1];
        self::assertThat(median($list), self::equalTo(3));
    }

    /**
     * @covers ::median
     */
    function testMedian_配列の要素数が偶数の場合()
    {
        $list = [1 ,2, 3, 4, 5, 6];
        self::assertThat(median($list), self::equalTo(3.5));
        $list = [6, 5, 4, 3, 2, 1];
        self::assertThat(median($list), self::equalTo(3.5));
    }

    /**
     * @covers ::median
     */
    function testMedian_配列が空の場合()
    {
        $list = [];
        self::assertThat(median($list), self::isFalse());
    }

    /**
     * @covers ::str_run_leength_encoding
     */
    function testStrRunLengthEncoding()
    {
        $expect = [
            ['a', 4],
            ['d', 4],
            ['h', 1],
            ['t', 1],
            ['a', 2],
        ];
        self::assertThat(str_run_leength_encoding("aaaaddddhtaa"), self::equalTo($expect));
    }

    /**
     * @covers ::str_run_leength_encoding
     */
    function testStrRunLengthEncoding_空文字の場合()
    {
        self::assertThat(str_run_leength_encoding(""), self::equalTo([]));
    }

    /**
     * @covers ::str_run_leength_encoding
     */
    function testStrRunLengthEncoding_1文字の場合()
    {
        self::assertThat(str_run_leength_encoding("A"), self::equalTo([['A', 1]]));
    }

    /**
     * @covers ::str_run_leength_encoding
     */
    function testStrRunLengthEncoding_全て違う文字()
    {
        $expect = [
            ['z', 1],
            ['x', 1],
            ['c', 1],
            ['v', 1],
            ['b', 1],
        ];
        self::assertThat(str_run_leength_encoding("zxcvb"), self::equalTo($expect));
    }

    /**
     * @covers ::range_compress
     */
    function testRangeCompress()
    {
        self::assertThat(range_compress([2, 5, 9, 1, 10, 7]), self::equalTo([2 => 1, 5 => 2, 9 => 4, 1 => 0, 10 => 5, 7 => 3]));
        self::assertThat(range_compress([2]), self::equalTo([2 => 0]));
    }

    /**
     * @covers ::range_compress
     */
    function testRangeCompress_値の重複がある場合()
    {
        self::assertThat(range_compress([2, 5, 9, 1, 10, 2]), self::equalTo([2 => 1, 5 => 2, 9 => 3, 1 => 0, 10 => 4]));
        self::assertThat(range_compress([2, 2]), self::equalTo([2 => 0]));
    }

    /**
     * @covers ::random_str
     */
    function testRandomStr_文字列長()
    {
        self::assertThat(strlen(random_str(10, "abc")), self::equalTo(10));
        self::assertThat(strlen(random_str(1, "abc")), self::equalTo(1));
        self::assertThat(strlen(random_str(145, "ABC123")), self::equalTo(145));
    }

    /**
     * @covers ::random_str
     */
    function testRandomStr_指定した文字のみで構成される()
    {
        foreach (str_split(random_str(20, "abc")) as $ch) {
            self::assertThat(strpos($ch, "abc"), self::greaterThanOrEqual(0));
        }
        foreach (str_split(random_str(10)) as $ch) {
            self::assertThat(strpos($ch, "abcdefghijklmnopqrstuvwxyz"), self::greaterThanOrEqual(0));
        }
        foreach (str_split(random_str(20, "ABCDEFGH1234")) as $ch) {
            self::assertThat(strpos($ch, "ABCDEFGH1234"), self::greaterThanOrEqual(0));
        }
    }
}
