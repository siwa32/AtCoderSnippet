<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../snippets/FenwickTree.php";

class FenwickTreeTest extends TestCase
{
    /**
     * @covers FenwickTree::__construct
     */
    public function test__construct(): void
    {
        $target = new FenwickTree(10);
        self::assertThat($target->getSize(), self::equalTo(10));
        for ($i = 0; $i < $target->getSize(); ++$i) {
            self::assertThat($target->get($i), self::equalTo(0), "0で初期化されている");
        }
    }

    /**
     * @covers FenwickTree::__construct
     */
    public function test__construct_初期値を設定した場合(): void
    {
        $target = new FenwickTree(10, 3);
        for ($i = 0; $i < $target->getSize(); ++$i) {
            self::assertThat($target->get($i), self::equalTo(3));
        }
    }

    /**
     * @covers FenwickTree::getSize
     */
    public function testGetSize(): void
    {
        $target = new FenwickTree(10);
        self::assertThat($target->getSize(), self::equalTo(10));
    }

    /**
     * @covers FenwickTree::add
     */
    public function testAdd(): void
    {
        $target = new FenwickTree(7);
        $target->add(0, 10);
        self::assertThat($target->sum(0), self::equalTo(10));
        $target->add(1, 11);
        self::assertThat($target->sum(0), self::equalTo(10));
        self::assertThat($target->sum(1), self::equalTo(21));
        $target->add(2, 12);
        self::assertThat($target->sum(1), self::equalTo(21));
        self::assertThat($target->sum(2), self::equalTo(33));
        $target->add(3, 13);
        self::assertThat($target->sum(2), self::equalTo(33));
        self::assertThat($target->sum(3), self::equalTo(46));
        $target->add(4, 14);
        self::assertThat($target->sum(3), self::equalTo(46));
        self::assertThat($target->sum(4), self::equalTo(60));
        $target->add(5, 15);
        self::assertThat($target->sum(4), self::equalTo(60));
        self::assertThat($target->sum(5), self::equalTo(75));
        $target->add(6, 16);
        self::assertThat($target->sum(5), self::equalTo(75));
        self::assertThat($target->sum(6), self::equalTo(91));
        $target->add(3, -3);
        self::assertThat($target->sum(2), self::equalTo(33));
        self::assertThat($target->sum(3), self::equalTo(43));
    }

    /**
     * @covers FenwickTree::add
     */
    public function testAdd_0を追加しても変化無い(): void
    {
        $target = new FenwickTree(3);
        $target->add(0, 10);
        $target->add(1, 11);
        $target->add(2, 12);
        self::assertThat($target->sum(0), self::equalTo(10));
        self::assertThat($target->sum(1), self::equalTo(21));
        self::assertThat($target->sum(2), self::equalTo(33));

        $target->add(0, 0);
        self::assertThat($target->sum(0), self::equalTo(10));
        self::assertThat($target->sum(1), self::equalTo(21));
        self::assertThat($target->sum(2), self::equalTo(33));
        $target->add(1, 0);
        self::assertThat($target->sum(0), self::equalTo(10));
        self::assertThat($target->sum(1), self::equalTo(21));
        self::assertThat($target->sum(2), self::equalTo(33));
        $target->add(2, 0);
        self::assertThat($target->sum(0), self::equalTo(10));
        self::assertThat($target->sum(1), self::equalTo(21));
        self::assertThat($target->sum(2), self::equalTo(33));
    }

    /**
     * @covers FenwickTree::set
     */
    public function testSet(): void
    {
        $target = new FenwickTree(7);
        $target->set(0, 10);
        self::assertThat($target->sum(0), self::equalTo(10));
        $target->set(1, 11);
        self::assertThat($target->sum(0), self::equalTo(10));
        self::assertThat($target->sum(1), self::equalTo(21));
        $target->set(2, 12);
        self::assertThat($target->sum(1), self::equalTo(21));
        self::assertThat($target->sum(2), self::equalTo(33));
        $target->set(3, 13);
        self::assertThat($target->sum(2), self::equalTo(33));
        self::assertThat($target->sum(3), self::equalTo(46));
        $target->set(4, 14);
        self::assertThat($target->sum(3), self::equalTo(46));
        self::assertThat($target->sum(4), self::equalTo(60));
        $target->set(2, -14);
        self::assertThat($target->sum(1), self::equalTo(21));
        self::assertThat($target->sum(2), self::equalTo(7));
    }

