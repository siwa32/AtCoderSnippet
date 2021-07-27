<?php

/**
 * 整数除算切り上げ
 * @param int $x
 * @param int $y
 * @return int
 */
function intdiv_ceil(int $x, int $y): int
{
    return intdiv($x + $y - 1, $y);
}

/**
 * 最大公約数を求める
 * @param int $a
 * @param int $b
 * @return int
 */
function gcd(int $a, int $b): int
{
    while (true) {
        $r = $a % $b;
        if ($r === 0) {
            return $b;
        }
        $a = $b;
        $b = $r;
    }
}

/**
 * 最小公倍数を求める
 * @param int $a
 * @param int $b
 * @return float|int
 */
function lcm(int $a, int $b)
{
    return $a / gcd($a, $b) * $b;
}

/**
 * 指定した自然数の約数を取得する
 *
 * @param int $natural 自然数
 * @param bool $sorted 戻り値を昇順ソートするか
 * @return int[] 約数の配列
 */
function divisor(int $natural, bool $sorted = true): array
{
    assert($natural > 0);

    if ($natural === 1) {
        return [1];
    }
    $ret = [1, $natural];
    $limit = (int)sqrt($natural);
    for ($i = 2; $i <= $limit; ++$i) {
        if ($natural % $i === 0) {
            $ret[] = $i;
            $n = $natural / $i;
            if ($i !== $n) {
                $ret[] = $n;
            }
        }
    }
    if ($sorted) {
        sort($ret);
    }

    return $ret;
}

