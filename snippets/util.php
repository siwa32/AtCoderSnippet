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
