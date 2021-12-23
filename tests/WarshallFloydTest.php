<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../snippets/WarshallFloyd.php";

class WarshallFloydTest extends TestCase
{
    /**
     * @covers WarshallFloyd::__construct
     * @covers WarshallFloyd::getSize
     * @covers WarshallFloyd::isDirected
     */
    public function test__construct(): void
    {
        $target = new WarshallFloyd(7, true);
        self::assertThat($target->getSize(), self::equalTo(7));
        self::assertThat($target->isDirected(), self::isTrue());
    }

    /**
     * @covers WarshallFloyd::__construct
     */
    public function test__construct_グラフ種指定省略した場合有向グラフ(): void
    {
        $target = new WarshallFloyd(7);
        self::assertThat($target->isDirected(), self::isTrue());
    }

    /**
     * @covers WarshallFloyd::__construct
     */
    public function test__construct_初期コストは最大値(): void
    {
        $target = new WarshallFloyd(7, false);
        self::assertThat($target->getCost(0, 0), self::equalTo(WarshallFloyd::INF_COST));
        self::assertThat($target->getCost(0, 6), self::equalTo(WarshallFloyd::INF_COST));
        self::assertThat($target->getCost(6, 0), self::equalTo(WarshallFloyd::INF_COST));
        self::assertThat($target->getCost(6, 6), self::equalTo(WarshallFloyd::INF_COST));
        self::assertThat($target->getCost(3, 2), self::equalTo(WarshallFloyd::INF_COST));
        self::assertThat($target->isPathExist(0, 0), self::isFalse());
        self::assertThat($target->isPathExist(0, 6), self::isFalse());
        self::assertThat($target->isPathExist(6, 0), self::isFalse());
        self::assertThat($target->isPathExist(6, 6), self::isFalse());
        self::assertThat($target->isPathExist(3, 2), self::isFalse());
    }

    /**
     * @covers WarshallFloyd::isDirected
     */
    public function testIsDirected_無効グラフの場合(): void
    {
        $target = new WarshallFloyd(7, false);
        self::assertThat($target->isDirected(), self::isFalse());
    }

    /**
     * @covers WarshallFloyd::isDirected
     */
    public function testIsDirected_有効グラフの場合(): void
    {
        $target = new WarshallFloyd(7, true);
        self::assertThat($target->isDirected(), self::isTrue());
    }

    /**
     * @covers WarshallFloyd::getSize
     */
    public function testGetSize(): void
    {
        $target = new WarshallFloyd(128, true);
        self::assertThat($target->getSize(), self::equalTo(128));
    }

    /**
     * @covers WarshallFloyd::addEdge
     */
    public function testAddEdge_無向グラフの場合(): void
    {
        $target = new WarshallFloyd(6, false);
        $target->addEdge(0, 1, 10);
        $target->addEdge(0, 2, 16);
        $target->addEdge(0, 3, 12);
        $target->addEdge(1, 2, 18);
        $target->addEdge(3, 2, 3);
        $target->addEdge(1, 4, 4);
        $target->addEdge(2, 5, 1);
        $target->addEdge(3, 5, 5);
        self::assertThat($target->getCost(0, 1), self::equalTo(10));
        self::assertThat($target->getCost(1, 0), self::equalTo(10));
        self::assertThat($target->isPathExist(0, 1), self::isTrue());
        self::assertThat($target->isPathExist(1, 0), self::isTrue());
        self::assertThat($target->getCost(0, 2), self::equalTo(16));
        self::assertThat($target->getCost(2, 0), self::equalTo(16));
        self::assertThat($target->isPathExist(0, 2), self::isTrue());
        self::assertThat($target->isPathExist(2, 0), self::isTrue());
        self::assertThat($target->getCost(0, 3), self::equalTo(12));
        self::assertThat($target->getCost(3, 0), self::equalTo(12));
        self::assertThat($target->isPathExist(0, 3), self::isTrue());
        self::assertThat($target->isPathExist(3, 0), self::isTrue());
        self::assertThat($target->getCost(1, 2), self::equalTo(18));
        self::assertThat($target->getCost(2, 1), self::equalTo(18));
        self::assertThat($target->isPathExist(1, 2), self::isTrue());
        self::assertThat($target->isPathExist(2, 1), self::isTrue());
        self::assertThat($target->getCost(3, 2), self::equalTo(3));
        self::assertThat($target->getCost(2, 3), self::equalTo(3));
        self::assertThat($target->isPathExist(3, 2), self::isTrue());
        self::assertThat($target->isPathExist(2, 3), self::isTrue());
        self::assertThat($target->getCost(1, 4), self::equalTo(4));
        self::assertThat($target->getCost(4, 1), self::equalTo(4));
        self::assertThat($target->isPathExist(1, 4), self::isTrue());
        self::assertThat($target->isPathExist(4, 1), self::isTrue());
        self::assertThat($target->getCost(2, 5), self::equalTo(1));
        self::assertThat($target->getCost(5, 2), self::equalTo(1));
        self::assertThat($target->isPathExist(2, 5), self::isTrue());
        self::assertThat($target->isPathExist(5, 2), self::isTrue());
        self::assertThat($target->getCost(3, 5), self::equalTo(5));
        self::assertThat($target->getCost(5, 3), self::equalTo(5));
        self::assertThat($target->isPathExist(3, 5), self::isTrue());
        self::assertThat($target->isPathExist(5, 3), self::isTrue());

        self::assertThat($target->isPathExist(0, 4), self::isFalse());
        self::assertThat($target->isPathExist(4, 0), self::isFalse());
        self::assertThat($target->isPathExist(1, 5), self::isFalse());
        self::assertThat($target->isPathExist(5, 1), self::isFalse());
        self::assertThat($target->isPathExist(2, 4), self::isFalse());
        self::assertThat($target->isPathExist(4, 2), self::isFalse());
    }

