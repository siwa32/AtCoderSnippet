<?php

/**
 * ビット全探索
 */
class BitSearch
{
    public static function search(int $bitCount, callable $fnPre, callable $fnBit, callable $fnPost, &$params = null): void
    {
        assert(1 <= $bitCount && $bitCount <= 32);

        for ($pattern = 0; $pattern < 1 << $bitCount; ++$pattern) {
            if ($fnPre($pattern, $params)) {
                for ($i = 0; $i < $bitCount; ++$i) {
                    if ($pattern & (1 << $i)) {
                        $fnBit($pattern, $i, $params);
                    }
                }
                $fnPost($pattern, $params);
            }
        }
    }
}

if (0) {
    $params = [];
    BitSearch::search(
        4,
        static function (int $pattern, array& $params): bool {
            $params[$pattern] = [];
            return true;
        },
        static function (int $pattern, int $i, array& $params) {
            $params[$pattern][] = (1 << $i);
        },
        static function (int $pattern, array& $params) {
            $params[$pattern];
        },
        $params
    );
    print_r($params);
}
