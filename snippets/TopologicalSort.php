<?php

/**
 * トポロジカルソート
 */
class TopologicalSort
{
    /** @var array<int|string, int[]|string[]> */
    private array $orderCondition;

    /** @var array<int|string, int> */
    private array $beforeCount;

    /** @var int[]|string[] */
    private array $items;

    public function clear(): void
    {
        $this->items = [];
        $this->beforeCount = [];
        $this->orderCondition = [];
    }

    /**
     * 前後関係の制約を追加する
     *
     * @param int|string $before
     * @param int|string $after
     */
    public function addOrder($before, $after): void
    {
        assert($before !== $after);

        $this->orderCondition[$before][] = $after;
        $this->beforeCount[$after] ??= 0;
        ++$this->beforeCount[$after];

        $this->items[$before] = $before;
        $this->items[$after] = $after;
    }

    /**
     * 前後関係に制約の無い要素を追加する
     *
     * @param int|string $item
     */
    public function addItem($item): void
    {
        $this->items[$item] = $item;
    }

    /**
     * ソート
     * 
     * @return array|null 制約条件でソートできない場合はnullを返す
     */
    public function sort(): ?array
    {
        $ret = [];

        $queue = new SplQueue();
        foreach ($this->items as $item) {
            if (($this->beforeCount[$item] ?? 0) === 0) {
                // 前にしなければならない要素が無い
                $queue->enqueue($item);
            }
        }
        while (!$queue->isEmpty()) {
            $item = $queue->dequeue();
            $ret[] = $item;
            foreach ($this->orderCondition[$item] ?? [] as $after) {
                --$this->beforeCount[$after];
                if ($this->beforeCount[$after] === 0) {
                    $queue->enqueue($after);
                }
            }
        }

        return count($ret) === count($this->items) ? $ret : null;
    }
}
