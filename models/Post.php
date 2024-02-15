<?php

namespace contacts\models;

class Post
{
    public readonly int $id;
    public readonly string $name;
    public readonly int $category_id;
    public readonly string $slug;

    /**
     * @param int $id
     * @param string $name
     * @param int $category_id
     */
    public function __construct(int $id, string $name, int $category_id, string $slug)
    {
        $this->id = $id;
        $this->name = $name;
        $this->category_id = $category_id;
        $this->slug = $slug;
    }

    public static function fromObj($stdClass): Post{
        return new Post($stdClass->id, $stdClass->name, $stdClass->category, $stdClass->slug);
    }
}