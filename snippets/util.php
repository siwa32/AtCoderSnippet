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