    /**
     * @covers WarshallFloyd::addEdge
     */
    public function testAddEdge_有効グラフの場合(): void
    {
        $target = new WarshallFloyd(6, true);
        $target->addEdge(0, 1, 10);
        $target->addEdge(0, 2, 16);
        $target->addEdge(0, 3, 12);
        $target->addEdge(1, 2, 18);
        $target->addEdge(3, 2, 3);
        $target->addEdge(1, 4, 4);
        $target->addEdge(2, 5, 1);
        $target->addEdge(3, 5, 5);
        self::assertThat($target->getCost(0, 1), self::equalTo(10));
        self::assertThat($target->getCost(1, 0), self::equalTo(WarshallFloyd::INF_COST));
        self::assertThat($target->isPathExist(0, 1), self::isTrue());
        self::assertThat($target->isPathExist(1, 0), self::isFalse());
        self::assertThat($target->getCost(0, 2), self::equalTo(16));
        self::assertThat($target->getCost(2, 0), self::equalTo(WarshallFloyd::INF_COST));
        self::assertThat($target->isPathExist(0, 2), self::isTrue());
        self::assertThat($target->isPathExist(2, 0), self::isFalse());
        self::assertThat($target->getCost(0, 3), self::equalTo(12));
        self::assertThat($target->getCost(3, 0), self::equalTo(WarshallFloyd::INF_COST));
        self::assertThat($target->isPathExist(0, 3), self::isTrue());
        self::assertThat($target->isPathExist(3, 0), self::isFalse());
        self::assertThat($target->getCost(1, 2), self::equalTo(18));
        self::assertThat($target->getCost(2, 1), self::equalTo(WarshallFloyd::INF_COST));
        self::assertThat($target->isPathExist(1, 2), self::isTrue());
        self::assertThat($target->isPathExist(2, 1), self::isFalse());
        self::assertThat($target->getCost(3, 2), self::equalTo(3));
        self::assertThat($target->getCost(2, 3), self::equalTo(WarshallFloyd::INF_COST));
        self::assertThat($target->isPathExist(3, 2), self::isTrue());
        self::assertThat($target->isPathExist(2, 3), self::isFalse());
        self::assertThat($target->getCost(1, 4), self::equalTo(4));
        self::assertThat($target->getCost(4, 1), self::equalTo(WarshallFloyd::INF_COST));
        self::assertThat($target->isPathExist(1, 4), self::isTrue());
        self::assertThat($target->isPathExist(4, 1), self::isFalse());
        self::assertThat($target->getCost(2, 5), self::equalTo(1));
        self::assertThat($target->getCost(5, 2), self::equalTo(WarshallFloyd::INF_COST));
        self::assertThat($target->isPathExist(2, 5), self::isTrue());
        self::assertThat($target->isPathExist(5, 2), self::isFalse());
        self::assertThat($target->getCost(3, 5), self::equalTo(5));
        self::assertThat($target->getCost(5, 3), self::equalTo(WarshallFloyd::INF_COST));
        self::assertThat($target->isPathExist(3, 5), self::isTrue());
        self::assertThat($target->isPathExist(5, 3), self::isFalse());

        self::assertThat($target->isPathExist(0, 4), self::isFalse());
        self::assertThat($target->isPathExist(4, 0), self::isFalse());
        self::assertThat($target->isPathExist(1, 5), self::isFalse());
        self::assertThat($target->isPathExist(5, 1), self::isFalse());
        self::assertThat($target->isPathExist(2, 4), self::isFalse());
        self::assertThat($target->isPathExist(4, 2), self::isFalse());
    }

