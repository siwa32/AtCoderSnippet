<?php

/**
 * 二分探索
 */
class BinarySearch
{
    /**
     * 区間 [begin, end)で falseとなる区間[begin, x), trueとなる区間[x, end) の xを探索する
     * 後半のtrue区間の最初の位置
     *
     * @param int $begin 探索開始区間
     * @param int $end 探索終了開区間
     * @param callable $compare
     * @return false|int
     */
    public static function searchR(int $begin, int $end, callable $compare)
    {
        if ($compare($begin)) {
            return $begin;
        }
        $ng = $begin;
        $ok = $end;
        while (true) {
            $pt = $ng + intdiv($ok - $ng, 2);
            if ($compare($pt)) {
                $ok = $pt;
            } else {
                $ng = $pt;
            }
            if (abs($ok - $ng) <= 1) {
                break;
            }
        }
        return ($ok === $end) ? false : $ok;
    }

    /**
     * 区間 [begin, end)で trueとなる区間[begin, x], falseとなる区間(x, end) の xを探索する
     * 前半のtrue区間の最後の位置
     *
     * @param int $begin
     * @param int $end
     * @param callable $compare
     * @return false|int|mixed
     */
    public static function searchL(int $begin, int $end, callable $compare)
    {
        if (!$compare($begin)) {
            return false;
        }
        $ok = $begin;
        $ng = $end;
        while (true) {
            $pt = $ok + intdiv($ng - $ok, 2);
            if ($compare($pt)) {
                $ok = $pt;
            } else {
                $ng = $pt;
            }
            if (abs($ok - $ng) <= 1) {
                break;
            }
        }
        return ($ok === $end) ? false : $ok;
    }

//    public static function searchSection(int $begin, int $end, callable $compare)
//    {
//        while (true) {
//            $pt = ($begin + $end) >> 1;
//            if ($pt === $begin) {
//                return $pt;
//            }
//
//            $ret = $compare($pt);
//            if ($ret === 0) {
//                return $pt;
//            }
//            if ($ret > 0) {
//                // [$pt, $end) 間に探索範囲を狭める
//                $begin = $pt;
//            } else {
//                // [$begin, $pt) 間に探索範囲を狭める
//                $end = $pt;
//            }
//        }
//    }
}

/**
 * 配列を二分探索する
 * @param array $items 昇順ソート済配列
 * @param int $target 検索ターゲット
 * @return false|int
 *      一致した要素のインデックス
 *      見つからない場合はfalse
 *      複数要素が一致する場合はいずれかのインデックス
 */
function array_binary_search(array $items, int $target)
{
    $l = -1;
    $r = count($items);
    while ($r - $l > 1) {
        $pt = ($l + $r) >> 1;
        if ($items[$pt] === $target) {
            return $pt;
        }
        if ($items[$pt] < $target) {
            $l = $pt;
        } else {
            $r = $pt;
        }
    }
    return false;
}

/**
 * 配列を二分探索する
 * @param array $items 降順ソート済配列
 * @param int $target 検索ターゲット
 * @return false|int
 *      一致した要素のインデックス
 *      見つからない場合はfalse
 *      複数要素が一致する場合はいずれかのインデックス
 */
function array_binary_rsearch(array $items, int $target)
{
    $l = -1;
    $r = count($items);
    while ($r - $l > 1) {
        $pt = ($l + $r) >> 1;
        if ($items[$pt] === $target) {
            return $pt;
        }
        if ($items[$pt] > $target) {
            $l = $pt;
        } else {
            $r = $pt;
        }
    }
    return false;
}
