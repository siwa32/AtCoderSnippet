<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../snippets/AdjacencyListGraph.php";

class AdjacencyListGraphTest extends TestCase
{
    function setUp(): void
    {
        parent::setUp();
    }

    function tearDown(): void
    {
        parent::tearDown();
    }

    function testIsDirected_無向グラフの場合()
    {
        $g = new AdjacencyListGraph(false);
        self::assertThat($g->isDirected(), self::isFalse());
    }

    function testIsDirected_有向グラフの場合()
    {
        $g = new AdjacencyListGraph(true);
        self::assertThat($g->isDirected(), self::isTrue());
    }

    function testIsDirected_デフォルトは有向グラフ()
    {
        $g = new AdjacencyListGraph();
        self::assertThat($g->isDirected(), self::isTrue());
    }

    function testCountEdge_無向グラフの場合()
    {
        $g = new AdjacencyListGraph(false);
        self::assertThat($g->countEdge(), self::equalTo(0));
        $g->addEdge(0, 1, 10);
        self::assertThat($g->countEdge(), self::equalTo(2));
    }

    function testCountEdge_有向グラフの場合()
    {
        $g = new AdjacencyListGraph(true);
        self::assertThat($g->countEdge(), self::equalTo(0));
        $g->addEdge(0, 1, 10);
        self::assertThat($g->countEdge(), self::equalTo(1));
    }

    function testAddEdge_無向グラフの場合()
    {
        $g = new AdjacencyListGraph(false);
        self::assertThat($g->countEdge(), self::equalTo(0));
        $g->addEdge(0, 1, 10);

        self::assertThat($g->countEdge(), self::equalTo(2));

        $edges = $g->getEdges(0);
        self::assertThat(count($edges), self::equalTo(1));
        self::assertThat($edges[0]->cost, self::equalTo(10));
        self::assertThat($edges[0]->from, self::equalTo(0));
        self::assertThat($edges[0]->to, self::equalTo(1));

        $edges = $g->getEdges(1);
        self::assertThat(count($edges), self::equalTo(1));
        self::assertThat($edges[0]->cost, self::equalTo(10));
        self::assertThat($edges[0]->from, self::equalTo(1));
        self::assertThat($edges[0]->to, self::equalTo(0));
    }

    function testAddEdge_有向グラフの場合()
    {
        $g = new AdjacencyListGraph(true);
        self::assertThat($g->countEdge(), self::equalTo(0));
        $g->addEdge(0, 1, 10);
        self::assertThat($g->countEdge(), self::equalTo(1));

        $edges = $g->getEdges(0);
        self::assertThat(count($edges), self::equalTo(1));
        self::assertThat($edges[0]->cost, self::equalTo(10));
        self::assertThat($edges[0]->from, self::equalTo(0));
        self::assertThat($edges[0]->to, self::equalTo(1));
    }

    function testIsNodeExists_無向グラフの場合()
    {
        $g = new AdjacencyListGraph(false);
        self::assertThat($g->isNodeExists(0), self::isFalse());
        self::assertThat($g->isNodeExists(1), self::isFalse());
        $g->addEdge(0, 1, 10);
        self::assertThat($g->isNodeExists(0), self::isTrue());
        self::assertThat($g->isNodeExists(1), self::isTrue());

        self::assertThat($g->isNodeExists(2), self::isFalse());
        $g->addEdge(1, 2, 10);
        self::assertThat($g->isNodeExists(2), self::isTrue());
    }

    function testIsNodeExists_有向グラフの場合()
    {
        $g = new AdjacencyListGraph(true);
        self::assertThat($g->isNodeExists(0), self::isFalse());
        self::assertThat($g->isNodeExists(1), self::isFalse());
        $g->addEdge(0, 1, 10);
        self::assertThat($g->isNodeExists(0), self::isTrue());
        self::assertThat($g->isNodeExists(1), self::isFalse(), "行き先がないノードは存在しない扱い");

        self::assertThat($g->isNodeExists(2), self::isFalse());
        $g->addEdge(1, 2, 10);
        self::assertThat($g->isNodeExists(1), self::isTrue());
        self::assertThat($g->isNodeExists(2), self::isFalse(), "行き先がないノードは存在しない扱い");
    }

    function testBfs()
    {
        $g = new AdjacencyListGraph(false);
        $g->addEdge(0, 1, 10);
        $g->addEdge(0, 2, 16);
        $g->addEdge(0, 3, 12);
        $g->addEdge(1, 2, 18);
        $g->addEdge(3, 2, 3);
        $g->addEdge(1, 4, 4);
        $g->addEdge(2, 5, 1);
        $g->addEdge(3, 5, 5);
        $g->addEdge(4, 6, 21);
        $g->addEdge(5, 6, 9);
        $params = [];
        $g->bfs(0, function ($i, $from, $dist) use (&$params) {
            $params[] = [$i, $from, $dist];
            return true;
        });
        $expectBfsOrders = [
            [0, -1, 0],
            [1, 0, 1],
            [2, 0, 1],
            [3, 0, 1],
            [4, 1, 2],
            [5, 2, 2],
            [6, 4, 3],
        ];
        self::assertThat($params, self::equalTo($expectBfsOrders));
    }

