<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../snippets/SegTree.php";

class SegTreeTest extends TestCase
{
    public function testSetGet()
    {
        $segTree = new SegTree(10);
        $segTree->set(0, 1);
        self::assertThat($segTree->get(0), self::equalTo(1));
        $segTree->set(4, 44);
        self::assertThat($segTree->get(4), self::equalTo(44));
        $segTree->set(9, 90);
        self::assertThat($segTree->get(9), self::equalTo(90));
    }

    public function testSum()
    {
        $segTree = new SegTree(10);

        $expect = 0;
        for ($i = 0; $i < 7; ++$i) {
            $segTree->set($i, $i * 10, false);
            $expect += $i * 10;
        }
        $segTree->set(9, 9 * 10, false);
        $segTree->build();
        $expect += 9 * 10;
        self::assertThat($segTree->sum(0, 10), self::equalTo($expect));
        self::assertThat($segTree->sum(7, 9), self::equalTo(0));
        self::assertThat($segTree->sum(7, 10), self::equalTo(90));
        self::assertThat($segTree->sum(1, 5), self::equalTo(100));
        self::assertThat($segTree->sum(2, 3), self::equalTo(20));
        self::assertThat($segTree->sum(5, 6), self::equalTo(50));
        self::assertThat($segTree->sum(9, 10), self::equalTo(90));
    }

    public function testSet_構築しない()
    {
        $segTree = new SegTree(10);

        $segTree->set(0, 1, false);
        $segTree->set(5, 2, false);
        $segTree->set(8, 3, false);
        self::assertThat($segTree->get(0), self::equalTo(1));
        self::assertThat($segTree->get(5), self::equalTo(2));
        self::assertThat($segTree->get(8), self::equalTo(3));
        self::assertThat($segTree->sum(0, 10), self::equalTo(0));
        self::assertThat($segTree->max(0, 10), self::equalTo(0));
        self::assertThat($segTree->min(0, 10), self::equalTo(0));
    }

    public function testBuild()
    {
        $segTree = new SegTree(10);

        $segTree->set(0, 1, false);
        $segTree->set(5, 2, false);
        $segTree->set(8, 3, false);
        $segTree->build();
        self::assertThat($segTree->sum(0, 10), self::equalTo(6));
        self::assertThat($segTree->max(0, 10), self::equalTo(3));
        self::assertThat($segTree->min(0, 10), self::equalTo(0));
    }

    public function testMax()
    {
        $segTree = new SegTree(10);

        $segTree->set(0, 1, false);
        $segTree->set(1, 4, false);
        $segTree->set(2, 5, false);
        $segTree->set(3, -3, false);
        $segTree->set(4, 20, false);
        $segTree->set(5, 2, false);
        $segTree->set(8, 3, false);
        $segTree->set(9, -10, false);
        $segTree->build();
        self::assertThat($segTree->max(0, 10), self::equalTo(20));
        self::assertThat($segTree->max(7, 9), self::equalTo(3));
        self::assertThat($segTree->max(7, 10), self::equalTo(3));
        self::assertThat($segTree->max(1, 5), self::equalTo(20));
        self::assertThat($segTree->max(2, 3), self::equalTo(5));
        self::assertThat($segTree->max(5, 6), self::equalTo(2));
        self::assertThat($segTree->max(9, 10), self::equalTo(-10));
    }

    public function testMin()
    {
        $segTree = new SegTree(10);

        $segTree->set(0, 1, false);
        $segTree->set(1, 4, false);
        $segTree->set(2, 5, false);
        $segTree->set(3, -3, false);
        $segTree->set(4, 20, false);
        $segTree->set(5, 2, false);
        $segTree->set(8, 3, false);
        $segTree->set(9, -10, false);
        $segTree->build();
        self::assertThat($segTree->min(0, 10), self::equalTo(-10));
        self::assertThat($segTree->min(7, 9), self::equalTo(0));
        self::assertThat($segTree->min(7, 10), self::equalTo(-10));
        self::assertThat($segTree->min(1, 5), self::equalTo(-3));
        self::assertThat($segTree->min(2, 3), self::equalTo(5));
        self::assertThat($segTree->min(5, 6), self::equalTo(2));
        self::assertThat($segTree->min(9, 10), self::equalTo(-10));
    }

    public function testAdd()
    {
        $segTree = new SegTree(10);

        $segTree->set(0, 1, false);
        $segTree->set(1, 4, false);
        $segTree->set(2, 5, false);
        $segTree->set(3, -3, false);
        $segTree->set(4, 20, false);
        $segTree->set(5, 2, false);
        $segTree->set(8, 3, false);
        $segTree->set(9, -10, false);
        $segTree->build();

        $segTree->add(3, 3, 7);
        self::assertThat($segTree->get(0), self::equalTo(1), "変更されない");
        self::assertThat($segTree->get(1), self::equalTo(4), "変更されない");
        self::assertThat($segTree->get(2), self::equalTo(5), "変更されない");
        self::assertThat($segTree->get(3), self::equalTo(0));
        self::assertThat($segTree->get(4), self::equalTo(23));
        self::assertThat($segTree->get(5), self::equalTo(5));
        self::assertThat($segTree->get(6), self::equalTo(3));
        self::assertThat($segTree->get(7), self::equalTo(0), "変更されない");
        self::assertThat($segTree->get(8), self::equalTo(3), "変更されない");
        self::assertThat($segTree->get(9), self::equalTo(-10), "変更されない");
        self::assertThat($segTree->sum(0, 10), self::equalTo(34));
        self::assertThat($segTree->min(0, 10), self::equalTo(-10));
        self::assertThat($segTree->min(3, 7), self::equalTo(0));
        self::assertThat($segTree->max(0, 10), self::equalTo(23));
        self::assertThat($segTree->max(0, 3), self::equalTo(5));
        self::assertThat($segTree->max(7, 10), self::equalTo(3));
    }

    public function testUpdate()
    {
        $segTree = new SegTree(10);

        $segTree->set(0, 1, false);
        $segTree->set(1, 4, false);
        $segTree->set(2, 5, false);
        $segTree->set(3, -3, false);
        $segTree->set(4, 20, false);
        $segTree->set(5, 2, false);
        $segTree->set(8, 3, false);
        $segTree->set(9, -10, false);
        $segTree->build();

        $segTree->update(3, 3, 7);
        self::assertThat($segTree->get(0), self::equalTo(1), "変更されない");
        self::assertThat($segTree->get(1), self::equalTo(4), "変更されない");
        self::assertThat($segTree->get(2), self::equalTo(5), "変更されない");
        self::assertThat($segTree->get(3), self::equalTo(3));
        self::assertThat($segTree->get(4), self::equalTo(3));
        self::assertThat($segTree->get(5), self::equalTo(3));
        self::assertThat($segTree->get(6), self::equalTo(3));
        self::assertThat($segTree->get(7), self::equalTo(0), "変更されない");
        self::assertThat($segTree->get(8), self::equalTo(3), "変更されない");
        self::assertThat($segTree->get(9), self::equalTo(-10), "変更されない");
        self::assertThat($segTree->sum(0, 10), self::equalTo(15));
        self::assertThat($segTree->min(0, 10), self::equalTo(-10));
        self::assertThat($segTree->min(3, 7), self::equalTo(3));
        self::assertThat($segTree->max(0, 10), self::equalTo(5));
        self::assertThat($segTree->max(0, 3), self::equalTo(5));
        self::assertThat($segTree->max(7, 10), self::equalTo(3));
    }
}
