<?php

/**
 * Binary Indexed Tree
 */
class FenwickTree
{
    /**
     * @var positive-int
     */
    private int $size;

    private array $data;

    /**
     * @param positive-int $size
     * @param int|float|mixed $initial
     */
    public function __construct(int $size, $initial = 0)
    {
        $this->size = $size;
        $this->data = array_fill(1, $size, 0);// 1-index
        if ($initial !== 0) {
            for ($i = 0; $i < $size; ++$i) {
                $this->add($i, $initial);
            }
        }
    }

    /**
     * @return positive-int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $i
     * @param int|float $v
     */
    public function add(int $i, $v): void
    {
        assert(0 <= $i && $i < $this->size);

        if ($v === 0) {
            return;
        }

        ++$i;// 1-indexにする
        while ($i <= $this->size) {
            $this->data[$i] += $v;
            $i += $i & (-$i);
        }
    }

    /**
     * @param int $i
     * @return int|float
     */
    public function sum(int $i)
    {
        if ($i < 0) {
            return 0;
        }
        $i = min($i, $this->size - 1);

        ++$i;// 1-indexにする
        $sum = 0;
        while ($i > 0) {
            $sum += $this->data[$i];
            $i -= $i & (-$i);
        }
        return $sum;
    }

    /**
     * @param int $i
     * @return int|float
     */
    public function get(int $i)
    {
        assert(0 <= $i && $i < $this->size);
        return $this->sum($i) - $this->sum($i - 1);
    }

    /**
     * @param int $i
     * @param int|float
     */
    public function set(int $i, $v): void
    {
        assert(0 <= $i && $i < $this->size);
        $this->add($i, $v - $this->get($i));
    }

    /**
     * x を超える裁縫の位置を求める
     * 単調増加の場合のみ
     * @param $x
     * @return int|false
     */
    public function lower_bound($x)
    {
        if ($x <= 0) {
            return 0;
        }

        $len = 1;
        while ($len < $this->size) {
            $len <<= 1;
        }
        $sum = 0;
        $i = 1;
        while ($len > 0) {
            if (isset($this->data[$i + $len - 1]) && $sum + $this->data[$i + $len - 1] < $x) {
                $sum += $this->data[$i + $len - 1];
                $i += $len;
            }
            $len >>= 1;
        }
        return ($i <= $this->size) ? $i - 1 : false;// 1-index -> 0-index
    }
}
