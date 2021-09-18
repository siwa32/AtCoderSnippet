<?php

/**
 * 順列
 * 指定した配列の要素を使用して出来る辞書順の次の順列
 *
 * <code>
 * foreach (next_permutation([1,2,3]) as $perm) {
 *     print_r($perm);
 * }
 *
 * => [1,2,3]
 * => [1,3,2]
 * => [2,1,2]
 * => [2,3,1]
 * => [3,1,2]
 * => [3,2,1]
 * </code>
 *
 * @param array $sortedElements 昇順ソート済配列
 * @return Generator
 */
function next_permutation(array $sortedElements): Generator
{
    $_permutation = function (array $sortedElements, int $i = 0, array $res = [], array $used = []) use (&$_permutation): Generator {
        $elementCount = count($sortedElements);
        $pre = null;
        foreach ($sortedElements as $k => $item) {
            if ($used[$k] ?? false) {
                continue;
            }
            if ($item === $pre) {
                continue;
            }
            $used[$k] = true;
            $pre = $item;
            $next = $res;
            $next[] = $item;
            if ($i === $elementCount - 1) {
                yield $next;
            } else {
                foreach ($_permutation($sortedElements, $i + 1, $next, $used) as $result) {
                    yield $result;
                }
            }
            $used[$k] = false;
        }
    };
    foreach ($_permutation($sortedElements) as $item) {
        yield $item;
    }
}

/**
 * 指定した配列の要素で出来る順列を辞書順に列挙する
 *
 * <code>
 * $p = permutations([1,2,3]);
 * print_r($p)
 *
 * => [
 *      0 => [1,2,3],
 *      1 => [1,3,2],
 *      2 => [2,1,2],
 *      3 => [2,3,1],
 *      4 => [3,1,2],
 *      5 => [3,2,1],
 *    ]
 * </code>
 *
 * @param array $sortedElements 昇順ソート済配列
 * @return array
 */
function permutations(array $sortedElements): array
{
    $res = [];
    foreach (next_permutation($sortedElements) as $permutation) {
        $res[] = $permutation;
    }
    return $res;
}
