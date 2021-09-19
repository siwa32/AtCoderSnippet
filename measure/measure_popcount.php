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

function popcount1(int $v): int
{
    $c = 0;
    while ($v !== 0) {
        $c += ($v & 1);
        $v >>= 1;
    }
    return $c;
}

function popcount2(int $v): int
{
    return count_chars(decbin($v), 1)[ord('1')] ?? 0;
}

function popcount3(int $v): int
{
    $c = 0;
    while ($v) {
        $v &= $v - 1;
        ++$c;
    }
    return $c;
}

function popcount(int $v)
{
    $v = $v - (($v >> 1) & 0x5555555555555555);
    $v = ($v & 0x3333333333333333) + (($v >> 2) & 0x3333333333333333);
    $v = ($v + ($v >> 4)) & 0x0f0f0f0f0f0f0f0f;
    $v = $v + ($v >> 8);
    $v = $v + ($v >> 16);
    $v = $v + ($v >> 32);
    return $v & 0x0000007f;
}

const COUNT = 100000;

function mesure()
{
    $result = [];

    $values = sampleValues(COUNT);

    {
        $start = microtime(true);
        foreach ($values as $value) {
            popcount1($value);
        }
        $tick = microtime(true) - $start;
        $result["popcount1"] = $tick;
    }
    {
        $start = microtime(true);
        foreach ($values as $value) {
            popcount2($value);
        }
        $tick = microtime(true) - $start;
        $result["popcount2"] = $tick;
    }
    {
        $start = microtime(true);
        foreach ($values as $value) {
            popcount3($value);
        }
        $tick = microtime(true) - $start;
        $result["popcount3"] = $tick;
    }
    {
        $start = microtime(true);
        foreach ($values as $value) {
            popcount($value);
        }
        $tick = microtime(true) - $start;
        $result["popcount"] = $tick;
    }
    {
        $tick = 'n/a';
        if (extension_loaded('gmp')) {
            $start = microtime(true);
            foreach ($values as $value) {
                gmp_popcount($value);
            }
            $tick = microtime(true) - $start;
        }
        $result["gmp_popcount"] = $tick;
    }

    {
//        foreach ($values as $value) {
//            sameAll(
//                popcount1($value),
//                popcount2($value),
//                popcount3($value),
//                popcount($value)
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
        $values[] = random_int(0, PHP_INT_MAX);
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