    /**
     * @covers WarshallFloyd::calc
     * @covers WarshallFloyd::getCost
     * @covers WarshallFloyd::isPathExist
     */
    public function testCalc_無向グラフの場合(): void
    {
        $target = new WarshallFloyd(6, false);
        $target->addEdge(0, 1, 10);
        $target->addEdge(0, 2, 16);
        $target->addEdge(0, 3, 12);
        $target->addEdge(1, 2, 18);
        $target->addEdge(3, 2, 3);
        $target->addEdge(1, 4, 4);
        $target->addEdge(2, 5, 1);
        $target->addEdge(3, 5, 5);
        $target->calc();

        for ($i = 0; $i < 6; ++$i) {
            self::assertThat($target->getCost($i, $i), self::equalTo(0), "移動無しはコスト0");
        }
        self::assertThat($target->getCost(0, 1), self::equalTo(10));
        self::assertThat($target->getCost(1, 0), self::equalTo(10));
        self::assertThat($target->getCost(0, 2), self::equalTo(15));
        self::assertThat($target->getCost(2, 0), self::equalTo(15));
        self::assertThat($target->getCost(0, 3), self::equalTo(12));
        self::assertThat($target->getCost(3, 0), self::equalTo(12));
        self::assertThat($target->getCost(1, 2), self::equalTo(18));
        self::assertThat($target->getCost(2, 1), self::equalTo(18));
        self::assertThat($target->getCost(3, 2), self::equalTo(3));
        self::assertThat($target->getCost(2, 3), self::equalTo(3));
        self::assertThat($target->getCost(1, 4), self::equalTo(4));
        self::assertThat($target->getCost(4, 1), self::equalTo(4));
        self::assertThat($target->getCost(2, 5), self::equalTo(1));
        self::assertThat($target->getCost(5, 2), self::equalTo(1));
        self::assertThat($target->getCost(3, 5), self::equalTo(4));
        self::assertThat($target->getCost(5, 3), self::equalTo(4));
        self::assertThat($target->getCost(0, 5), self::equalTo(16));
        self::assertThat($target->getCost(5, 0), self::equalTo(16));
        self::assertThat($target->getCost(2, 4), self::equalTo(22));
        self::assertThat($target->getCost(4, 2), self::equalTo(22));
        self::assertThat($target->isPathExist(0, 1), self::isTrue());
        self::assertThat($target->isPathExist(1, 0), self::isTrue());
        self::assertThat($target->isPathExist(0, 2), self::isTrue());
        self::assertThat($target->isPathExist(2, 0), self::isTrue());
        self::assertThat($target->isPathExist(0, 3), self::isTrue());
        self::assertThat($target->isPathExist(3, 0), self::isTrue());
        self::assertThat($target->isPathExist(1, 2), self::isTrue());
        self::assertThat($target->isPathExist(2, 1), self::isTrue());
        self::assertThat($target->isPathExist(3, 2), self::isTrue());
        self::assertThat($target->isPathExist(2, 3), self::isTrue());
        self::assertThat($target->isPathExist(1, 4), self::isTrue());
        self::assertThat($target->isPathExist(4, 1), self::isTrue());
        self::assertThat($target->isPathExist(2, 5), self::isTrue());
        self::assertThat($target->isPathExist(5, 2), self::isTrue());
        self::assertThat($target->isPathExist(3, 5), self::isTrue());
        self::assertThat($target->isPathExist(5, 3), self::isTrue());
        self::assertThat($target->isPathExist(0, 5), self::isTrue());
        self::assertThat($target->isPathExist(5, 0), self::isTrue());
        self::assertThat($target->isPathExist(2, 4), self::isTrue());
        self::assertThat($target->isPathExist(4, 2), self::isTrue());
    }

