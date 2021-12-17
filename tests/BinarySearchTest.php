<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../snippets/BinarySearch.php";

class BinarySearchTest extends TestCase
{
    /**
     * @covers BinarySearch::searchR
     */
    public function testSearchR()
    {
        $list = [1, 3, 6, 10, 10, 17];
        $actual = BinarySearch::searchR(0, count($list), static function (int $p) use(&$list): bool {
            return $list[$p] >= 10;
        });
        self::assertThat($actual, self::equalTo(3));

        $actual = BinarySearch::searchR(0, count($list), static function (int $p) use(&$list): bool {
            return $list[$p] >= 1;
        });
        self::assertThat($actual, self::equalTo(0));

        $actual = BinarySearch::searchR(0, count($list), static function (int $p) use(&$list): bool {
            return $list[$p] >= 17;
        });
        self::assertThat($actual, self::equalTo(5));
    }

    /**
     * @covers BinarySearch::searchR
     */
    public function testSearchR_区間逆の場合()
    {
        $list = [1, 3, 6, 10, 10, 17];
        $actual = BinarySearch::searchR(count($list) - 1, -1, static function (int $p) use(&$list): bool {
            return $list[$p] <= 10;
        });
        self::assertThat($actual, self::equalTo(4));

        $actual = BinarySearch::searchR(count($list) - 1, -1, static function (int $p) use(&$list): bool {
            return $list[$p] <= 1;
        });
        self::assertThat($actual, self::equalTo(0));

        $actual = BinarySearch::searchR(count($list) - 1, -1, static function (int $p) use(&$list): bool {
            return $list[$p] <= 17;
        });
        self::assertThat($actual, self::equalTo(5));
    }

    /**
     * @covers BinarySearch::searchR
     */
    public function testSearchR_見つからない場合()
    {
        $list = [1, 3, 6, 10, 10, 17];
        $actual = BinarySearch::searchR(0, count($list), static function (int $p) use(&$list): bool {
            return $list[$p] >= 18;
        });
        self::assertThat($actual, self::isFalse());
    }

    /**
     * @covers BinarySearch::searchR
     */
    public function testSearchR_区間逆で見つからない場合()
    {
        $list = [1, 3, 6, 10, 10, 17];
        $actual = BinarySearch::searchR(count($list) - 1, -1, static function (int $p) use(&$list): bool {
            return $list[$p] <= 0;
        });
        self::assertThat($actual, self::isFalse());
    }

    /**
     * @covers BinarySearch::searchR
     */
    public function testSearchR_探索対象が一つの場合()
    {
        $list = [1, 3, 6, 10, 10, 17];
        $actual = BinarySearch::searchR(0, 1, static function (int $p) use(&$list): bool {
            return $list[$p] >= 1;
        });
        self::assertThat($actual, self::equalTo(0));

        $actual = BinarySearch::searchR(2, 3, static function (int $p) use(&$list): bool {
            return $list[$p] >= 6;
        });
        self::assertThat($actual, self::equalTo(2));
    }

    /**
     * @covers BinarySearch::searchR
     */
    public function testSearchR_区間逆で探索対象が一つの場合()
    {
        $list = [1, 3, 6, 10, 10, 17];
        $actual = BinarySearch::searchR(0, -1, static function (int $p) use(&$list): bool {
            return $list[$p] <= 0;
        });
        self::assertThat($actual, self::equalTo(0));

        $actual = BinarySearch::searchR(4, 3, static function (int $p) use(&$list): bool {
            return $list[$p] <= 10;
        });
        self::assertThat($actual, self::equalTo(4));
    }

    /**
     * @covers BinarySearch::searchL
     */
    public function testSearchL()
    {
        $list = [1, 3, 6, 10, 10, 17];
        $actual = BinarySearch::searchL(0, count($list), static function (int $p) use(&$list): bool {
            return $list[$p] <= 10;
        });
        self::assertThat($actual, self::equalTo(4));

        $actual = BinarySearch::searchL(0, count($list), static function (int $p) use(&$list): bool {
            return $list[$p] <= 1;
        });
        self::assertThat($actual, self::equalTo(0));

        $actual = BinarySearch::searchL(0, count($list), static function (int $p) use(&$list): bool {
            return $list[$p] <= 17;
        });
        self::assertThat($actual, self::equalTo(5));
    }

    /**
     * @covers BinarySearch::searchL
     */
    public function testSearchL_区間逆の場合()
    {
        $list = [1, 3, 6, 10, 10, 17];
        $actual = BinarySearch::searchL(count($list) - 1, -1, static function (int $p) use(&$list): bool {
            return $list[$p] >= 10;
        });
        self::assertThat($actual, self::equalTo(3));

        $actual = BinarySearch::searchL(count($list) - 1, -1, static function (int $p) use(&$list): bool {
            return $list[$p] >= 1;
        });
        self::assertThat($actual, self::equalTo(0));

        $actual = BinarySearch::searchL(count($list) - 1, -1, static function (int $p) use(&$list): bool {
            return $list[$p] >= 17;
        });
        self::assertThat($actual, self::equalTo(5));
    }

    /**
     * @covers BinarySearch::searchL
     */
    public function testSearchL_見つからない場合()
    {
        $list = [1, 3, 6, 10, 10, 17];
        $actual = BinarySearch::searchL(0, count($list), static function (int $p) use(&$list): bool {
            return $list[$p] <= 0;
        });
        self::assertThat($actual, self::isFalse());
    }

