<?php
/**
 * 実行時間の比較
 */

if (PHP_OS !== 'Linux') {
    // ローカル実行時
    ini_set('memory_limit', '512M');
}

const SP = ' ';
const LF = "\n";

///////////////////////////////////////////////////////////////////
///

function range_compress1(array $items): array
{
    $t = array_unique($items);
    sort($t);
    return array_flip($t);
}

function range_compress2(array $items): array
{
    $len = count($items);

    sort($items);

    $ret = [];
    $j = 0;
    $ret[$items[0]] = 0;
    for ($i = 1; $i < $len; ++$i) {
        if ($items[$i] !== ($items[$i - 1])) {
            ++$j;
        }
        $ret[$items[$i]] = $j;
    }
    return $ret;
}

function range_compress3(array $items): array
{
    $t = $items;
    sort($t);
    return array_flip($t);
}

function range_compress4(array $items): array
{
    sort($items);

    $ret = [];
    $j = -1;
    $pre = null;
    foreach ($items as $item) {
        if ($item !== $pre) {
            ++$j;
            $ret[$item] = $j;
            $pre = $item;
        }
    }
    return $ret;
}

const COUNT = 10;

function mesure()
{
    $result = [];

    $values = sampleValues(1000000);

    {
        $start = microtime(true);
        for ($i = 0; $i < COUNT; ++$i) {
            range_compress1($values);
        }
        $tick = microtime(true) - $start;
        $result["range_compress1"] = $tick;
    }
    {
        $start = microtime(true);
        for ($i = 0; $i < COUNT; ++$i) {
            range_compress2($values);
        }
        $tick = microtime(true) - $start;
        $result["range_compress2"] = $tick;
    }
    {
//        $start = microtime(true);
//        for ($i = 0; $i < COUNT; ++$i) {
//            range_compress3($values);
//        }
//        $tick = microtime(true) - $start;
//        $result["range_compress3"] = $tick;
    }
    {
        $start = microtime(true);
        for ($i = 0; $i < COUNT; ++$i) {
            range_compress4($values);
        }
        $tick = microtime(true) - $start;
        $result["range_compress4"] = $tick;
    }

    {
//        sameAll(
//            range_compress1($values),
//            range_compress2($values),
//            range_compress4($values),
//        );
    }

    return $result;
}

printResult(mesure());

function sampleValues(int $size): array
{
    $values = [];
    for ($i = 0; $i < $size; ++$i) {
        $values[] = random_int(0, $size / 10);
    }
//    $values = range(0, intdiv($size, 10) * 5);
//    shuffle($values);
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
