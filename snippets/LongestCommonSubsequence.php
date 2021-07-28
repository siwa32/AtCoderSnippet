<?php

/**
 * 最長共通部分列問題
 */
class LongestCommonSubsequence
{
    private bool $valid;

    private string $s;
    private string $t;

    /** @var int[]  */
    private array $dp;

    // 復元文字列
    private ?string $restored = null;

    /** @var string[]|null  */
    private ?array $restoredAll = null;

    public function __construct()
    {
        $this->valid = false;
    }

    public function lcs(string $s, string $t): int
    {
        $this->restored = null;
        $this->restoredAll = null;

        $slen = strlen($s);
        $tlen = strlen($t);

        $this->s = $s;
        $this->t = $t;
        $this->dp = [];
        $this->dp[0] = array_fill(0, $slen + 1, 0);
        for ($i = 1; $i <= $tlen; ++$i) {
            $this->dp[$i][0] = 0;
            $tch = $t[$i - 1];
            for ($j = 1; $j <= $slen; ++$j) {
                if ($tch === $s[$j - 1]) {
                    $this->dp[$i][$j] = $this->dp[$i - 1][$j - 1] + 1;
                } else {
                    $this->dp[$i][$j] = max($this->dp[$i - 1][$j], $this->dp[$i][$j - 1]);
                }
            }
        }

        $this->valid = true;

        return $this->size();
    }

    /**
     * 最長部分一致文字列のサイズ
     * @return int
     */
    public function size(): int
    {
        assert($this->valid);

        return $this->dp[strlen($this->t)][strlen($this->s)];
    }

    /**
     * 最長部分一致文字列を返す
     * 複数あり得る場合どの文字列になるかは不定
     * @return string
     */
    public function restore(): string
    {
        assert($this->valid);

        if ($this->restored !== null) {
            return $this->restored;// 復元済
        }

        $st = '';
        $j = strlen($this->s);
        $i = strlen($this->t);
        while ($i > 0 && $j > 0) {
            if ($this->dp[$i][$j] === $this->dp[$i - 1][$j]) {
                $i -= 1;
                continue;
            }
            if ($this->dp[$i][$j] === $this->dp[$i][$j - 1]) {
                $j -= 1;
                continue;
            }
            $st .= $this->t[$i - 1];
            $i -= 1;
            $j -= 1;
        }

        return $this->restored = strrev($st);
    }

    public function restoreAll(): array
    {
        assert($this->valid);

        if ($this->restoredAll !== null) {
            return $this->restoredAll;// 復元済
        }

        $this->restoredAll = [];

        // もっと効率の良い方法ある？

        $stack = new SplStack();
        $stack->push(['', strlen($this->t), strlen($this->s)]);
        while (!$stack->isEmpty()) {
            [$st, $i, $j] = $stack->pop();

            while ($i > 0 && $j > 0) {
                $backI = false;
                $backJ = false;
                if ($this->dp[$i][$j] === $this->dp[$i - 1][$j]) {
                    $backI = true;
                }
                if ($this->dp[$i][$j] === $this->dp[$i][$j - 1]) {
                    $backJ = true;
                }
                if ($backI) {
                    if ($backJ) {
//                        echo "push: {$st} {$i} {$j}" . PHP_EOL;
                        $stack->push([$st, $i, $j - 1]);
                    }
                    $i -= 1;
                    continue;
                }
                if ($backJ) {
                    $j -= 1;
                    continue;
                }
                $st .= $this->t[$i - 1];
                $i -= 1;
                $j -= 1;
            }
            if ($st !== '') {
                $this->restoredAll[] = strrev($st);
            }
        }

        if (!empty($this->restoredAll)) {
            $this->restoredAll = array_unique($this->restoredAll);
        }

        return $this->restoredAll;
    }
}

if (0) {
    $lcs = new LongestCommonSubsequence();
    $size = $lcs->lcs("abracadabra", "avadakedavra");
    echo "{$size}" . PHP_EOL;
    echo $lcs->size() . PHP_EOL;
    echo $lcs->restore() . PHP_EOL;
    var_dump($lcs->restoreAll());
}
