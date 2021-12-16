<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../snippets/permutation.php";

class PermutationTest extends TestCase
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
     * @covers ::next_permutation
     */
    function testNextPermutation()
    {
        $expected = [
            0 => [1,2,3],
            1 => [1,3,2],
            2 => [2,1,3],
            3 => [2,3,1],
            4 => [3,1,2],
            5 => [3,2,1],
        ];
        $actual = [];
        foreach (next_permutation([1,2,3]) as $i => $perm) {
            $actual[] = $perm;
        }
        self::assertThat($actual, self::equalTo($expected));

        $expected = [
            0 => [1],
        ];
        $actual = [];
        foreach (next_permutation([1]) as $i => $perm) {
            $actual[] = $perm;
        }
        self::assertThat($actual, self::equalTo($expected));

        $actual = [];
        foreach (next_permutation([]) as $i => $perm) {
            $actual[] = $perm;
        }
        self::assertThat($actual, self::equalTo([]));
    }

    /**
     * @covers ::next_permutation
     */
    function testNextPermutation_重複要素あり()
    {
        $expected = [
            0 => [1,1,3],
            1 => [1,3,1],
            2 => [3,1,1],
        ];
        $actual = [];
        foreach (next_permutation([1,1,3]) as $i => $perm) {
            $actual[] = $perm;
        }
        self::assertThat($actual, self::equalTo($expected));

        $expected = [
            0 => [1, 1],
        ];
        $actual = [];
        foreach (next_permutation([1, 1]) as $i => $perm) {
            $actual[] = $perm;
        }
        self::assertThat($actual, self::equalTo($expected));
    }

    /**
     * @covers ::permutations
     */
    function testPermutations()
    {
        $expected = [
            0 => [1,2,3],
            1 => [1,3,2],
            2 => [2,1,3],
            3 => [2,3,1],
            4 => [3,1,2],
            5 => [3,2,1],
        ];
        self::assertThat(permutations([1,2,3]), self::equalTo($expected));

        $expected = [
            0 => [1],
        ];
        self::assertThat(permutations([1]), self::equalTo($expected));

        self::assertThat(permutations([]), self::equalTo([]));
    }

    /**
     * @covers ::permutations
     */
    function testPermutations_重複要素あり()
    {
        $expected = [
            0 => [1,1,3],
            1 => [1,3,1],
            2 => [3,1,1],
        ];
        self::assertThat(permutations([1,1,3]), self::equalTo($expected));

        $expected = [
            0 => [1, 1, 1],
        ];
        self::assertThat(permutations([1, 1, 1]), self::equalTo($expected));
    }
}
