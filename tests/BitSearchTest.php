<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../snippets/BitSearch.php";

class BitSearchTest extends TestCase
{
    /**
     * @covers BitSearch::search
     */
    public function testSearch()
    {
        $params = [];
        BitSearch::search(
            4,
            static function (int $pattern, array& $params): bool {
                $params[] = "#{$pattern}";
                return true;
            },
            static function (int $pattern, int $i, array& $params) {
                $params[] = $i;
            },
            static function (int $pattern, array& $params) {
                $params[] = '##';
            },
            $params
        );
        $expected = [
            "#0", "##",
            "#1", 0, '##',
            "#2", 1, '##',
            "#3", 0, 1, '##',
            "#4", 2, '##',
            "#5", 0, 2, '##',
            "#6", 1, 2, '##',
            "#7", 0, 1, 2, '##',
            "#8", 3, '##',
            "#9", 0, 3, '##',
            "#10", 1, 3, '##',
            "#11", 0, 1, 3, '##',
            "#12", 2, 3, '##',
            "#13", 0, 2, 3, '##',
            "#14", 1, 2, 3, '##',
            "#15", 0, 1, 2, 3, '##',
        ];
        self::assertThat($params, self::equalTo($expected));
    }

    /**
     * @covers BitSearch::search
     */
    public function testSearch_チェックするパターンを選択()
    {
        $params = [];
        BitSearch::search(
            4,
            static function (int $pattern, array& $params): bool {
                $params[$pattern] = false;
                if ($pattern === 0 || $pattern === 5 || $pattern === 11 || $pattern === 15) {
                    return true;
                }
                return false;
            },
            static function (int $pattern, int $i, array& $params) {
                $params[$pattern] = $pattern;
            },
            static function (int $pattern, array& $params) {
                $params[$pattern] .= "#";
            },
            $params
        );
        $expected = [
            0 => "#",
            1 => false,
            2 => false,
            3 => false,
            4 => false,
            5 => "5#",
            6 => false,
            7 => false,
            8 => false,
            9 => false,
            10 => false,
            11 => "11#",
            12 => false,
            13 => false,
            14 => false,
            15 => "15#",
        ];
        self::assertThat($params, self::equalTo($expected));
    }
}
