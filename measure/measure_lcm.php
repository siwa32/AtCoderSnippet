<?php
/**
 *
 */

if (PHP_OS !== 'Linux') {
    // ローカル実行時
    ini_set('memory_limit', '512M');
}

const SP = ' ';
const LF = "\n";

///////////////////////////////////////////////////////////////////
///

function gcd1(int $a, int $b): int
{
    $r = $a % $b;
    return ($r === 0) ? $b : gcd1($b, $r);
}

function gcd2(int $a, int $b): int
{
    while (true) {
        $t = $a % $b;
        if ($t === 0) {
            return $b;
        }
        $a = $b;
        $b = $t;
    }
}

function gcd3(int $a, int $b): int
{
    return gmp_intval(gmp_gcd($a, $b));
}

function lcm1(int $a, int $b): int
{
    return $a / gcd1($a, $b) * $b;
}

function lcm2(int $a, int $b): int
{
    return $a / gcd2($a, $b) * $b;
}

function lcm3(int $a, int $b): int
{
    return $a / gcd3($a, $b) * $b;
}

function lcm4(int $a, int $b): int
{
    return gmp_intval(gmp_lcm($a, $b));
}

const COUNT = 100000;

function mesure()
{
    $result = [];

    $values = sampleValues(COUNT);

    $f = [
        "lcm1",
        "lcm2",
        "lcm3",
        "lcm4",
    ];
    foreach ($f as $fn) {
        if (function_exists($fn)) {
            $start = microtime(true);
            foreach ($values as $value) {
                $fn($value[0], $value[1]);
            }
            $tick = microtime(true) - $start;
        } else {
            $tick = "n/a";
        }
        $result[$fn] = $tick;
    }
    {
//        foreach ($values as $value) {
//            sameAll(
//                lcm1($value[0], $value[1]),
//                lcm2($value[0], $value[1]),
//                lcm3($value[0], $value[1]),
//                lcm4($value[0], $value[1]),
//            );
//        }
    }

    return $result;
}

printResult(mesure());

function sampleValues(int $size): array
{
    $values = [];
    for ($i = 0; $i < $size; ++$i) {
        $values[] = [random_int(1, 1 << 20), random_int(1, 1 << 20)];
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
        echo sprintf("%{$widthName}s : %.15f(%.15f)", $name, $time, $time / COUNT) . PHP_EOL;
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
    $sep = '';
    foreach ($values as $value) {
        if (is_array($value)) {
            // キーは出力しない
            // 2次元配列まで
            if (is_array(current($value))) {
                echo empty($sep) ? '' : PHP_EOL;
                foreach ($value as $item) {
                    echo '| ' . implode(',', $item) . ' |' . PHP_EOL;
                }
                $sep = '';
            } else {
                echo $sep . '[' . implode(',', $value) . ']';
                $sep = ', ';
            }
        } else {
            echo $sep . $value;
            $sep = ', ';
        }
    }
    echo empty($sep) ? '' : PHP_EOL;
}

/**
 * デバッグ用出力
 * @param ...$values
 */
function pp(...$values): void
{
    foreach ($values as $value) {
        print_r($value);
        if (!is_array($value) && !is_object($value)) {
            echo PHP_EOL;
        }
    }
}
