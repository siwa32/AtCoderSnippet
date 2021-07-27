<?php

/**
 * 素数判定
 * エラストネテスの篩い
 */
class PrimeChecker
{
    private int $limit;
    private array $sieve;
    private array $primes;

    /**
     * @param int $limit 素数を求めておく最大値
     */
    public function __construct(int $limit)
    {
        assert($limit > 0);
        $this->limit = $limit;
        $this->makeInit();
    }

    private function makeInit(): void
    {
        $this->primes = ($this->limit >= 2) ? [2] : [];
        $this->sieve = [];
        for ($n = 3; $n <= $this->limit; $n += 2) {
            if (!isset($this->sieve[$n])) {
                $this->sieve[$n] = $n;
                $this->primes[] = $n;
                for ($j = $n * $n; $j <= $this->limit; $j += $n) {
                    if (($j & 0b01) !== 0 && !isset($this->sieve[$j])) {
                        $this->sieve[$j] = $n;// 最小素因数(奇数のみ記録)
                    }
                }
            }
        }
    }

    /**
     * 素数判定
     * @param int $n 自然数
     * @return bool
     */
    public function isPrime(int $n): bool
    {
        assert($n <= $this->limit);

        if ($n === 2) {
            return true;
        }
        if ($n <= 1 || ($n & 0b01) === 0) {
            return false;
        }

        return ($n === ($this->sieve[$n] ?? null));
    }

    /**
     * 指定した値の素因数分解
     * @param int $n 2以上の自然数
     * @return array [素数 => 乗数, 素数 => 乗数, ...]
     */
    public function primeFactor(int $n): array
    {
        assert($n <= $this->limit);

        $ret = [];
        while ($n !== 1) {
            $f = $this->sieve[$n] ?? 2;
            $ret[$f] = ($ret[$f] ?? 0) + 1;
            $n /= $f;
        }
        return $ret;
    }

    /**
     * 素数リスト
     * @return array
     */
    public function primes(): array
    {
        return $this->primes;
    }
}
