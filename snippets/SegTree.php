<?php

/**
 * セグメント木
 */
class SegTree
{
    private array $node;
    private int $size;
    private int $capacity;
    private $init;

    public function __construct(int $size, $init = 0)
    {
        assert($size > 0);

        $this->size = $size;

        $this->capacity = 1;
        while ($this->capacity < $size) {
            $this->capacity <<= 1;
        }

        $this->node = [];
        $this->init = $init;
    }

    public function set(int $i, $value, bool $build = true): void
    {
        if ($i < 0 || $this->size <= $i) {
            return;
        }

        $this->node[$this->capacity - 1 + $i] = $value;
        if ($build) {
            $k = $this->capacity - 1 + $i;
            while ($k > 0) {
                $k = intdiv($k - 1, 2);// parent
                $this->node[$k] = $this->buildNode($this->node[2 * $k + 1] ?? null, $this->node[2 * $k + 2] ?? null);
            }
        }
    }

    public function build(): void
    {
        for ($k = $this->capacity - 2; $k >= 0; --$k) {
            $this->node[$k] = $this->buildNode($this->node[2 * $k + 1] ?? null, $this->node[2 * $k + 2] ?? null);
        }
    }

    public function get(int $i)
    {
        if ($i < 0 || $this->size <= $i) {
            throw new OutOfBoundsException();
        }

        return $this->node[$this->capacity - 1 + $i] ?? $this->init;
    }

    /**
     * 区間[$start, $end) に指定した値を加算する
     * @param mixed $v
     * @param int $start
     * @param int $end
     */
    public function add($v, int $start, int $end): void
    {
        if ($end <= 0 || $this->size <= $start) {
            throw new OutOfBoundsException();
        }
        for ($i = $start; $i < $end; ++$i) {
            $this->set($i, $this->get($i) + $v, false);
        }
        $this->buildRange($start, $end);
    }

    /**
     * 区間[$start, $end) を指定した値に更新する
     * @param mixed $v
     * @param int $start
     * @param int $end
     */
    public function update($v, int $start, int $end): void
    {
        if ($end <= 0 || $this->size <= $start) {
            throw new OutOfBoundsException();
        }
        for ($i = $start; $i < $end; ++$i) {
            $this->set($i, $v, false);
        }
        $this->buildRange($start, $end);
    }

    /**
     * 区間[$start, $end) の最小値を取得する
     * @param int $start 開始閉区間
     * @param int $end 終了開区間
     * @return mixed
     * @throws OutOfBoundsException
     */
    public function min(int $start, int $end)
    {
        assert($start <= $end);
        if ($end <= 0 || $this->size <= $start) {
            throw new OutOfBoundsException();
        }

        return $this->element($start, $end, 'min');
    }

    /**
     * 区間[$start, $end) の最大値を取得する
     * @param int $start 開始閉区間
     * @param int $end 終了開区間
     * @return mixed
     * @throws OutOfBoundsException
     */
    public function max(int $start, int $end)
    {
        assert($start <= $end);
        if ($end <= 0 || $this->size <= $start) {
            throw new OutOfBoundsException();
        }

        return $this->element($start, $end, 'max');
    }

    /**
     * 区間[$start, $end) の和を取得する
     * @param int $start 開始閉区間
     * @param int $end 終了開区間
     * @return mixed
     * @throws OutOfBoundsException
     */
    public function sum(int $start, int $end)
    {
        assert($start <= $end);
        if ($end <= 0 || $this->size <= $start) {
            throw new OutOfBoundsException();
        }

        return $this->element($start, $end, 'sum');
    }

    private function element(int $start, int $end, string $id)
    {
        static $fn = [];
        if (empty($fn)) {
            $fn = [
                'sum' => fn ($a, $b) => ($a ?? 0) + ($b ?? 0),
                'min' => fn ($a, $b) => min($a ?? INF, $b ?? INF),
                'max' => fn ($a, $b) => max($a ?? -INF, $b ?? -INF),
            ];
        }

        $_elm = function (int $start, int $end, $k, $segL, $segR) use (&$_elm, $id, $fn) {
            if ($start >= $segR || $end <= $segL) {
                return null;// 外側
            }
            if ($start <= $segL && $segR <= $end) {
                // 区間をすべて含む範囲
                if (isset($this->node[$k])) {
                    return $this->node[$k][$id] ?? $this->node[$k];
                }
                return $this->init;
            }
            $m = intdiv($segL + $segR, 2);
            $valL = $_elm($start, $end, $k * 2 + 1, $segL, $m);
            $valR = $_elm($start, $end, $k * 2 + 2, $m, $segR);
            return $fn[$id]($valL, $valR);
        };
        return $_elm($start, $end, 0, 0, $this->capacity);
    }

    private function buildNode($childL, $childR): array
    {
        $childL ??= $this->init;
        $childR ??= $this->init;
        return [
            'min' => min($childL['min'] ?? $childL, $childR['min'] ?? $childR),
            'max' => max($childL['max'] ?? $childL, $childR['max'] ?? $childR),
            'sum' => ($childL['sum'] ?? $childL) + ($childR['sum'] ?? $childR),
        ];
    }

    private function buildRange(int $start, int $end): void
    {
        $ks = intdiv($this->capacity - 1 + $start - 1, 2);// parent
        $ke = intdiv($this->capacity - 1 + $end - 2, 2);// parent
        while (true) {
            for ($k = $ks; $k <= $ke ; ++$k) {
                $this->node[$k] = $this->buildNode($this->node[2 * $k + 1] ?? null, $this->node[2 * $k + 2] ?? null);
            }
            if ($ks === 0) {
                break;
            }
            $ks = intdiv($ks - 1, 2);// parent
            $ke = intdiv($ke - 1, 2);// parent
        }
    }
}
