<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../snippets/TopologicalSort.php";

class TopologicalSortTest extends TestCase
{
    /** @var TopologicalSort */
    private $target;

    function setUp(): void
    {
        parent::setUp();
        $this->target = new TopologicalSort();
    }

    function tearDown(): void
    {
        parent::tearDown();
    }

    public function testClear()
    {
        $this->target = new TopologicalSort();
        $this->target->addItem(1);
        $this->target->addItem(2);
        $this->target->clear();
        self::assertThat($this->target->sort(), self::equalTo([]));
    }

    public function testSort()
    {
        $conditions = [
            [2, 1],
            [3, 4],
            [2, 4],
        ];
        foreach ($conditions as $condition) {
            $this->target->addOrder($condition[0], $condition[1]);
        }

        $actual = $this->target->sort();
        foreach ($conditions as $condition) {
            $i = array_search($condition[0], $actual);
            $j = array_search($condition[1], $actual);
            self::assertThat($i, self::lessThan($j), "{$condition[0]} は $condition[1] より前でなければならない");
        }
    }

    public function testSort_順序の制約が無い項目がある場合()
    {
        $conditions = [
            [2, 1],
            [3, 4],
            [2, 4],
        ];
        foreach ($conditions as $condition) {
            $this->target->addOrder($condition[0], $condition[1]);
        }
        $this->target->addItem(5);
        $this->target->addItem(6);

        $actual = $this->target->sort();
        foreach ($conditions as $condition) {
            $i = array_search($condition[0], $actual);
            $j = array_search($condition[1], $actual);
            self::assertThat($i, self::lessThan($j), "{$condition[0]} は $condition[1] より前でなければならない");
        }
        self::assertThat(in_array(5, $actual), self::isTrue());
        self::assertThat(in_array(6, $actual), self::isTrue());
    }

    public function testSort_項目が文字列()
    {
        $conditions = [
            ["aa2", "aa1"],
            ["aa3", "aa4"],
            ["aa2", "aa4"],
        ];
        foreach ($conditions as $condition) {
            $this->target->addOrder($condition[0], $condition[1]);
        }

        $actual = $this->target->sort();
        foreach ($conditions as $condition) {
            $i = array_search($condition[0], $actual);
            $j = array_search($condition[1], $actual);
            self::assertThat($i, self::lessThan($j), "{$condition[0]} は $condition[1] より前でなければならない");
        }
    }

    public function testSort_制約の順序に出来ない場合はnullを返す()
    {
        $conditions = [
            [1, 2],
            [2, 1],
        ];

        foreach ($conditions as $condition) {
            $this->target->addOrder($condition[0], $condition[1]);
        }
        $actual = $this->target->sort();
        self::assertThat($actual, self::isNull());
    }
}
