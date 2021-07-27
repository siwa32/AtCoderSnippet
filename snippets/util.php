<?php

/**
 * 値の入れ替え
 * @param &$a
 * @param &$b
 */
function swap(&$a, &$b): void
{
    $tmp = $a;
    $a = $b;
    $b = $tmp;
}

function change_max(&$a, $b): bool
{
    if ($a < $b) {
        $a = $b;
        return true;
    }
    return false;
}

function change_min(&$a, $b): bool
{
    if ($a > $b) {
        $a = $b;
        return true;
    }
    return false;
}

function array_flatten(array $a): array
{
    $ret = [];
    array_walk_recursive($a, function($a) use (&$ret) {
        $ret[] = $a;
    });
    return $ret;
}

/**
 * 配列に指定した値と同じ要素数を取得する
 * <code>
 * array_count_if([1, 2, 2], 2);
 * array_count_if([1, 2, 2], function ($e) { return $e > 2; });
 * </code>
 * @param array $list
 * @param callable|mixed $valueOrCompare 比較する値、またはboolを返す関数
 * @return int 要素数
 */
function array_count_if(array $list, $valueOrCompare): int
{
    $cnt = 0;
    if (is_callable($valueOrCompare)) {
        foreach ($list as $item) {
            if ($valueOrCompare($item)) {
                $cnt++;
            }
        }
    } else {
        foreach ($list as $item) {
            if ($item === $valueOrCompare) {
                $cnt++;
            }
        }
    }
    return $cnt;
}

/**
 * 指定された要素以上の値が現れる最初の位置のインデックスを取得する
 * <code>
 * $list = [1, 3, 5, 5, 6, 8, 10];
 * lower_bound($list, 5);// => 2
 * lower_bound($list, 5, 3);// => 3
 * lower_bound($list, 15);// => false
 * </code>
 *
 * @param array $list 昇順ソート済配列
 * @param $key
 * @param int $start 配列の検索範囲開始位置
 * @return false|int 該当要素のキー値
 *      $key 以上の要素が無い場合はfalse
 */
function lower_bound(array $list, $key, int $start = 0)
{
    $l = $start;
    $r = count($list);
    if ($r === 0) {
        return false;// 空配列
    }
    if ($list[$r - 1] < $key || $r <= $l) {
        // $key以上の要素無し
        return false;
    }
    while (true) {
        $m = ($l + $r) >> 1;
        if ($list[$m] < $key) {
            $l = $m + 1;
        } else {
            $r = $m;
            if ($r === $l) {
                return $r;
            }
        }
    }
}

/**
 * 指定された要素より大きい値が現れる最初の位置のインデックスを取得する
 * <code>
 * $list = [1, 3, 5, 5, 6, 8, 10];
 * upper_bound($list, 5);// => 4
 * upper_bound($list, 4, 3);// => 3
 * upper_bound($list, 10);// => false
 * </code>
 *
 * @param array $list 昇順ソート済配列
 * @param $key
 * @param int $start 配列の検索範囲開始位置
 * @return false|int 該当要素のキー値
 *      $key より大きい要素が無い場合はfalse
 */
function upper_bound(array $list, $key, int $start = 0)
{
    $l = $start;
    $r = count($list);
    if ($r === 0) {
        return false;// 空配列
    }
    if ($list[$r - 1] <= $key || $r <= $l) {
        // $keyより大きい要素無し
        return false;
    }
    while (true) {
        $m = ($l + $r) >> 1;
        if ($list[$m] <= $key) {
            $l = $m + 1;
        } else {
            $r = $m;
            if ($r === $l) {
                return $r;
            }
        }
    }
}

/**
 * 正の整数を指定した基数表記に変換する
 *
 * <code>
 * convert_int_base(14387235, 10);// => '14387235'
 * convert_int_base(3, 2);// => '11'
 * convert_int_base(1024, 2);// => '10000000000'
 * convert_int_base(8, 8);// => '10'
 * convert_int_base(9, 9);// => '10'
 * convert_int_base(80, 9);// => '88'
 * convert_int_base(255, 16);// => 'ff'
 * </code>
 *
 * @param int $value 10進整数 >= 0
 * @param int $base 基数 [2, 16]
 * @return string $value を $base進表記にした文字列
 */
function convert_int_base(int $value, int $base): string
{
    assert($value >= 0);
    assert(2 <= $base && $base <= 16);

    if ($value === 0) {
        return '0';
    }
    if ($base === 10) {
        return (string)$value;// 10進数表記に変更（10進→10進）
    }

    static $digit = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f'];
    $ret = '';
    while ($value > 0) {
        $rem = $value % $base;
        $ret = $digit[$rem] . $ret;
        $value = intdiv($value, $base);
    }
    return $ret;
}
