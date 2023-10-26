<?php

namespace contacts\models;

class Post
{
    public readonly int $id;
    public readonly string $name;
    public readonly int $sort;
    public readonly bool $isKod;

    /**
     * @param int $id
     * @param string $name
     * @param int $sort
     * @param bool $isKod
     */
    public function __construct(int $id, string $name, int $sort, bool $isKod)
    {
        $this->id = $id;
        $this->name = $name;
        $this->sort = $sort;
        $this->isKod = $isKod;
    }

    public static function fromObj($stdClass): Post{
        return new Post($stdClass->id, $stdClass->name, $stdClass->sort, $stdClass->iskodpost == 1);
    }
}