    /**
     * @covers BinarySearch::searchL
     */
    public function testSearchL_区間逆で見つからない場合()
    {
        $list = [1, 3, 6, 10, 10, 17];
        $actual = BinarySearch::searchL(count($list) - 1, -1, static function (int $p) use(&$list): bool {
            return $list[$p] >= 18;
        });
        self::assertThat($actual, self::isFalse());
    }

    /**
     * @covers BinarySearch::searchL
     */
    public function testSearchL_探索対象が一つの場合()
    {
        $list = [1, 3, 6, 10, 10, 17];
        $actual = BinarySearch::searchL(0, 1, static function (int $p) use(&$list): bool {
            return $list[$p] <= 1;
        });
        self::assertThat($actual, self::equalTo(0));

        $actual = BinarySearch::searchL(2, 3, static function (int $p) use(&$list): bool {
            return $list[$p] <= 6;
        });
        self::assertThat($actual, self::equalTo(2));
    }

    /**
     * @covers BinarySearch::searchL
     */
    public function testSearchL_区間逆で探索対象が一つの場合()
    {
        $list = [1, 3, 6, 10, 10, 17];
        $actual = BinarySearch::searchL(0, -1, static function (int $p) use(&$list): bool {
            return $list[$p] >= 0;
        });
        self::assertThat($actual, self::equalTo(0));

        $actual = BinarySearch::searchL(4, 3, static function (int $p) use(&$list): bool {
            return $list[$p] >= 10;
        });
        self::assertThat($actual, self::equalTo(4));
    }

    /**
     * @covers ::array_binary_search
     */
    public function testArrayBinarySearch()
    {
        $list = [1, 3, 6, 10];
        self::assertThat(array_binary_search($list, 3), self::equalTo(1));
        self::assertThat(array_binary_search($list, 1), self::equalTo(0));
        self::assertThat(array_binary_search($list, 10), self::equalTo(3));
    }

    /**
     * @covers ::array_binary_search
     */
    public function testArrayBinarySearch_要素一つの場合()
    {
        $list = [1];
        self::assertThat(array_binary_search($list, 1), self::equalTo(0));
        self::assertThat(array_binary_search($list, 0), self::isFalse());
        self::assertThat(array_binary_search($list, 2), self::isFalse());
    }

    /**
     * @covers ::array_binary_search
     */
    public function testArrayBinarySearch_要素二つの場合()
    {
        $list = [1, 3];
        self::assertThat(array_binary_search($list, 1), self::equalTo(0));
        self::assertThat(array_binary_search($list, 3), self::equalTo(1));
        self::assertThat(array_binary_search($list, 0), self::isFalse());
        self::assertThat(array_binary_search($list, 4), self::isFalse());
    }

    /**
     * @covers ::array_binary_search
     */
    public function testArrayBinarySearch_複数の要素に一致する場合()
    {
        $list = [1, 3, 3, 10];
        self::assertThat(array_binary_search($list, 3), self::lessThanOrEqual(2));
        self::assertThat(array_binary_search($list, 3), self::greaterThanOrEqual(1));
    }

    /**
     * @covers ::array_binary_search
     */
    public function testArrayBinarySearch_見つからない場合()
    {
        $list = [1, 3, 6, 10];
        self::assertThat(array_binary_search($list, 0), self::isFalse());
        self::assertThat(array_binary_search($list, 11), self::isFalse());
        self::assertThat(array_binary_search($list, 4), self::isFalse());
    }

    /**
     * @covers ::array_binary_rsearch
     */
    public function testArrayBinaryRSearch()
    {
        $list = [10, 8, 4, 2];
        self::assertThat(array_binary_rsearch($list, 4), self::equalTo(2));
        self::assertThat(array_binary_rsearch($list, 2), self::equalTo(3));
        self::assertThat(array_binary_rsearch($list, 10), self::equalTo(0));
    }

    /**
     * @covers ::array_binary_rsearch
     */
    public function testArrayBinaryRSearch_要素一つの場合()
    {
        $list = [10];
        self::assertThat(array_binary_rsearch($list, 10), self::equalTo(0));
        self::assertThat(array_binary_rsearch($list, 11), self::isFalse());
        self::assertThat(array_binary_rsearch($list, 9), self::isFalse());
    }

    /**
     * @covers ::array_binary_rsearch
     */
    public function testArrayBinaryRSearch_要素二つの場合()
    {
        $list = [10, 4];
        self::assertThat(array_binary_rsearch($list, 10), self::equalTo(0));
        self::assertThat(array_binary_rsearch($list, 4), self::equalTo(1));
        self::assertThat(array_binary_rsearch($list, 11), self::isFalse());
        self::assertThat(array_binary_rsearch($list, 3), self::isFalse());
    }

    /**
     * @covers ::array_binary_rsearch
     */
    public function testArrayBinaryRSearch_複数要素が一致する場合()
    {
        $list = [10, 8, 8, 2];
        self::assertThat(array_binary_rsearch($list, 8), self::lessThanOrEqual(2));
        self::assertThat(array_binary_rsearch($list, 8), self::greaterThanOrEqual(1));
    }

    /**
     * @covers ::array_binary_rsearch
     */
    public function testArrayBinaryRSearch_見つからない場合()
    {
        $list = [10, 8, 4, 2];
        self::assertThat(array_binary_rsearch($list, 1), self::isFalse());
        self::assertThat(array_binary_rsearch($list, 11), self::isFalse());
        self::assertThat(array_binary_rsearch($list, 5), self::isFalse());
    }
}
