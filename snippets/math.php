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
