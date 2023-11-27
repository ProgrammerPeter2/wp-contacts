<?php

namespace contacts\models;

class Post
{
    public readonly int $id;
    public readonly string $name;
    public readonly int $category_id;

    /**
     * @param int $id
     * @param string $name
     * @param int $category_id
     */
    public function __construct(int $id, string $name, int $category_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->category_id = $category_id;
    }

    public static function fromObj($stdClass): Post{
        return new Post($stdClass->id, $stdClass->name, $stdClass->category);
    }
}