    function testBfs_途中で中断する()
    {
        $g = new AdjacencyListGraph(false);
        $g->addEdge(0, 1, 10);
        $g->addEdge(0, 2, 16);
        $g->addEdge(0, 3, 12);
        $g->addEdge(1, 2, 18);
        $g->addEdge(3, 2, 3);
        $g->addEdge(1, 4, 4);
        $g->addEdge(2, 5, 1);
        $g->addEdge(3, 5, 5);
        $g->addEdge(4, 6, 21);
        $g->addEdge(5, 6, 9);
        $params = [];
        $g->bfs(0, function ($i, $from, $dist) use (&$params) {
            $params[] = [$i, $from, $dist];
            if ($i === 2) {
                return false;// 中断
            }
            return true;
        });
        $expectBfsOrders = [
            [0, -1, 0],
            [1, 0, 1],
            [2, 0, 1],
        ];
        self::assertThat($params, self::equalTo($expectBfsOrders));
    }

    function testDfs()
    {
        $g = new AdjacencyListGraph(false);
        $g->addEdge(0, 1, 10);
        $g->addEdge(0, 2, 16);
        $g->addEdge(0, 3, 12);
        $g->addEdge(1, 4, 4);
        $g->addEdge(1, 7, 4);
        $g->addEdge(2, 5, 1);
        $g->addEdge(4, 6, 21);
        $g->addEdge(4, 8, 21);
        $params = [];
        $g->dfs(0,
            function (int $i, int $parent, int $depth) use (&$params) {
                $params[] = [$i, 'pre', $parent, $depth];
                return true;
            },
            function (int $i, int $parent, int $depth, int $descendantCount) use (&$params) {
                $params[] = [$i, 'post', $parent, $depth, $descendantCount];
                return true;
            }
        );
        $expectDfsOrders = [
            [0, 'pre', -1, 0],
            [1, 'pre', 0, 1],
            [4, 'pre', 1, 2],
            [6, 'pre', 4, 3],
            [6, 'post', 4, 3, 0],
            [8, 'pre', 4, 3],
            [8, 'post', 4, 3, 0],
            [4, 'post', 1, 2, 2],
            [7, 'pre', 1, 2],
            [7, 'post', 1, 2, 0],
            [1, 'post', 0, 1, 4],
            [2, 'pre', 0, 1],
            [5, 'pre', 2, 2],
            [5, 'post', 2, 2, 0],
            [2, 'post', 0, 1, 1],
            [3, 'pre', 0, 1],
            [3, 'post', 0, 1, 0],
            [0, 'post', -1, 0, 8],
        ];
        self::assertThat($params, self::equalTo($expectDfsOrders));
    }

    function testDfs_コールバック指定無しでも呼出可能()
    {
        try {
            $g = new AdjacencyListGraph();
            $g->addEdge(0, 1, 10);
            $g->addEdge(0, 2, 16);
            $g->dfs(0);
        } catch (Exception $e) {
            self::assertTrue(false);
        }
        self::assertTrue(true);
    }

    function testDfs_行きがけの処理で途中中断()
    {
        $g = new AdjacencyListGraph(false);
        $g->addEdge(0, 1, 10);
        $g->addEdge(0, 2, 16);
        $g->addEdge(0, 3, 12);
        $g->addEdge(1, 4, 4);
        $g->addEdge(1, 7, 4);
        $g->addEdge(2, 5, 1);
        $g->addEdge(4, 6, 21);
        $g->addEdge(4, 8, 21);
        $params = [];
        $g->dfs(0,
            function (int $i, int $parent, int $depth) use (&$params) {
                $params[] = [$i, 'pre', $parent, $depth];
                if ($i === 6) {
                    return false;//中断
                }
                return true;
            },
            function (int $i, int $parent, int $depth, int $descendantCount) use (&$params) {
                $params[] = [$i, 'post', $parent, $depth, $descendantCount];
                return true;
            }
        );
        $expectDfsOrders = [
            [0, 'pre', -1, 0],
            [1, 'pre', 0, 1],
            [4, 'pre', 1, 2],
            [6, 'pre', 4, 3],
        ];
        self::assertThat($params, self::equalTo($expectDfsOrders));
    }

    function testDfs_帰りがけ処理で途中中断()
    {
        $g = new AdjacencyListGraph(false);
        $g->addEdge(0, 1, 10);
        $g->addEdge(0, 2, 16);
        $g->addEdge(0, 3, 12);
        $g->addEdge(1, 4, 4);
        $g->addEdge(1, 7, 4);
        $g->addEdge(2, 5, 1);
        $g->addEdge(4, 6, 21);
        $g->addEdge(4, 8, 21);
        $params = [];
        $g->dfs(0,
            function (int $i, int $parent, int $depth) use (&$params) {
                $params[] = [$i, 'pre', $parent, $depth];
                return true;
            },
            function (int $i, int $parent, int $depth, int $descendantCount) use (&$params) {
                $params[] = [$i, 'post', $parent, $depth, $descendantCount];
                if ($i === 6) {
                    return false;//中断
                }
                return true;
            }
        );
        $expectDfsOrders = [
            [0, 'pre', -1, 0],
            [1, 'pre', 0, 1],
            [4, 'pre', 1, 2],
            [6, 'pre', 4, 3],
            [6, 'post', 4, 3, 0],
        ];
        self::assertThat($params, self::equalTo($expectDfsOrders));
    }
}
