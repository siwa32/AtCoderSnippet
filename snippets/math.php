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

