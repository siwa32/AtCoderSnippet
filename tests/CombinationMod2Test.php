<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../snippets/CombinationMod.php";

class CombinationMod2Test extends TestCase
{
    const MOD = 10 ** 9 + 7;

    public function providedTestData(): array
    {
        return [
            [1, 1, 1],
            [1000000000, 0, 1],
            [100000000, 100, 501016086],
            [1000000000, 1000, 624274358],
            [746384163, 41268, 251861790],
            [1000000000, 1, 1000000000],
            [1000000000, 10000, 514182778],
            [999999999, 50000, 429939171],
        ];
    }

    public function testNCk()
    {
        $com = new CombinationMod2(self::MOD, 100000);
        foreach ($this->providedTestData() as $providedTestDatum) {
            [$n, $k, $expected] = $providedTestDatum;
            self::assertThat($com->nCk($n, $k), self::equalTo($expected));
        }
    }
}
