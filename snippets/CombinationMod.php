<?php

/**
 * nCk
 * nが大きい（10**7程度）
 */
class CombinationMod
{
    private int $mod;
    private int $naxN;
    private array $fact;
    private array $factInv;
    private array $inv;

    public function __construct(int $mod, int $maxN)
    {
        $this->mod = $mod;
        $this->maxN = $maxN;

        $this->fact[0] = 1;
        $this->fact[1] = 1;
        $this->factInv[0] = 1;
        $this->factInv[1] = 1;
        $this->inv[0] = 0;
        $this->inv[1] = 1;
        for ($i = 2; $i <= $maxN; ++$i) {
            $this->fact[$i] = $i * $this->fact[$i - 1] % $mod;
            $this->inv[$i] = $mod - $this->inv[$mod % $i] * intdiv($mod, $i) % $mod;
            $this->factInv[$i] = $this->factInv[$i - 1] * $this->inv[$i] % $mod;
        }
    }

    public function nCk(int $n, int $k): int
    {
        assert($n <= $this->maxN);
        assert(0 <= $k && $k <= $n);

        return $this->fact[$n] * ($this->factInv[$k] * $this->factInv[$n - $k] % $this->mod) % $this->mod;
    }
}

/**
 * nCk
 * nが非常に大きい（10**9程度）
 * kは小さい（10**5程度）
 */
class CombinationMod2
{
    private int $mod;
    private int $maxK;
    private array $factInv;
    private array $inv;

    public function __construct(int $mod, int $maxK)
    {
        $this->mod = $mod;
        $this->maxK = $maxK;

        $this->factInv[0] = 1;
        $this->factInv[1] = 1;
        $this->inv[0] = 0;
        $this->inv[1] = 1;
        for ($i = 2; $i <= $maxK; ++$i) {
            $this->inv[$i] = $mod - $this->inv[$mod % $i] * intdiv($mod, $i) % $mod;
            $this->factInv[$i] = $this->factInv[$i - 1] * $this->inv[$i] % $mod;
        }
    }

    public function nCk(int $n, int $k): int
    {
        assert($k <= $n);
        assert(0 <= $k && $k <= $this->maxK);

        $ret = 1;
        for ($i = $n; $i >= $n - $k + 1; --$i) {
            $ret *= $i;
            $ret %= $this->mod;
        }
        return $ret * $this->factInv[$k] % $this->mod;
    }
}

/**
 * nCk
 * nが固定で非常に大きい（10**9程度）
 * kは小さい（10**5程度）
 */
class CombinationMod3
{
    private int $mod;
    private int $n;
    private int $maxK;

    private array $factInv;
    private array $inv;
    private array $com;

    public function __construct(int $n, int $mod, int $maxK)
    {
        $this->mod = $mod;
        $this->n = $n;
        $this->maxK = $maxK;

        $this->factInv[0] = 1;
        $this->factInv[1] = 1;
        $this->inv[0] = 0;
        $this->inv[1] = 1;
        for ($i = 2; $i <= $maxK; ++$i) {
            $this->inv[$i] = $mod - $this->inv[$mod % $i] * intdiv($mod, $i) % $mod;
            $this->factInv[$i] = $this->factInv[$i - 1] * $this->inv[$i] % $mod;
        }

        $this->com[0] = 1;
        for ($i = 1; $i <= $this->maxK; ++$i) {
            $this->com[$i] = $this->com[$i - 1] * (($n - $i + 1) * $this->inv[$i] % $mod) % $mod;
        }
    }

    public function nCk(int $k): int
    {
        assert($k <= $this->n);
        assert(0 <= $k && $k <= $this->maxK);

        return $this->com[$k];
    }
}
