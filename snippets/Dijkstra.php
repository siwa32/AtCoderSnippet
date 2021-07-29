<?php

/**
 * ダイクストラ法
 */
class Dijkstra
{
    public $costs = [];
    public $path = [];

    public function reset(): void
    {
        $this->costs = [];
        $this->path = [];
    }

    public function calc(int $start, int $goal, AdjacencyListGraph $graph)
    {
        if ($start === $goal) {
            return 0;
        }

        $queue = new SplPriorityQueue();
        $queue->insert([$start, null], 0);
        $this->costs = [];
        $this->costs[$start] = 0;
        $this->path[$start] = null;
        while (!$queue->isEmpty()) {
            $current = $queue->top();
            $queue->next();

            $edges = $graph->getEdges($current[0]);// 隣のノード
            foreach ($edges as $edge) {
                if ($edge->from === $current[1]) {
                    continue;// 遷移元へ後戻りしない
                }

                assert($edge->cost >= 0, "ダイクストラ法は負のコスト不可");
                $cost = $this->costs[$current[0]] + $edge->cost;
                if ($this->updateCost($edge, $cost)) {
                    $queue->insert([$edge->to, $current[0]], -$cost);// [to, from]
                }
            }
        }

        return $this->costs[$goal] ?? false;
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
     * @return int[]
     */
    public function getPath(int $node): array
    {
        assert(!empty($this->path));

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
