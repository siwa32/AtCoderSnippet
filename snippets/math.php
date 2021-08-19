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

/**
 * 素数判定する
 *
 * @param int $n 整数
 * @return bool 素数ならtrue
 */
function is_prime(int $n): bool
{
    if ($n === 2) {
        return true;
    }
    if ($n <= 1 || ($n & 0b01) === 0) {
        return false;
    }

    $limit = (int)sqrt($n);
    for ($i = 3; $i <= $limit; $i += 2) {
        if ($n % $i === 0) {
            return false;
        }
    }
    return true;
}

/**
 * 素因数分解
 *
 * <code>
 * // example
 * prime_factor(12);// => [2 => 2, 3 => 1]
 * prime_factor(1000000000000);// => [2 => 12, 5 => 12]
 *
 * @param int $natural 2以上の自然数
 * @return array [素数 => 乗数, 素数 => 乗数, ...]
 */
function prime_factor(int $natural)
{
    assert($natural >= 2);

    $ret = [];
    $limit = (int)sqrt($natural);
    for ($i = 2; $i <= $limit; ++$i) {
        if ($natural % $i !== 0) {
            continue;
        }
        $ret[$i] = 0;
        while ($natural % $i === 0) {
            $natural /= $i;
            $ret[$i]++;
        }
    }
    if ($natural !== 1) {
        $ret[$natural] = 1;
    }
    return $ret;
}

/**
 * xのn乗を繰り返し二乗法を使用して求める
 * 0の0乗は未定義
 *
 * @param int $x
 * @param int $n 正の整数
 * @return int
 */
function xpow(int $x, int $n): int
{
    assert($n >= 0);

    $ret = 1;
    while ($n > 0) {
        if ($n & 0b01) {
            $ret *= $x;
        }
        $x *= $x;
        $n >>= 1;
    }
    return $ret;
}

/**
 * xのn乗をmodで割ったあまりを求める
 * xのn乗は繰り返し二乗法を使用する
 * 0の0乗は未定義
 *
 * @param int $x
 * @param int $n 正の整数
 * @param int $mod 0以外
 * @return int
 */
function xpow_mod(int $x, int $n, int $mod): int
{
    assert($n >= 0);
    assert($mod != 0);

    $ret = 1;
    while ($n > 0) {
        if ($n & 0b01) {
            $ret = ($ret * $x) % $mod;
        }
        $x = ($x * $x) % $mod;
        $n >>= 1;
    }
    return $ret;
}

/**
 * 組見合わせ mCn
 * @param int $m
 * @param int $n
 * @return int
 */
function mCn(int $m, int $n): int
{
    static $memorize = [];

    if ($m === 0 || $n === 0 || $m === $n) {
        return 1;
    }
    if (isset($memorize[$m][$n])) {
        return $memorize[$m][$n];
    }

    return $memorize[$m][$n] = mCn($m - 1, $n - 1) + mCn($m - 1, $n);
}

/**
 * 組見合わせ mCn (n=2固定)
 * @param int $m [1, 2**32]の範囲の整数
 * @return int
 */
function mC2(int $m): int
{
    if ($m % 2 === 1) {
        return $m * (($m - 1) / 2);
    } else {
        return ($m / 2) * ($m - 1);
    }
}

/**
 * 階乗
 * @param int $n
 * @return int
 */
function factorial(int $n): int
{
    static $memorize = [];

    if ($n === 0 || $n === 1) {
        return 1;
    }
    if (isset($memorize[$n])) {
        return $memorize[$n];
    }
    return $memorize[$n] = $n * factorial($n - 1);
}
