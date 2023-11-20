<?php
namespace contacts\models;

require_once __DIR__."/Post.php";
require_once __DIR__."/ContactGroup.php";

class PostCategory{
    public readonly int $id;
    public readonly string $name;
    private array $post_ids;

    public function __construct(int $id, string $name, array $posts){
        $this->id = $id;
        $this->name = $name;
        $this->post_ids = $posts;
    }

    /**
     * @returns []PostCategory
     */
    public function getPosts($db): array{
        $posts = array();
        foreach($this->post_ids as $post_id){
            if(!($post = $db->getPostById($post_id))) continue;
            $posts[] = $post;
        }
        return $posts;
    }

    public function renderToHTML($db, $header = false){
        $result = '<div class="post_category">';
        if($header) $result .= "<h3>$this->name</h3>";
        $posts = $this->get_posts($db);
        foreach ($posts as $post) {
            $contacts = ContactGroup::from_array($db->getContactByPost($post));
            $result .= $contacts->renderHTML();
        }
        return $result."</div>";
    }

    public static function from_object(\stdClass $item): PostCategory {
        $post_ids = array();
        foreach (explode(";", $item->post_ids) as $post_id){
            $post_ids[] = intval($post_id);
        }
        return new PostCategory(intval($item->id), $item->name, $post_ids);
    }
}