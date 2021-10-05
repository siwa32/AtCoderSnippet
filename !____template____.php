<?php
/**
 *
 */

if (PHP_OS !== 'Linux') {
    // ローカル実行時
    ini_set('memory_limit', '512M');
}

const DBGOUT = STDERR;

const SP = ' ';
const LF = "\n";
const YES = 'Yes';
const NO = 'No';
const MOD1000000007 = 10 ** 9 + 7;
const MOD = MOD1000000007;
// 配列を出力するときの区切り
const ANSWER_ARRAY_SEP = LF;// 改行区切り
//const ANSWER_ARRAY_SEP = SP;// 空白区切り

///////////////////////////////////////////////////////////////////
///

/**
 * 入力値
 */
class InputValue
{
    use StdInputTrait;

    public int $N;
    public int $K;
    public string $S;
    public $A;
    public $B;
    public $C, $D;
    public $AB, $CD;
    public int $H, $W;

    public static function get(): self
    {
        $input = new self();

        [$input->N] = self::inInt(1);
        [$input->N, $input->K] = self::inInt(2);
        [$input->H, $input->W] = self::inInt(2);
        $input->A = self::inInt($input->N);
        $input->AB = self::inIntMat($input->N, 2);
        [$input->S] = self::inStr(1);
//        pp($input);

        return $input;
    }
}

/**
 * 答えを求める
 */
function solve(InputValue $input)
{
    $ans = 0;

    return $ans;
}

//$start = microtime(true);
output(solve(InputValue::get()));
//p(microtime(true) - $start);

/**
 * 出力
 * @param int|float|bool|string|array $ans
 * @param bool $rawOutput 配列の場合に値をそのまま出力するか
 */
function output($ans, bool $rawOutput = false): void
{
    if (is_bool($ans)) {
        echo ($ans ? YES : NO) . LF;
        return;
    }
    if (is_array($ans)) {
        if (empty($ans)) {
            return;
        }
        $_fn = static function (array $ans) use ($rawOutput): void {
            if (!$rawOutput) {
                if (is_bool($ans[0])) {
                    $ans = array_map(static fn ($e) => $e ? YES : NO, $ans);
                }
                if (is_float($ans[0])) {
                    $ans = array_map(static fn ($e) => sprintf("%.12f", $e), $ans);
                }
            }
            echo implode(ANSWER_ARRAY_SEP, $ans) . LF;
        };
        if (is_array(current($ans))) {
            // 2次元配列の場合
            foreach ($ans as $item) {
                $_fn($item);
            }
        } else {
            $_fn($ans);
        }
        return;
    }
    if (is_float($ans)) {
        echo sprintf("%.12f", $ans) . LF;
        return;
    }

    echo $ans . LF;
}

//////////////////////////////////////////////////////////////////////////////////
///

trait StdInputTrait
{
    private static function in(string $format)
    {
        return fscanf(STDIN, $format);
    }

    private static function inInt(int $n = 1)
    {
        return fscanf(STDIN, str_repeat("%d", $n));
    }

    private static function inStr(int $n = 1)
    {
        return fscanf(STDIN, str_repeat("%s", $n));
    }

    private static function inFloat(int $n = 1)
    {
        return fscanf(STDIN, str_repeat("%f", $n));
    }

    private static function inIntMat(int $rows, int $cols): array
    {
        $res = [];
        for ($i = 0; $i < $rows; ++$i) {
            $res[] = self::inInt($cols);
        }
        return $res;
    }

    private static function inIntRow(int $rows): array
    {
        $res = [];
        for ($i = 0; $i < $rows; ++$i) {
            [$res[]] = self::inInt(1);
        }
        return $res;
    }
}

/**
 * デバッグ用出力
 * @param ...$values
 */
function p(...$values): void
{
    $o = '';
    $sep = '';
    foreach ($values as $value) {
        if (is_array($value)) {
            // キーは出力しない
            // 2次元配列まで
            if (is_array(current($value))) {
                $o .= (empty($sep) ? '' : PHP_EOL);
                foreach ($value as $item) {
                    $o .= '| ' . implode(',', $item) . ' |' . PHP_EOL;
                }
                $sep = '';
            } else {
                $o .= $sep . '[' . implode(',', $value) . ']';
                $sep = ', ';
            }
        } else {
            $o .= $sep . $value;
            $sep = ', ';
        }
    }
    $o .= (empty($sep) ? '' : PHP_EOL);
    fwrite(DBGOUT, $o);
}

/**
 * デバッグ用出力
 * @param ...$values
 */
function pp(...$values): void
{
    foreach ($values as $value) {
        $o = print_r($value, true);
        if (!is_array($value) && !is_object($value)) {
            $o .= PHP_EOL;
        }
        fwrite(DBGOUT, $o);
    }
}

/**
 * 値の入れ替え
 * @param &$a
 * @param &$b
 */
function swap(&$a, &$b): void
{
    $tmp = $a;
    $a = $b;
    $b = $tmp;
}

/**
 * 整数除算切り上げ
 * @param int $x
 * @param int $y
 * @return int
 */
function intdiv_ceil(int $x, int $y): int
{
    return intdiv($x + $y - 1, $y);
}

function change_max(&$a, $b): bool
{
    if ($a < $b) {
        $a = $b;
        return true;
    }
    return false;
}

function change_min(&$a, $b): bool
{
    if ($a > $b) {
        $a = $b;
        return true;
    }
    return false;
}
