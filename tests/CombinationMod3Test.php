<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../snippets/CombinationMod.php";

class CombinationMod3Test extends TestCase
{
    const MOD = 10 ** 9 + 7;

    public function providedTestData(): array
    {
        // n = 1000000000
        return [
            [0, 1],
            [2345, 105117609],
            [12, 18564],
            [788, 318692535],
            [1, 1000000000],
            [49999, 11230794],
            [50000, 373807861],
        ];
    }

    public function testNCk()
    {
        $com = new CombinationMod3(1000000000, self::MOD, 100000);
        foreach ($this->providedTestData() as $providedTestDatum) {
            [$k, $expected] = $providedTestDatum;
            self::assertThat($com->nCk($k), self::equalTo($expected));
        }
    }
}
