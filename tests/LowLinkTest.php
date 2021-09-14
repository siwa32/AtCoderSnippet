<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../snippets/LowLink.php";

class LowLinkTest extends TestCase
{
    public function testCalc_戻り値の型はLowLink()
    {
        $g = new AdjacencyListGraph(false);
        $g->addEdge(0, 1);
        $ll = LowLink::calc($g);
        self::assertThat($ll, self::isInstanceOf(LowLink::class));
    }

    public function testCalc()
    {
        $g = new AdjacencyListGraph(false);
        $g->addEdge(0, 1);
        $g->addEdge(0, 2);
        $g->addEdge(1, 2);
        $g->addEdge(0, 3);
        $g->addEdge(3, 4);

        $ll = LowLink::calc($g);

        $aps = $ll->getArticulationPoints();
        self::assertThat($aps, self::countOf(2));
        sort($aps);
        self::assertThat($aps, self::equalTo([0, 3]));

        $bridges = $ll->getBridges();
        self::assertThat($bridges, self::countOf(2));
        sort($bridges);
        self::assertThat($bridges, self::equalTo([[0, 3], [3, 4]]));
    }

    public function testCalc_分岐無しグラフ()
    {
        $g = new AdjacencyListGraph(false);
        $g->addEdge(1, 2);
        $g->addEdge(3, 4);
        $g->addEdge(2, 3);
        $g->addEdge(0, 1);
        $g->addEdge(0, 5);

        $ll = LowLink::calc($g);

        $aps = $ll->getArticulationPoints();
        sort($aps);
        self::assertThat($aps, self::countOf(4));
        self::assertThat($aps, self::equalTo([0, 1, 2, 3]));

        $bridges = $ll->getBridges();
        sort($bridges);
        self::assertThat($bridges, self::countOf(5));
        self::assertThat($bridges, self::equalTo([[0, 1], [0, 5], [1, 2], [2, 3], [3, 4]]));
    }

    public function testCalc_有向グラフの場合は例外()
    {
        $g = new AdjacencyListGraph(true);
        $g->addEdge(1, 2);
        $g->addEdge(0, 1);

        $this->expectException(InvalidArgumentException::class);
        LowLink::calc($g);
    }

    public function testCalc_2()
    {
        $g = new AdjacencyListGraph(false);
        $g->addEdge(1, 3);
        $g->addEdge(3, 4);
        $g->addEdge(4, 5);
        $g->addEdge(4, 6);
        $g->addEdge(5, 6);
        $g->addEdge(6, 7);
        $g->addEdge(7, 2);

        $ll = LowLink::calc($g);

        $aps = $ll->getArticulationPoints();
        self::assertThat($aps, self::countOf(4));
        sort($aps);
        self::assertThat($aps, self::equalTo([3, 4, 6, 7]));

        $bridges = $ll->getBridges();
        self::assertThat($bridges, self::countOf(4));
        sort($bridges);
        self::assertThat($bridges, self::equalTo([[1, 3], [2, 7], [3, 4], [6, 7]]));
    }

    public function testCalc_間接点と橋が存在しない場合()
    {
        $g = new AdjacencyListGraph(false);
        $g->addEdge(1, 2);
        $g->addEdge(2, 3);
        $g->addEdge(3, 1);

        $ll = LowLink::calc($g);

        $aps = $ll->getArticulationPoints();
        self::assertThat($aps, self::isEmpty());

        $bridges = $ll->getBridges();
        self::assertThat($bridges, self::isEmpty());
    }
}
