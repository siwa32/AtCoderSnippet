<?php

/**
 * ワーシャルフロイド法による経路探索
 * 計算量 O(頂点数 ** 3)
 */
class WarshallFloyd
{
    public const INF_COST = PHP_INT_MAX - 1;

    private int $size;
    private bool $isDirected;
    private array $distance;
    private array $path;

    /**
     * @param bool $isDirected 有向グラフならtrue, 無向グラフならfalse
     */
    public function __construct(int $size, bool $isDirected = true)
    {
        $this->size = $size;
        $this->isDirected = $isDirected;
        $this->distance = array_fill(0, $size, array_fill(0, $size, self::INF_COST));
    }

    public function isDirected(): bool
    {
        return $this->isDirected;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $from
     * @param int $to
     * @param int $cost コスト
     */
    public function addEdge(int $from, int $to, int $cost = 1): void
    {
        if ($from < 0 || $this->size <= $from) {
            throw new InvalidArgumentException();
        }
        if ($to < 0 || $this->size <= $to) {
            throw new InvalidArgumentException();
        }

        $this->distance[$from][$to] = $cost;
        if (!$this->isDirected) {
            // 無向グラフなので逆向きも定義
            $this->distance[$to][$from] = $cost;
        }
    }

    public function calc(): void
    {
        for ($i = 0; $i < $this->size; ++$i) {
            $this->distance[$i][$i] = 0;
        }
        $this->path = [];
        for ($k = 0; $k < $this->size; ++$k) {
            $dk = &$this->distance[$k];
            for ($i = 0; $i < $this->size; ++$i) {
                $di = &$this->distance[$i];
                for ($j = 0; $j < $this->size; ++$j) {
                    $ij = $di[$j];
                    $ik = $di[$k];
                    $kj = $dk[$j];
                    $this->path[$i][$j] = $j;
                    if ($ij > $ik + $kj) {
                        $di[$j] = $ik + $kj;
                        $this->path[$i][$j] = $k;
                    }
                }
            }
        }
    }

    public function getCost(int $from, int $to): int
    {
        if ($from < 0 || $this->size <= $from) {
            throw new InvalidArgumentException();
        }
        if ($to < 0 || $this->size <= $to) {
            throw new InvalidArgumentException();
        }
        return $this->distance[$from][$to];
    }

    public function isExistRoute(int $from, int $to): bool
    {
        if ($from < 0 || $this->size <= $from) {
            throw new InvalidArgumentException();
        }
        if ($to < 0 || $this->size <= $to) {
            throw new InvalidArgumentException();
        }
        return $this->distance[$from][$to] < self::INF_COST;
    }

    public function getPath(int $from, int $to): array
    {
        if ($from < 0 || $this->size <= $from) {
            throw new InvalidArgumentException();
        }
        if ($to < 0 || $this->size <= $to) {
            throw new InvalidArgumentException();
        }

        if (!isset($this->path[$from][$to])) {
            return [];
        }

        $res = [];
        $res[] = $from;
        $__path = function(int $from, int $to) use(&$__path, &$res) {
            $k = $this->path[$from][$to];
            if ($to === $k) {
                $res[] = $to;
            } else {
                $__path($from, $k, $res);
                $__path($k, $to, $res);
            }
        };
        $__path($from, $to);
        return $res;
    }
}

if (0) {
    $wf = new WarshallFloyd(7, false);
    $wf->addEdge(0, 1, 10);
    $wf->addEdge(0, 2, 16);
    $wf->addEdge(0, 3, 12);
    $wf->addEdge(1, 2, 18);
    $wf->addEdge(3, 2, 3);
    $wf->addEdge(1, 4, 4);
    $wf->addEdge(2, 5, 1);
    $wf->addEdge(3, 5, 5);
    $wf->addEdge(4, 6, 21);
    $wf->addEdge(5, 6, 9);
    $wf->calc();
    for ($i = 0; $i < 7; ++$i) {
        for ($j = 0; $j < 7; ++$j) {
            echo "{$i} -> {$j} : " . $wf->getCost($i, $j) . " path: ";
            $path = $wf->getPath($i, $j);
            foreach ($path as $node) {
                echo "{$node} ";
            }
            echo PHP_EOL;
        }
    }
}
