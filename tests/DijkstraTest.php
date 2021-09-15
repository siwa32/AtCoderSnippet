<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../snippets/Dijkstra.php";
require_once __DIR__ . "/../snippets/AdjacencyListGraph.php";

class DijkstraTest extends TestCase
{
    public function testGetStart()
    {
        $g = new AdjacencyListGraph(false);
        $g->addEdge(0, 1);
        $g->addEdge(1, 2);
        $target = Dijkstra::calc(1, $g);
        self::assertThat($target->getStart(), self::equalTo(1));
    }

    public function testCalc_戻り値の型はDijkstra()
    {
        $g = new AdjacencyListGraph(false);
        $g->addEdge(0, 1);
        $g->addEdge(1, 2);
        $target = Dijkstra::calc(1, $g);
        self::assertThat($target, self::isInstanceOf(Dijkstra::class));
    }

    public function testCalc()
    {
        $g = new AdjacencyListGraph(false);
        $e = [
            [0, 1, 6],
            [0, 2, 3],
            [0, 3, 8],
            [1, 7, 5],
            [1, 10, 11],
            [1, 4, 3],
            [2, 4, 7],
            [2, 5, 4],
            [2, 6, 8],
            [3, 6, 7],
            [3, 8, 9],
            [4, 9, 5],
            [5, 9, 2],
            [5, 11, 12],
            [6, 11, 7],
            [6, 8, 5],
            [7, 12, 10],
            [7, 10, 5],
            [8, 14, 9],
            [9, 10, 3],
            [9, 13, 7],
            [10, 12, 6],
            [10, 13, 5],
            [11, 14, 6],
            [12, 13, 8],
            [13, 14, 5],
        ];
        foreach ($e as $item) {
            $g->addEdge($item[0], $item[1], $item[2]);
        }
        $target = Dijkstra::calc(0, $g);
        self::assertThat($target->getCost(14), self::equalTo(21));
        self::assertThat($target->getPath(14), self::equalTo([0, 2, 5, 9, 13, 14]));
        self::assertThat($target->getCost(11), self::equalTo(18));
        self::assertThat($target->getPath(11), self::equalTo([0, 2, 6, 11]));
        self::assertThat($target->getCost(8), self::equalTo(16));
        self::assertThat($target->getPath(8), self::equalTo([0, 2, 6, 8]));
        self::assertThat($target->getCost(3), self::equalTo(8));
        self::assertThat($target->getPath(3), self::equalTo([0, 3]));
        self::assertThat($target->getCost(0), self::equalTo(0));
        self::assertThat($target->getPath(0), self::equalTo([0]));
    }

    public function testCalc_有向グラフの場合()
    {
        $g = new AdjacencyListGraph(true);
        $e = [
            [0, 1, 6],
            [0, 2, 3],
            [3, 0, 8],
            [1, 7, 5],
            [1, 10, 11],
            [1, 4, 3],
            [2, 4, 7],
            [2, 5, 4],
            [2, 6, 8],
            [3, 6, 7],
            [3, 8, 9],
            [4, 9, 5],
            [9, 5, 2],
            [5, 11, 12],
            [6, 11, 7],
            [6, 8, 5],
            [7, 12, 10],
            [7, 10, 5],
            [8, 14, 9],
            [9, 10, 3],
            [9, 13, 7],
            [10, 12, 6],
            [10, 13, 5],
            [11, 14, 6],
            [12, 13, 8],
            [13, 14, 5],
        ];
        foreach ($e as $item) {
            $g->addEdge($item[0], $item[1], $item[2]);
        }
        $target = Dijkstra::calc(0, $g);
        self::assertThat($target->getCost(14), self::equalTo(24));
        self::assertThat($target->getPath(14), self::equalTo([0, 2, 6, 11, 14]));
        self::assertThat($target->getCost(11), self::equalTo(18));
        self::assertThat($target->getPath(11), self::equalTo([0, 2, 6, 11]));
        self::assertThat($target->getCost(8), self::equalTo(16));
        self::assertThat($target->getPath(8), self::equalTo([0, 2, 6, 8]));
        self::assertThat($target->getCost(0), self::equalTo(0));
        self::assertThat($target->getPath(0), self::equalTo([0]));
    }

    public function testCalc_たどり着けないノードの場合()
    {
        $g = new AdjacencyListGraph(true);
        $e = [
            [0, 1, 6],
            [0, 2, 3],
            [3, 0, 8],
            [1, 4, 3],
            [2, 4, 7],
            [2, 5, 4],
            [2, 6, 8],
            [3, 6, 7],
            [3, 7, 9],
            [6, 7, 5],
        ];
        foreach ($e as $item) {
            $g->addEdge($item[0], $item[1], $item[2]);
        }
        $target = Dijkstra::calc(0, $g);
        self::assertThat($target->getCost(3), self::isFalse());
        self::assertThat($target->getPath(3), self::isFalse());
    }
}
