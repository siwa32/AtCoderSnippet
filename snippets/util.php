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
