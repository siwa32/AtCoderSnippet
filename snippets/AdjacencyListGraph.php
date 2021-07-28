<?php

/**
 * 隣接リストグラフ
 */
class AdjacencyListGraph
{
    /** @var GraphEdge[]  */
    private array $adjacencyList = [];
    private bool $isDirected;

    /**
     * @param bool $isDirected 有向グラフならtrue, 無向グラフならfalse
     */
    public function __construct(bool $isDirected = true)
    {
        $this->isDirected = $isDirected;
    }

    public function isDirected(): bool
    {
        return $this->isDirected;
    }

    public function countEdge(): int
    {
        return count($this->adjacencyList);
    }

    /**
     * @param int $from
     * @param int $to
     * @param int|float|mixed $cost コスト
     */
    public function addEdge(int $from, int $to, $cost = 1): void
    {
        assert($from !== $to, "自己ループは不可");

        $this->adjacencyList[$from][] = new GraphEdge($from, $to, $cost);
        if (!$this->isDirected) {
            // 無向グラフなので逆向きも定義
            $this->adjacencyList[$to][] = new GraphEdge($to, $from, $cost);
        }
    }

    /**
     * @param int $i
     * @return GraphEdge[]
     */
    public function getEdges(int $i): array
    {
        return $this->adjacencyList[$i] ?? [];
    }

    public function isNodeExists(int $i): bool
    {
        return isset($this->adjacencyList[$i]);
    }

    public function bfs(int $start, callable $fn = null): void
    {
        bfs($this, $start, $fn);
    }

    public function dfs(int $start, callable $funcPreOrder = null, callable $funcPostOrder = null): void
    {
        dfs($this, $start, $funcPreOrder, $funcPostOrder);
    }
}

class GraphEdge
{
    public $cost;
    public int $from;
    public int $to;

    public function __construct(int $from, int $to, $cost = 1)
    {
        $this->from = $from;
        $this->to = $to;
        $this->cost = $cost;
    }

    /**
     * コストによる並べ替え
     *
     * @param GraphEdge[] $edges
     * @param bool $asc
     * @param bool $keepKey
     */
    public static function sortByCost(array& $edges, bool $asc = true, bool $keepKey = false): void
    {
        $comp = static function (GraphEdge $a, GraphEdge $b) use($asc): int {
            if ($a->cost === $b->cost) {
                return 0;
            }
            $positive = $asc ? 1 : -1;
            return $a->cost < $b->cost ? -$positive : $positive;
        };
        if ($keepKey) {
            uasort($edges, $comp);
        } else {
            usort($edges, $comp);
        }
    }
}

/**
 * 幅優先探索
 *
 * @param AdjacencyListGraph $graph
 * @param int $start
 * @param callable $fn
 */
function bfs(AdjacencyListGraph $graph, int $start, callable $fn = null)
{
    if (!$graph->isNodeExists($start)) {
        throw new InvalidArgumentException("find not node.");// スタートノードが存在しない
    }

    $queue = new SplQueue();

    $visited = [];
    $queue->enqueue([$start, 0]);
    $visited[$start] = true;// 訪問済みにする
    while (!$queue->isEmpty()) {
        $current = $queue->dequeue();

        if (is_callable($fn) && !$fn($current[0], $current[1])) {
            return;// 処理中止
        }

        $edges = $graph->getEdges($current[0]);// 隣のノード
        foreach ($edges as $edge) {
            if ($visited[$edge->to] ?? false) {
                continue;// 訪問済み
            }
            $queue->enqueue([$edge->to, $current[1] + 1]);
            $visited[$edge->to] = true;// 訪問済みにする
        }
    }
}

/**
 * 深さ優先探索
 *
 * @param AdjacencyListGraph $nonCycleGraph 閉路のないグラフ
 * @param int $start
 * @param callable|null $funcPreOrder
 * @param callable|null $funcPostOrder
 */
function dfs(AdjacencyListGraph $nonCycleGraph, int $start, callable $funcPreOrder = null, callable $funcPostOrder = null)
{
    if (!$nonCycleGraph->isNodeExists($start)) {
        throw new InvalidArgumentException("find not node.");// スタートノードが存在しない
    }

    $__dfs = static function (int $i, int $parent, $depth) use(&$__dfs, $nonCycleGraph, $funcPreOrder, $funcPostOrder) {
        // 行きがけの処理
        if (is_callable($funcPreOrder) && !$funcPreOrder($i, $parent, $depth)) {
            return false;// 処理中断
        }

        $edges = $nonCycleGraph->getEdges($i);// 隣のノード
        $descendantCount = 0;// 子孫数
        foreach ($edges as $edge) {
            if ($edge->to === $parent) {
                continue;// 遷移元へ後戻りしない
            }
            $ret = $__dfs($edge->to, $i, $depth + 1);
            if ($ret === false) {
                return false;// 処理中断
            }
            $descendantCount += $ret;
        }

        // 帰りがけの処理
        if (is_callable($funcPostOrder) && !$funcPostOrder($i, $parent, $depth, $descendantCount)) {
            return false;// 処理中断
        }
        return 1 + $descendantCount;
    };
    $__dfs($start, -1, 0);
}
