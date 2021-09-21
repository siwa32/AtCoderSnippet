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

function gcd_ext1(int $a, int $b, int& $x, int& $y): int
{
    if ($b === 0) {
        $x = 1;
        $y = 0;
        return $a;
    }
    $g = gcd_ext1($b, $a % $b, $y, $x);
    $y -= intdiv($a, $b) * $x;
    return $g;
}

function gcd_ext2(int $a, int $b, int& $x, int& $y): int
{
    $x = 1;
    $y = 0;
    $x1 = 0;
    $y1 = 1;
    while (true) {
        $r = $a % $b;
        if ($r === 0) {
            $x = $x1;
            $y = $y1;
            return $b;
        }

        $q = intdiv($a, $b);
        $tx = $x - $q * $x1;
        $ty = $y - $q * $y1;
        $a = $b;
        $b = $r;
        $x = $x1;
        $y = $y1;
        $x1 = $tx;
        $y1 = $ty;
    }
}

function gcd_ext3(int $a, int $b, int& $x, int& $y)
{
    $r = gmp_gcdext($a, $b);
    $x = gmp_intval($r['s']);
    $y = gmp_intval($r['t']);
    return gmp_intval($r['g']);
}

const COUNT = 100000;

function mesure()
{
    $result = [];

    $values = sampleValues(COUNT);

    $f = [
        "gcd_ext1",
        "gcd_ext2",
        "gcd_ext3",
    ];
    foreach ($f as $fn) {
        $x = $y = 0;
        if (function_exists($fn)) {
            $start = microtime(true);
            foreach ($values as $value) {
                $fn($value[0], $value[1], $x, $y);
            }
            $tick = microtime(true) - $start;
        } else {
            $tick = "n/a";
        }
        $result[$fn] = $tick;
    }

    {
        foreach ($values as $value) {
            $x0 = $y0 = 0;
            $x1 = $y1 = 0;
            $x2 = $y2 = 0;
            sameAll(
                gcd_ext1($value[0], $value[1], $x0, $y0),
                gcd_ext2($value[0], $value[1], $x1, $y1),
                gcd_ext3($value[0], $value[1], $x2, $y2),
            );
            sameAll($x0, $x1, $x2);
            sameAll($y0, $y1, $y2);
        }
    }

    return $result;
}

printResult(mesure());

function sampleValues(int $size): array
{
    $values = [];
    for ($i = 0; $i < $size; ++$i) {
        $values[] = [random_int(0, PHP_INT_MAX), random_int(1, PHP_INT_MAX)];
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
