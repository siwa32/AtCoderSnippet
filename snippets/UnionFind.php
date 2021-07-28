<?php

class UnionFind
{
    private $parent = [];
    private $size = [];

    public function __construct()
    {
    }

    public function clear(): void
    {
        $this->parent = [];
        $this->size = [];
    }

    /**
     * 根を取得する
     *
     * @param int $id
     * @return int
     */
    public function root(int $id): int
    {
        if (!isset($this->parent[$id]) || $this->parent[$id] === null) {
            return $id;
        }

        $this->parent[$id] = $this->root($this->parent[$id]);
        return $this->parent[$id];
    }

    /**
     * 同じ木に属しているか
     *
     * @param int $id1
     * @param int $id2
     * @return bool
     */
    public function isSame(int $id1, int $id2): bool
    {
        return $id1 === $id2 || $this->root($id1) === $this->root($id2);
    }

    /**
     * 統合する
     *
     * @param int $id1
     * @param int $id2
     */
    public function unite(int $id1, int $id2): void
    {
        $r1 = $this->root($id1);
        $r2 = $this->root($id2);
        if ($r1 === $r2) {
            return;// 同じ根の時はそのまま
        }
        $sz1 = $this->size[$r1] ?? 1;
        $sz2 = $this->size[$r2] ?? 1;
        // 大きい方の木に統合する
        if ($sz1 >= $sz2) {
            $this->parent[$r2] = $r1;
            $this->size[$r1] = $sz1 + $sz2;
        } else {
            $this->parent[$r1] = $r2;
            $this->size[$r2] = $sz1 + $sz2;
        }
    }

    /**
     * @param int $id
     * @return int
     */
    public function size(int $id): int
    {
        $r = $this->root($id);
        return $this->size[$r] ?? 1;
    }
}
