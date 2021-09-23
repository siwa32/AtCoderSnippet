<?php
/**
 *
 */

if (PHP_OS !== 'Linux') {
    // ローカル実行時
    ini_set('memory_limit', '512M');
}

const DBGOUT = STDERR;

const SP = ' ';
const LF = "\n";
const MOD1000000007 = 10 ** 9 + 7;
const MOD = MOD1000000007;

///////////////////////////////////////////////////////////////////
///

function xpow_mod(int $x, int $n, int $mod): int
{
    assert($n >= 0);
    assert($mod != 0);

    $x %= $mod;
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
 * 拡張ユークリッド互除法
 * @param int $a
 * @param int $b
 * @return int 最大公約数
 */
function gcd_ext(int $a, int $b, int& $x, int& $y): int
{
    if ($b === 0) {
        $x = 1;
        $y = 0;
        return $a;
    }
    $g = gcd_ext($b, $a % $b, $y, $x);
    $y -= intdiv($a, $b) * $x;
    return $g;
}

/**
 * xの逆元
 * @param int $x modとは互いに素
 * @param int $mod
 * @return int 逆元が無い場合は0を返す
 */
function invert_mod(int $x, int $mod): int
{
    assert($mod >= 2);

    $s = $t = 0;
    if (gcd_ext($x, $mod, $s, $t) !== 1) {
        return 0;// 互いに素では無い
    };
    return ($s < 0) ? (($mod + $s) % $mod) % $mod : $s % $mod;
}

/**
 * xの逆元
 * @param int $x $primeとは互いに素
 * @param int $prime 素数 素数で無い場合は未定義
 * @return int 逆元が無い場合は0を返す
 */
function invert_mod_prime(int $x, int $prime): int
{
    assert($prime >= 2);

    if ($x % $prime === 0) {
        return 0;
    }
    return xpow_mod($x, $prime - 2, $prime);
}

const COUNT = 100000;

function mesure()
{
    $result = [];

    $values = sampleValues(COUNT);

    $start = microtime(true);;
    foreach ($values as $value) {
        invert_mod($value[0], MOD1000000007);
        invert_mod($value[1], 991);
    }
    $tick = microtime(true) - $start;
    $result["invert_mod"] = $tick;

    $start = microtime(true);
    foreach ($values as $value) {
        invert_mod_prime($value[0], MOD1000000007);
        invert_mod_prime($value[1], 991);
    }
    $tick = microtime(true) - $start;
    $result["invert_mod_prime"] = $tick;

    $start = microtime(true);
    foreach ($values as $value) {
        gmp_invert($value[0], MOD1000000007);
        gmp_invert($value[1], 991);
    }
    $tick = microtime(true) - $start;
    $result["gmp_invert"] = $tick;

    foreach ($values as $value) {
        sameAll(
            (int)gmp_invert($value[0], MOD1000000007),
            invert_mod($value[0], MOD1000000007),
            invert_mod_prime($value[0], MOD1000000007)
        );
        sameAll(
            (int)gmp_invert($value[1], 991),
            invert_mod($value[1], 991),
            invert_mod_prime($value[1], 991)
        );
    }

    return $result;
}

printResult(mesure());

function sampleValues(int $size): array
{
    $values = [];
    for ($i = 0; $i < $size; ++$i) {
        $values[] = [random_int(1, PHP_INT_MAX - 1), random_int(1, 10000)];
    }
    return $values;
}

function sameAll(...$values): bool
{
    $first = null;
    foreach ($values as $value) {
        if ($first === null) {
            $first = $value;
            continue;
        }
        assert($first === $value) or exit;
    }
    return true;
}

function printResult(array $results): void
{
    $widthName = 0;
    foreach ($results as $name => $time) {
        $widthName = max($widthName, strlen($name));
    }
    $widthName += 4;

    $sep = str_repeat("-", max($widthName + 30, 50));
    echo $sep . PHP_EOL;
    echo sprintf("%{$widthName}s : %d times", "", COUNT) . PHP_EOL;
    foreach ($results as $name => $time) {
        if (is_numeric($time)) {
            echo sprintf("%{$widthName}s : %.15f(%.15f)", $name, $time, $time / COUNT) . PHP_EOL;
        } else {
            echo $time . PHP_EOL;
        }
    }
    echo $sep . PHP_EOL;
}

//////////////////////////////////////////////////////////////////////////////////
///

/**
 * デバッグ用出力
 * @param ...$values
 */
function p(...$values): void
{
    $o = '';
    $sep = '';
    foreach ($values as $value) {
        if (is_array($value)) {
            // キーは出力しない
            // 2次元配列まで
            if (is_array(current($value))) {
                $o .= (empty($sep) ? '' : PHP_EOL);
                foreach ($value as $item) {
                    $o .= '| ' . implode(',', $item) . ' |' . PHP_EOL;
                }
                $sep = '';
            } else {
                $o .= $sep . '[' . implode(',', $value) . ']';
                $sep = ', ';
            }
        } else {
            $o .= $sep . $value;
            $sep = ', ';
        }
    }
    $o .= (empty($sep) ? '' : PHP_EOL);
    fwrite(DBGOUT, $o);
}

/**
 * デバッグ用出力
 * @param ...$values
 */
function pp(...$values): void
{
    foreach ($values as $value) {
        $o = print_r($value, true);
        if (!is_array($value) && !is_object($value)) {
            $o .= PHP_EOL;
        }
        fwrite(DBGOUT, $o);
    }
}