    /**
     * @covers WarshallFloyd::calc
     * @covers WarshallFloyd::getCost
     * @covers WarshallFloyd::isPathExist
     */
    public function testCalc_有効グラフの場合(): void
    {
        $target = new WarshallFloyd(6, true);
        $target->addEdge(0, 1, 10);
        $target->addEdge(0, 2, 16);
        $target->addEdge(0, 3, 12);
        $target->addEdge(1, 2, 18);
        $target->addEdge(3, 2, 3);
        $target->addEdge(1, 4, 4);
        $target->addEdge(2, 5, 1);
        $target->addEdge(3, 5, 5);
        $target->calc();

        for ($i = 0; $i < 6; ++$i) {
            self::assertThat($target->getCost($i, $i), self::equalTo(0), "移動無しはコスト0");
        }
        self::assertThat($target->getCost(0, 1), self::equalTo(10));
        self::assertThat($target->getCost(1, 0), self::equalTo(WarshallFloyd::INF_COST));
        self::assertThat($target->getCost(0, 2), self::equalTo(15));
        self::assertThat($target->getCost(2, 0), self::equalTo(WarshallFloyd::INF_COST));
        self::assertThat($target->getCost(0, 3), self::equalTo(12));
        self::assertThat($target->getCost(3, 0), self::equalTo(WarshallFloyd::INF_COST));
        self::assertThat($target->getCost(1, 2), self::equalTo(18));
        self::assertThat($target->getCost(2, 1), self::equalTo(WarshallFloyd::INF_COST));
        self::assertThat($target->getCost(3, 2), self::equalTo(3));
        self::assertThat($target->getCost(2, 3), self::equalTo(WarshallFloyd::INF_COST));
        self::assertThat($target->getCost(1, 4), self::equalTo(4));
        self::assertThat($target->getCost(4, 1), self::equalTo(WarshallFloyd::INF_COST));
        self::assertThat($target->getCost(2, 5), self::equalTo(1));
        self::assertThat($target->getCost(5, 2), self::equalTo(WarshallFloyd::INF_COST));
        self::assertThat($target->getCost(3, 5), self::equalTo(4));
        self::assertThat($target->getCost(5, 3), self::equalTo(WarshallFloyd::INF_COST));
        self::assertThat($target->getCost(0, 5), self::equalTo(16));
        self::assertThat($target->getCost(5, 0), self::equalTo(WarshallFloyd::INF_COST));
        self::assertThat($target->getCost(2, 4), self::equalTo(WarshallFloyd::INF_COST));
        self::assertThat($target->getCost(4, 2), self::equalTo(WarshallFloyd::INF_COST));
        self::assertThat($target->isPathExist(0, 1), self::isTrue());
        self::assertThat($target->isPathExist(1, 0), self::isFalse());
        self::assertThat($target->isPathExist(0, 2), self::isTrue());
        self::assertThat($target->isPathExist(2, 0), self::isFalse());
        self::assertThat($target->isPathExist(0, 3), self::isTrue());
        self::assertThat($target->isPathExist(3, 0), self::isFalse());
        self::assertThat($target->isPathExist(1, 2), self::isTrue());
        self::assertThat($target->isPathExist(2, 1), self::isFalse());
        self::assertThat($target->isPathExist(3, 2), self::isTrue());
        self::assertThat($target->isPathExist(2, 3), self::isFalse());
        self::assertThat($target->isPathExist(1, 4), self::isTrue());
        self::assertThat($target->isPathExist(4, 1), self::isFalse());
        self::assertThat($target->isPathExist(2, 5), self::isTrue());
        self::assertThat($target->isPathExist(5, 2), self::isFalse());
        self::assertThat($target->isPathExist(3, 5), self::isTrue());
        self::assertThat($target->isPathExist(5, 3), self::isFalse());
        self::assertThat($target->isPathExist(0, 5), self::isTrue());
        self::assertThat($target->isPathExist(5, 0), self::isFalse());
        self::assertThat($target->isPathExist(2, 4), self::isFalse());
        self::assertThat($target->isPathExist(4, 2), self::isFalse());
    }

    /**
     * @covers WarshallFloyd::calc
     * @covers WarshallFloyd::getPath
     */
    public function testGetPath_無向グラフの場合(): void
    {
        $target = new WarshallFloyd(3, false);
        $target->addEdge(0, 1, 1);
        $target->addEdge(0, 2, 1);
        $target->addEdge(1, 2, 3);
        $target->calc();
        self::assertThat($target->getPath(0, 1), self::equalTo([0, 1]));
        self::assertThat($target->getPath(0, 2), self::equalTo([0, 2]));
        self::assertThat($target->getPath(1, 2), self::equalTo([1, 0, 2]));
        self::assertThat($target->getPath(1, 0), self::equalTo([1, 0]));
        self::assertThat($target->getPath(2, 0), self::equalTo([2, 0]));
        self::assertThat($target->getPath(2, 1), self::equalTo([2, 0, 1]));
    }

    /**
     * @covers WarshallFloyd::calc
     * @covers WarshallFloyd::getPath
     */
    public function testGetPath_有効グラフの場合(): void
    {
        $target = new WarshallFloyd(3, true);
        $target->addEdge(0, 1, 1);
        $target->addEdge(0, 2, 1);
        $target->addEdge(1, 2, 3);
        $target->calc();
        self::assertThat($target->getPath(0, 1), self::equalTo([0, 1]));
        self::assertThat($target->getPath(0, 2), self::equalTo([0, 2]));
        self::assertThat($target->getPath(1, 2), self::equalTo([1, 2]));
        self::assertThat($target->getPath(1, 0), self::equalTo([]));
        self::assertThat($target->getPath(2, 0), self::equalTo([]));
        self::assertThat($target->getPath(2, 1), self::equalTo([]));
    }
}
