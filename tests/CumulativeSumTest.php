<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../snippets/CumulativeSum.php";

class CumulativeSumTest extends TestCase
{
    public function testInit()
    {
        self::assertThat(CumulativeSum::init([1, 2, 3]), self::isInstanceOf("CumulativeSum"));
    }

    public function testSum()
    {
        $sum = CumulativeSum::init([1, 2, 3, 4, 5, 6]);
        self::assertThat($sum->sum(0, 5), self::equalTo(21));
        self::assertThat($sum->sum(0, 0), self::equalTo(1));
        self::assertThat($sum->sum(5, 5), self::equalTo(6));
        self::assertThat($sum->sum(0, 2), self::equalTo(6));
        self::assertThat($sum->sum(2, 4), self::equalTo(12));
        self::assertThat($sum->sum(3, 5), self::equalTo(15));

        $sum = CumulativeSum::init([72, 8, 11, 2, 738, 2]);
        self::assertThat($sum->sum(0, 5), self::equalTo(72 + 8 + 11 + 2 + 738 + 2));
        self::assertThat($sum->sum(0, 0), self::equalTo(72));
        self::assertThat($sum->sum(5, 5), self::equalTo(2));
        self::assertThat($sum->sum(0, 2), self::equalTo(72 + 8 + 11));
        self::assertThat($sum->sum(2, 4), self::equalTo(11 + 2 + 738));
        self::assertThat($sum->sum(3, 5), self::equalTo(2 + 738 + 2));
    }
}
