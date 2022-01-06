<?php

/**
 * ダイクストラ法
 */
class Dijkstra
{
    private array $costs;
    private array $path;
    private int $start;

    private function __construct(int $start)
    {
        $this->start = $start;
        $this->costs = [];
        $this->costs[$start] = 0;
        $this->path[$start] = null;
    }

    public static function calc(int $start, AdjacencyListGraph $graph): self
    {
        $thiz = new self($start);

        $queue = new SplPriorityQueue();
        $queue->insert([$start, null], 0);
        $checked = [];
        while (!$queue->isEmpty()) {
            $current = $queue->extract();
            if ($checked[$current[0]] ?? false) {
                continue;
            }
            $checked[$current[0]] = true;

            $edges = $graph->getEdges($current[0]);// 隣のノード
            foreach ($edges as $edge) {
                if ($edge->from === $current[1]) {
                    continue;// 遷移元へ後戻りしない
                }

                assert($edge->cost >= 0, "ダイクストラ法は負のコスト不可");
                $cost = $thiz->costs[$current[0]] + $edge->cost;
                if ($thiz->updateCost($edge, $cost)) {
                    $queue->insert([$edge->to, $current[0]], -$cost);// [to, from]
                }
            }
        }

        return $thiz;
    }

    public function getStart(): int
    {
        return $this->start;
    }

    /**
     * 指定ノードまでのコスト
     *
     * @param int $node
     * @return false|mixed たどり着けない場合はfalse
     */
    public function getCost(int $node)
    {
        assert(!empty($this->costs));

        return $this->costs[$node] ?? false;
    }

    /**
     * 指定ノードまでの経路
     *
     * @param int $node
     * @return int[]|false たどり着けない場合はfalse
     */
    public function getPath(int $node)
    {
        assert(!empty($this->path));

        if ($this->getCost($node) === false) {
            return false;
        }
        $path = [];
        $to = $node;
        while (true) {
            $path[] = $to;
            $to = $this->path[$to];
            if ($to === null) {
                return array_reverse($path);
            }
        }
    }

    private function updateCost(GraphEdge $edge, $cost): bool
    {
        if ($cost < ($this->costs[$edge->to] ?? PHP_INT_MAX)) {
            $this->costs[$edge->to] = $cost;
            $this->path[$edge->to] = $edge->from;// 経路元を記録
            return true;// コスト更新した
        }
        return false;
    }
}
