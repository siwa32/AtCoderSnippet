<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../snippets/UnionFind.php";

class UnionFindTest extends TestCase
{
    private UnionFind $target;

    function setUp(): void
    {
        parent::setUp();

        $this->target = new UnionFind();
    }

    function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @covers UnionFind::unite
     */
    public function testUnite()
    {
        $this->target->unite(1,2);
        $this->target->unite(3,4);
        self::assertThat($this->target->isSame(1, 2), self::isTrue());
        self::assertThat($this->target->isSame(3, 4), self::isTrue());
        self::assertThat($this->target->isSame(2, 4), self::isFalse());

        $this->target->unite(2,4);
        self::assertThat($this->target->isSame(2, 4), self::isTrue());
        self::assertThat($this->target->isSame(2, 3), self::isTrue());
        self::assertThat($this->target->isSame(1, 3), self::isTrue());
        self::assertThat($this->target->isSame(1, 4), self::isTrue());
    }

    /**
     * @covers UnionFind::isSame
     */
    public function testIsSame()
    {
        self::assertThat($this->target->isSame(1, 2), self::isFalse());

        $this->target->unite(1,2);
        self::assertThat($this->target->isSame(1, 2), self::isTrue());
    }

    /**
     * @covers UnionFind::size
     */
    public function testSize()
    {
        self::assertThat($this->target->size(1), self::equalTo(1));
        self::assertThat($this->target->size(2), self::equalTo(1));

        $this->target->unite(1,2);
        self::assertThat($this->target->size(1), self::equalTo(2));
        self::assertThat($this->target->size(2), self::equalTo(2));
    }

    /**
     * @covers UnionFind::clear
     */
    public function testClear()
    {
        $this->target->unite(1,2);
        self::assertThat($this->target->isSame(1, 2), self::isTrue());

        $this->target->clear();
        self::assertThat($this->target->isSame(1, 2), self::isFalse());
        self::assertThat($this->target->size(1), self::equalTo(1));
        self::assertThat($this->target->size(2), self::equalTo(1));
        self::assertThat($this->target->root(1), self::equalTo(1));
        self::assertThat($this->target->root(2), self::equalTo(2));
    }

    /**
     * @covers UnionFind::root
     */
    public function testRoot()
    {
        self::assertThat($this->target->root(1), self::equalTo(1));
        self::assertThat($this->target->root(2), self::equalTo(2));

        $this->target->unite(1,2);
        $actual = $this->target->root(1);
        self::assertTrue(in_array($actual, [1, 2]));
        self::assertThat($this->target->root(2), self::equalTo($this->target->root(1)));
    }
}
