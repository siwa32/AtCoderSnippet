<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../snippets/AdjacencyListGraph.php";

class GraphEdgeTest extends TestCase
{
    public function testSortByCost()
    {
        $edges = [
            new GraphEdge(1, 2, 1),
            new GraphEdge(2, 3, 6),
            new GraphEdge(3, 4, 3),
            new GraphEdge(2, 5, 10),
            new GraphEdge(4, 5, 2),
        ];
        GraphEdge::sortByCost($edges);
        self::assertThat($edges[0]->cost, self::equalTo(1));
        self::assertThat($edges[0]->from, self::equalTo(1));
        self::assertThat($edges[0]->to, self::equalTo(2));

        self::assertThat($edges[1]->cost, self::equalTo(2));
        self::assertThat($edges[1]->from, self::equalTo(4));
        self::assertThat($edges[1]->to, self::equalTo(5));

        self::assertThat($edges[2]->cost, self::equalTo(3));
        self::assertThat($edges[2]->from, self::equalTo(3));
        self::assertThat($edges[2]->to, self::equalTo(4));

        self::assertThat($edges[3]->cost, self::equalTo(6));
        self::assertThat($edges[3]->from, self::equalTo(2));
        self::assertThat($edges[3]->to, self::equalTo(3));

        self::assertThat($edges[4]->cost, self::equalTo(10));
        self::assertThat($edges[4]->from, self::equalTo(2));
        self::assertThat($edges[4]->to, self::equalTo(5));
    }

    public function testSortByCost_降順()
    {
        $edges = [
            new GraphEdge(1, 2, 1),
            new GraphEdge(2, 3, 6),
            new GraphEdge(3, 4, 3),
            new GraphEdge(2, 5, 10),
            new GraphEdge(4, 5, 2),
        ];
        GraphEdge::sortByCost($edges, false);
        self::assertThat($edges[0]->cost, self::equalTo(10));
        self::assertThat($edges[0]->from, self::equalTo(2));
        self::assertThat($edges[0]->to, self::equalTo(5));

        self::assertThat($edges[1]->cost, self::equalTo(6));
        self::assertThat($edges[1]->from, self::equalTo(2));
        self::assertThat($edges[1]->to, self::equalTo(3));

        self::assertThat($edges[2]->cost, self::equalTo(3));
        self::assertThat($edges[2]->from, self::equalTo(3));
        self::assertThat($edges[2]->to, self::equalTo(4));

        self::assertThat($edges[3]->cost, self::equalTo(2));
        self::assertThat($edges[3]->from, self::equalTo(4));
        self::assertThat($edges[3]->to, self::equalTo(5));

        self::assertThat($edges[4]->cost, self::equalTo(1));
        self::assertThat($edges[4]->from, self::equalTo(1));
        self::assertThat($edges[4]->to, self::equalTo(2));
    }

    public function testSortByCost_キーを維持()
    {
        $edges = [
            'a' => new GraphEdge(1, 2, 1),
            'b' => new GraphEdge(2, 3, 6),
            'c' => new GraphEdge(3, 4, 3),
            'd' => new GraphEdge(2, 5, 10),
            'e' => new GraphEdge(4, 5, 2),
        ];
        GraphEdge::sortByCost($edges, true, true);
        self::assertThat($edges['a']->cost, self::equalTo(1));
        self::assertThat($edges['a']->from, self::equalTo(1));
        self::assertThat($edges['a']->to, self::equalTo(2));

        self::assertThat($edges['e']->cost, self::equalTo(2));
        self::assertThat($edges['e']->from, self::equalTo(4));
        self::assertThat($edges['e']->to, self::equalTo(5));

        self::assertThat($edges['c']->cost, self::equalTo(3));
        self::assertThat($edges['c']->from, self::equalTo(3));
        self::assertThat($edges['c']->to, self::equalTo(4));

        self::assertThat($edges['b']->cost, self::equalTo(6));
        self::assertThat($edges['b']->from, self::equalTo(2));
        self::assertThat($edges['b']->to, self::equalTo(3));

        self::assertThat($edges['d']->cost, self::equalTo(10));
        self::assertThat($edges['d']->from, self::equalTo(2));
        self::assertThat($edges['d']->to, self::equalTo(5));
    }

    public function testSortByCost_キーを維持しない()
    {
        $edges = [
            'a' => new GraphEdge(1, 2, 1),
            'b' => new GraphEdge(2, 3, 6),
            'c' => new GraphEdge(3, 4, 3),
        ];
        GraphEdge::sortByCost($edges, true, false);
        self::assertThat($edges[0]->cost, self::equalTo(1));
        self::assertThat($edges[1]->cost, self::equalTo(3));
        self::assertThat($edges[2]->cost, self::equalTo(6));
    }
}