    /**
     * @covers FenwickTree::sum
     */
    public function testSum(): void
    {
        $target = new FenwickTree(5);
        $target->add(0, 10);
        $target->add(1, 11);
        $target->add(2, 12);
        $target->add(3, 13);
        $target->add(4, 14);
        self::assertThat($target->sum(0), self::equalTo(10));
        self::assertThat($target->sum(1), self::equalTo(21));
        self::assertThat($target->sum(2), self::equalTo(33));
        self::assertThat($target->sum(3), self::equalTo(46));
        self::assertThat($target->sum(4), self::equalTo(60));
        $target->add(3, -3);
        self::assertThat($target->sum(0), self::equalTo(10));
        self::assertThat($target->sum(1), self::equalTo(21));
        self::assertThat($target->sum(2), self::equalTo(33));
        self::assertThat($target->sum(3), self::equalTo(43));
        self::assertThat($target->sum(4), self::equalTo(57));
        $target->add(4, 10);
        self::assertThat($target->sum(0), self::equalTo(10));
        self::assertThat($target->sum(1), self::equalTo(21));
        self::assertThat($target->sum(2), self::equalTo(33));
        self::assertThat($target->sum(3), self::equalTo(43));
        self::assertThat($target->sum(4), self::equalTo(67));
    }

    /**
     * @covers FenwickTree::sum
     */
    public function testSum_0未満の場合は0(): void
    {
        $target = new FenwickTree(3);
        $target->add(0, 10);
        $target->add(1, 11);
        $target->add(2, 12);
        self::assertThat($target->sum(-1), self::equalTo(0));
        self::assertThat($target->sum(-111), self::equalTo(0));
    }

    /**
     * @covers FenwickTree::get
     */
    public function testGet(): void
    {
        $target = new FenwickTree(7);
        $target->set(0, 10);
        self::assertThat($target->get(0), self::equalTo(10));
        $target->set(1, 11);
        self::assertThat($target->get(1), self::equalTo(11));
        $target->set(2, 12);
        self::assertThat($target->get(2), self::equalTo(12));
        $target->set(3, 13);
        self::assertThat($target->get(3), self::equalTo(13));
        $target->set(4, 14);
        self::assertThat($target->get(4), self::equalTo(14));
        $target->set(2, -14);
        self::assertThat($target->get(2), self::equalTo(-14));
    }

    /**
     * @covers FenwickTree::lower_bound
     */
    public function testLowerBound(): void
    {
        $target = new FenwickTree(5);
        $target->add(0, 10);
        $target->add(1, 11);
        $target->add(2, 12);
        $target->add(3, 13);
        $target->add(4, 14);

        self::assertThat($target->lower_bound(-1), self::equalTo(0));
        self::assertThat($target->lower_bound(0), self::equalTo(0));
        self::assertThat($target->lower_bound(1), self::equalTo(0));
        self::assertThat($target->lower_bound(9), self::equalTo(0));
        self::assertThat($target->lower_bound(10), self::equalTo(0));
        self::assertThat($target->lower_bound(11), self::equalTo(1));
        self::assertThat($target->lower_bound(20), self::equalTo(1));
        self::assertThat($target->lower_bound(21), self::equalTo(1));
        self::assertThat($target->lower_bound(22), self::equalTo(2));
        self::assertThat($target->lower_bound(32), self::equalTo(2));
        self::assertThat($target->lower_bound(33), self::equalTo(2));
        self::assertThat($target->lower_bound(34), self::equalTo(3));
        self::assertThat($target->lower_bound(45), self::equalTo(3));
        self::assertThat($target->lower_bound(46), self::equalTo(3));
        self::assertThat($target->lower_bound(47), self::equalTo(4));
        self::assertThat($target->lower_bound(60), self::equalTo(4));
    }

    /**
     * @covers FenwickTree::lower_bound
     */
    public function testLowerBound_超えない場合(): void
    {
        $target = new FenwickTree(5);
        $target->add(0, 10);
        $target->add(1, 11);
        $target->add(2, 12);
        $target->add(3, 13);
        $target->add(4, 14);

        self::assertThat($target->lower_bound(61), self::isFalse());
        self::assertThat($target->lower_bound(1000), self::isFalse());
    }
}
