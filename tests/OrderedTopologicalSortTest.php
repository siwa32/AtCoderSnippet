<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../snippets/OrderedTopologicalSort.php";

class OrderedTopologicalSortTest extends TestCase
{
    /** @var OrderedTopologicalSort */
    private $target;

    function setUp(): void
    {
        parent::setUp();
        $this->target = new OrderedTopologicalSort();
    }

    function tearDown(): void
    {
        parent::tearDown();
    }

    public function testClear()
    {
        $this->target->addItem(1);
        $this->target->addItem(2);
        $this->target->clear();
        self::assertThat($this->target->sort(), self::equalTo([]));
    }

    public function testSort_可能な範囲で昇順()
    {
        $conditions = [
            [0, 1],
            [1, 3],
            [2, 4],
            [2, 3],
            [4, 5],
        ];
        $expected = [
            0, 1, 2, 3, 4, 5
        ];
        foreach ($conditions as $condition) {
            $this->target->addOrder($condition[0], $condition[1]);
        }

        $actual = $this->target->sort(false);
        self::assertThat($actual, self::equalTo($expected));
    }

    public function testSort_可能な範囲で降順()
    {
        $conditions = [
            [0, 1],
            [1, 3],
            [2, 4],
            [2, 3],
            [4, 5],
        ];
        $expected = [
            2, 4, 5, 0, 1, 3
        ];
        foreach ($conditions as $condition) {
            $this->target->addOrder($condition[0], $condition[1]);
        }

        $actual = $this->target->sort(true);
        self::assertThat($actual, self::equalTo($expected));
    }

    public function testSort_順序の制約が無い項目がある場合_可能な範囲で昇順()
    {
        $conditions = [
            [0, 1],
            [1, 3],
            [2, 4],
            [2, 3],
            [4, 5],
        ];
        foreach ($conditions as $condition) {
            $this->target->addOrder($condition[0], $condition[1]);
        }
        $this->target->addItem(11);
        $this->target->addItem(10);
        $expected = [
            0, 1, 2, 3, 4, 5, 10, 11
        ];

        $actual = $this->target->sort(false);
        self::assertThat($actual, self::equalTo($expected));
    }

    public function testSort_順序の制約が無い項目がある場合_可能な範囲で降順()
    {
        $conditions = [
            [0, 1],
            [1, 3],
            [2, 4],
            [2, 3],
            [4, 5],
        ];
        foreach ($conditions as $condition) {
            $this->target->addOrder($condition[0], $condition[1]);
        }
        $this->target->addItem(11);
        $this->target->addItem(10);
        $expected = [
            11, 10, 2, 4, 5, 0, 1, 3
        ];

        $actual = $this->target->sort(true);
        self::assertThat($actual, self::equalTo($expected));
    }

    public function testSort_項目が文字列_可能な範囲で昇順()
    {
        $conditions = [
            ["abc0", "abc1"],
            ["abc1", "abc3"],
            ["abc2", "abc4"],
            ["abc2", "abc3"],
            ["abc4", "abc5"],
        ];
        foreach ($conditions as $condition) {
            $this->target->addOrder($condition[0], $condition[1]);
        }
        $expected = [
            "abc0", "abc1", "abc2", "abc3", "abc4", "abc5"
        ];

        $actual = $this->target->sort(false);
        self::assertThat($actual, self::equalTo($expected));
    }

    public function testSort_項目が文字列_可能な範囲で降順()
    {
        $conditions = [
            ["abc0", "abc1"],
            ["abc1", "abc3"],
            ["abc2", "abc4"],
            ["abc2", "abc3"],
            ["abc4", "abc5"],
        ];
        foreach ($conditions as $condition) {
            $this->target->addOrder($condition[0], $condition[1]);
        }
        $expected = [
            "abc2", "abc4", "abc5", "abc0", "abc1", "abc3"
        ];

        $actual = $this->target->sort(true);
        self::assertThat($actual, self::equalTo($expected));
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
        $actual = $this->target->sort(false);
        self::assertThat($actual, self::isNull());
        $actual = $this->target->sort(true);
        self::assertThat($actual, self::isNull());
    }
}
