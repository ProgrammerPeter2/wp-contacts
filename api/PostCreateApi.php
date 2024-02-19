<?php
namespace contacts\api;

use contacts\models\Post;
use WP_REST_Request;
use WP_REST_Response;

include_once __DIR__."/BaseApi.php";
include_once dirname(__DIR__)."/models/Post.php";

class PostCreateApi extends BaseApi {
    public function onRest(WP_REST_Request $data)
    {
        $json_payload = json_decode($data->get_body(), true);
        if(!(array_key_exists("name", $json_payload) && array_key_exists("category", $json_payload) && array_key_exists("slug", $json_payload))){
            return new WP_REST_Response(array("error" => "Required parameters are missing!"), 400);
        }
        $category = $this->db->get_category_by_slug($json_payload["category"]);
        if(!$category) return new WP_REST_Response(array("error" => "Category doesn't exists!"), 400);
        $post_to_create = new Post(0, $json_payload["name"], $category->id, $json_payload["slug"]);
        if(!$this->db->check_post_exists($post_to_create)) return new WP_REST_Response(array("error" => "The post already exists!"), 409);
        $post_to_create = $this->db->create_post($post_to_create);
        return new WP_REST_Response(array("result" => $post_to_create), (!$post_to_create) ? 500 : 201);
    }
}