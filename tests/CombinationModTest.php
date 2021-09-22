<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../snippets/CombinationMod.php";

class CombinationModTest extends TestCase
{
    const MOD = 10 ** 9 + 7;

    public function providedTestData(): array
    {
        return [
            [1, 1, 1],
            [10000000, 1, 10000000],
            [10000000, 0, 1],
            [10000000, 10000000, 1],
            [5854063, 3733188, 67633959],
            [1629556, 139510, 938865139],
            [3379103, 129300, 506324554],
            [8300894, 6386364, 818563519],
            [6329523, 2639590, 873909625],
            [10000000, 5854063, 189271826],
            [10000000, 5604251, 83639284],
            [10000000, 1539521, 246064192],
            [10000000, 3379103, 260011693],
            [10000000, 6057079, 54131527],
            [10000000, 6329523, 631095629],
        ];
    }

    public function testNCk()
    {
        $com = new CombinationMod(self::MOD, 10000000);
        foreach ($this->providedTestData() as $providedTestDatum) {
            [$n, $k, $expected] = $providedTestDatum;
            self::assertThat($com->nCk($n, $k), self::equalTo($expected));
        }
    }
}
