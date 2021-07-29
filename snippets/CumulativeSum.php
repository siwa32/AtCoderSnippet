<?php

/**
 * 累積和
 */
class CumulativeSum
{
    private array $sum;

    protected function __construct()
    {
    }

    public static function init(array $indexedValues): self
    {
        $thiz = new self();

        $thiz->sum = [];
        $sum = 0;
        foreach ($indexedValues as $v) {
            $sum += $v;
            $thiz->sum[] = $sum;
        }
        return $thiz;
    }

    public function sum(int $start, int $end)
    {
        return $this->sum[$end] - ($this->sum[$start - 1] ?? 0);
    }
}
