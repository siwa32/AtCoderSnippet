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

    /**
     * @covers AdjacencyListGraph::isDirected
     */
    function testIsDirected_無向グラフの場合()
    {
        $target = new AdjacencyListGraph(false);
        self::assertThat($target->isDirected(), self::isFalse());
    }

    /**
     * @covers AdjacencyListGraph::isDirected
     */
    function testIsDirected_有向グラフの場合()
    {
        $target = new AdjacencyListGraph(true);
        self::assertThat($target->isDirected(), self::isTrue());
    }

    /**
     * @covers AdjacencyListGraph::isDirected
     */
    function testIsDirected_デフォルトは有向グラフ()
    {
        $target = new AdjacencyListGraph();
        self::assertThat($target->isDirected(), self::isTrue());
    }

    /**
     * @covers AdjacencyListGraph::countEdge
     */
    function testCountEdge_無向グラフの場合()
    {
        $target = new AdjacencyListGraph(false);
        self::assertThat($target->countEdge(), self::equalTo(0));
        $target->addEdge(0, 1, 10);
        self::assertThat($target->countEdge(), self::equalTo(2));
        $target->addEdge(1, 2, 10);
        self::assertThat($target->countEdge(), self::equalTo(4));
    }

    /**
     * @covers AdjacencyListGraph::countEdge
     */
    function testCountEdge_同じノードに複数の辺がある無向グラフの場合()
    {
        $target = new AdjacencyListGraph(false);
        self::assertThat($target->countEdge(), self::equalTo(0));
        $target->addEdge(0, 1, 10);
        $target->addEdge(0, 2, 10);
        $target->addEdge(0, 3, 10);
        self::assertThat($target->countEdge(), self::equalTo(6));
    }

    /**
     * @covers AdjacencyListGraph::countEdge
     */
    function testCountEdge_有向グラフの場合()
    {
        $target = new AdjacencyListGraph(true);
        self::assertThat($target->countEdge(), self::equalTo(0));
        $target->addEdge(0, 1, 10);
        self::assertThat($target->countEdge(), self::equalTo(1));
        $target->addEdge(1, 2, 10);
        self::assertThat($target->countEdge(), self::equalTo(2));
    }

    /**
     * @covers AdjacencyListGraph::countEdge
     */
    function testCountEdge_同じノードに複数の辺がある有向グラフの場合()
    {
        $target = new AdjacencyListGraph(true);
        self::assertThat($target->countEdge(), self::equalTo(0));
        $target->addEdge(0, 1, 10);
        $target->addEdge(0, 2, 10);
        $target->addEdge(0, 3, 10);
        self::assertThat($target->countEdge(), self::equalTo(3));
    }

    /**
     * @covers AdjacencyListGraph::addEdge
     */
    function testAddEdge_無向グラフの場合()
    {
        $target = new AdjacencyListGraph(false);
        self::assertThat($target->countEdge(), self::equalTo(0));
        $target->addEdge(0, 1, 10);

        self::assertThat($target->countEdge(), self::equalTo(2));

        $edges = $target->getEdges(0);
        self::assertThat(count($edges), self::equalTo(1));
        self::assertThat($edges[0]->cost, self::equalTo(10));
        self::assertThat($edges[0]->from, self::equalTo(0));
        self::assertThat($edges[0]->to, self::equalTo(1));

        $edges = $target->getEdges(1);
        self::assertThat(count($edges), self::equalTo(1));
        self::assertThat($edges[0]->cost, self::equalTo(10));
        self::assertThat($edges[0]->from, self::equalTo(1));
        self::assertThat($edges[0]->to, self::equalTo(0));
    }

    /**
     * @covers AdjacencyListGraph::addEdge
     */
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

    /**
     * @covers AdjacencyListGraph::isNodeExists
     */
    function testIsNodeExists_無向グラフの場合()
    {
        $target = new AdjacencyListGraph(false);
        self::assertThat($target->isNodeExists(0), self::isFalse());
        self::assertThat($target->isNodeExists(1), self::isFalse());
        $target->addEdge(0, 1, 10);
        self::assertThat($target->isNodeExists(0), self::isTrue());
        self::assertThat($target->isNodeExists(1), self::isTrue());

        self::assertThat($target->isNodeExists(2), self::isFalse());
        $target->addEdge(1, 2, 10);
        self::assertThat($target->isNodeExists(2), self::isTrue());
    }

    /**
     * @covers AdjacencyListGraph::isNodeExists
     */
    function testIsNodeExists_有向グラフの場合()
    {
        $target = new AdjacencyListGraph(true);
        self::assertThat($target->isNodeExists(0), self::isFalse());
        self::assertThat($target->isNodeExists(1), self::isFalse());
        $target->addEdge(0, 1, 10);
        self::assertThat($target->isNodeExists(0), self::isTrue());
        self::assertThat($target->isNodeExists(1), self::isTrue());

        self::assertThat($target->isNodeExists(2), self::isFalse());
        $target->addEdge(1, 2, 10);
        self::assertThat($target->isNodeExists(1), self::isTrue());
        self::assertThat($target->isNodeExists(2), self::isTrue());
    }

    /**
     * @covers AdjacencyListGraph::nodeCount
     */
    function testNodeCount_無向グラフの場合()
    {
        $target = new AdjacencyListGraph(false);
        self::assertThat($target->nodeCount(), self::equalTo(0));
        $target->addEdge(0, 1, 10);
        self::assertThat($target->nodeCount(), self::equalTo(2));
        $target->addEdge(1, 2, 10);
        self::assertThat($target->nodeCount(), self::equalTo(3));
    }

    /**
     * @covers AdjacencyListGraph::nodeCount
     */
    function testNodeCount_有効グラフの場合()
    {
        $target = new AdjacencyListGraph(true);
        self::assertThat($target->nodeCount(), self::equalTo(0));
        $target->addEdge(0, 1, 10);
        self::assertThat($target->nodeCount(), self::equalTo(2));
        $target->addEdge(1, 2, 10);
        self::assertThat($target->nodeCount(), self::equalTo(3));
    }

    /**
     * @covers AdjacencyListGraph::getNodes
     */
    function testGetNodes_無向グラフの場合()
    {
        $target = new AdjacencyListGraph(false);
        self::assertThat($target->getNodes(), self::isEmpty());

        $target->addEdge(0, 1, 10);
        $target->addEdge(1, 2, 10);
        $actual = $target->getNodes();
        sort($actual);
        self::assertThat($actual, self::equalTo([0, 1, 2]));
    }

    /**
     * @covers AdjacencyListGraph::getNodes
     */
    function testGetNodes_有効グラフの場合()
    {
        $target = new AdjacencyListGraph(true);
        self::assertThat($target->getNodes(), self::isEmpty());

        $target->addEdge(0, 1, 10);
        $target->addEdge(1, 2, 10);
        $actual = $target->getNodes();
        sort($actual);
        self::assertThat($actual, self::equalTo([0, 1, 2]));
    }

    /**
     * @covers AdjacencyListGraph::bfs
     */
    function testBfs()
    {
        $target = new AdjacencyListGraph(false);
        $target->addEdge(0, 1, 10);
        $target->addEdge(0, 2, 16);
        $target->addEdge(0, 3, 12);
        $target->addEdge(1, 2, 18);
        $target->addEdge(3, 2, 3);
        $target->addEdge(1, 4, 4);
        $target->addEdge(2, 5, 1);
        $target->addEdge(3, 5, 5);
        $target->addEdge(4, 6, 21);
        $target->addEdge(5, 6, 9);
        $params = [];
        $target->bfs(0, function ($i, $from, $dist) use (&$params) {
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

    /**
     * @covers AdjacencyListGraph::bfs
     */
    function testBfs_途中で中断する()
    {
        $target = new AdjacencyListGraph(false);
        $target->addEdge(0, 1, 10);
        $target->addEdge(0, 2, 16);
        $target->addEdge(0, 3, 12);
        $target->addEdge(1, 2, 18);
        $target->addEdge(3, 2, 3);
        $target->addEdge(1, 4, 4);
        $target->addEdge(2, 5, 1);
        $target->addEdge(3, 5, 5);
        $target->addEdge(4, 6, 21);
        $target->addEdge(5, 6, 9);
        $params = [];
        $target->bfs(0, function ($i, $from, $dist) use (&$params) {
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

    /**
     * @covers AdjacencyListGraph::dfs
     */
    function testDfs()
    {
        $target = new AdjacencyListGraph(false);
        $target->addEdge(0, 1, 10);
        $target->addEdge(0, 2, 16);
        $target->addEdge(0, 3, 12);
        $target->addEdge(1, 4, 4);
        $target->addEdge(1, 7, 4);
        $target->addEdge(2, 5, 1);
        $target->addEdge(4, 6, 21);
        $target->addEdge(4, 8, 21);
        $params = [];
        $target->dfs(0,
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

    /**
     * @covers AdjacencyListGraph::dfs
     */
    function testDfs_コールバック指定無しでも呼出可能()
    {
        try {
            $target = new AdjacencyListGraph();
            $target->addEdge(0, 1, 10);
            $target->addEdge(0, 2, 16);
            $target->dfs(0);
        } catch (Exception $e) {
            self::assertTrue(false);
        }
        self::assertTrue(true);
    }

    /**
     * @covers AdjacencyListGraph::dfs
     */
    function testDfs_行きがけの処理で途中中断()
    {
        $target = new AdjacencyListGraph(false);
        $target->addEdge(0, 1, 10);
        $target->addEdge(0, 2, 16);
        $target->addEdge(0, 3, 12);
        $target->addEdge(1, 4, 4);
        $target->addEdge(1, 7, 4);
        $target->addEdge(2, 5, 1);
        $target->addEdge(4, 6, 21);
        $target->addEdge(4, 8, 21);
        $params = [];
        $target->dfs(0,
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

    /**
     * @covers AdjacencyListGraph::dfs
     */
    function testDfs_帰りがけ処理で途中中断()
    {
        $target = new AdjacencyListGraph(false);
        $target->addEdge(0, 1, 10);
        $target->addEdge(0, 2, 16);
        $target->addEdge(0, 3, 12);
        $target->addEdge(1, 4, 4);
        $target->addEdge(1, 7, 4);
        $target->addEdge(2, 5, 1);
        $target->addEdge(4, 6, 21);
        $target->addEdge(4, 8, 21);
        $params = [];
        $target->dfs(0,
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
