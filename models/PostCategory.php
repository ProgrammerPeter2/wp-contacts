<?php
namespace contacts\models;

require_once __DIR__."/Post.php";
require_once __DIR__."/ContactGroup.php";

class PostCategory{
    public readonly int $id;
    public readonly string $name;
    public readonly string $slug;

    public function __construct(int $id, string $name, string $slug){
        $this->id = $id;
        $this->name = $name;
        $this->slug = $slug;
    }

    public function renderToHTML($db, $header = false){
        $result = '<div class="post_category">';
        if($header) $result .= "<h3>$this->name</h3>";
        $posts = $db->get_posts_by_category($db);
        foreach ($posts as $post) {
            $contacts = ContactGroup::from_array($db->getContactByPost($post));
            $result .= $contacts->renderHTML();
        }
        return $result."</div>";
    }

    public static function from_object(\stdClass $item): PostCategory {
        return new PostCategory(intval($item->id), $item->name, $item->slug);
    }
}