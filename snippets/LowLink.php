<?php

/**
 * 無向グラフの間接点と橋を求める
 */
class LowLink
{
    private array $articulationPoints;
    private array $bridges;

    private function __construct()
    {
        $this->bridges = [];
        $this->articulationPoints = [];
    }

    public static function calc(AdjacencyListGraph $undirectedGraph): self
    {
        if ($undirectedGraph->isDirected()) {
            throw new InvalidArgumentException();// 有向グラフは不可
        }

        $thiz = new self();

        $used = [];
        $ord = [];
        $low = [];
        $_dfs = static function (int $current, int $i, int $parent) use (&$_dfs, &$undirectedGraph, &$used, &$ord, &$low, &$thiz)
        {
            $used[$current] = true;
            $ord[$current] = $i;
            $low[$current] = $i;
            ++$i;

            $edges = $undirectedGraph->getEdges($current);// 隣のノード
            $childCount = 0;// 子の数
            $isAps = false;
            foreach ($edges as $edge) {
                if ($edge->to === $parent) {
                    continue;// 遷移元へ後戻りしない
                }
                if ($used[$edge->to] ?? false) {
                    // 後退辺の時
                    $low[$current] = min($low[$current], $ord[$edge->to]);
                } else {
                    ++$childCount;
                    $i = $_dfs($edge->to, $i, $current);
                    $low[$current] = min($low[$current], $low[$edge->to]);
                    if ($parent !== -1 && $ord[$current] <= $low[$edge->to]) {
                        $isAps = true;
                    }
                    if ($ord[$current] < $low[$edge->to]) {
                        // 小さいノードを先にする
                        $thiz->bridges[] = ($current < $edge->to) ? [$current, $edge->to] : [$edge->to, $current];
                    }
                }
            }
            if ($parent === -1 && $childCount >= 2) {
                $isAps = true;
            }
            if ($isAps) {
                $thiz->articulationPoints[] = $current;
            }
            return $i;
        };

        $nodes = $undirectedGraph->getNodes();
        $i = 0;
        foreach ($nodes as $node) {
            if (!($used[$node] ?? false)) {
                $i = $_dfs($node, $i, -1);
            }
        }

        return $thiz;
    }

    /**
     * 橋
     * @return int[]
     */
    public function getBridges(): array
    {
        return $this->bridges;
    }

    /**
     * 間接点
     * @return array
     */
    public function getArticulationPoints(): array
    {
        return $this->articulationPoints;
    }
}
