<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../snippets/LongestCommonSubsequence.php";

class LongestCommonSubsequenceTest extends TestCase
{
    private LongestCommonSubsequence $target;

    function setUp(): void
    {
        parent::setUp();

        $this->target = new LongestCommonSubsequence();
    }

    function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * @covers LongestCommonSubsequence::size
     */
    public function testSize()
    {
        $this->target->lcs("axyb", "abyxb");
        self::assertThat($this->target->size(), self::equalTo(3));

        $this->target->lcs("abracadabra", "avadakedavra");
        self::assertThat($this->target->size(), self::equalTo(7));
    }

    /**
     * @covers LongestCommonSubsequence::size
     */
    public function testSize_部分一致無しの場合()
    {
        $this->target->lcs("asdf", "zxcv");
        self::assertThat($this->target->size(), self::equalTo(0));
    }

    /**
     * @covers LongestCommonSubsequence::restore
     */
    public function testRestore()
    {
        $this->target->lcs("abracadabra", "avadakedavra");
        self::assertThat($this->target->restore(), self::equalTo("aaadara"));
    }

    /**
     * @covers LongestCommonSubsequence::restore
     */
    public function testRestore_復元が複数あり()
    {
        $this->target->lcs("axyb", "abyxb");
        self::assertThat(in_array($this->target->restore(), ["axb", "ayb"]), self::isTrue(), "いずれか");
    }

    /**
     * @covers LongestCommonSubsequence::restore
     */
    public function testRestore_部分一致無しの場合()
    {
        $this->target->lcs("asdf", "zxcv");
        self::assertThat($this->target->restore(), self::isEmpty());
    }

    /**
     * @covers LongestCommonSubsequence::lcs
     */
    public function testLcs()
    {
        self::assertThat($this->target->lcs("axyb", "abyxb"), self::equalTo(3));
        self::assertThat($this->target->lcs("abracadabra", "avadakedavra"), self::equalTo(7));
    }

    /**
     * @covers LongestCommonSubsequence::lcs
     */
    public function testLcs_部分一致無しの場合()
    {
        self::assertThat($this->target->lcs("asdf", "zxcv"), self::equalTo(0));
    }

    /**
     * @covers LongestCommonSubsequence::restoreAll
     */
    public function testRestoreAll()
    {
        $this->target->lcs("abracadabra", "avadakedavra");
        self::assertThat($this->target->restoreAll(), self::equalTo(["aaadara"]));
    }

    /**
     * @covers LongestCommonSubsequence::restoreAll
     */
    public function testRestoreAll_複数の復元あり()
    {
        $this->target->lcs("axyb", "abyxb");
        $res = $this->target->restoreAll();
        sort($res);
        self::assertThat($res, self::equalTo(["axb", "ayb"]));
    }

    /**
     * @covers LongestCommonSubsequence::restoreAll
     */
    public function testRestoreAll_部分一致無しの場合()
    {
        $this->target->lcs("asdf", "zxcv");
        self::assertThat($this->target->restoreAll(), self::equalTo([]));
    }
}
