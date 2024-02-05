<?php
namespace contacts\api;

use contacts\models\PostCategory;
use WP_REST_Request;
use WP_REST_Response;

include_once __DIR__."/BaseApi.php";
include_once dirname(__DIR__)."/models/PostCategory.php";

class PostCategoryCreateApi extends BaseApi {
    public function onRest(WP_REST_Request $data)
    {
        $json_payload = json_decode($data->get_body(), true);
        if(!(array_key_exists("name", $json_payload) && array_key_exists("slug", $json_payload))){
            return new WP_REST_Response(array("error" => "Required parameters are missing!"), 400);
        }
        $category_to_create = new PostCategory(0, $json_payload["name"], $json_payload["slug"]);
        if(!$this->db->check_category($category_to_create)) return new WP_REST_Response(array("error" => "The category already exists!"), 409);
        $category_to_create = $this->db->create_category($category_to_create);
        return new WP_REST_Response(array("result" => $category_to_create), (!$category_to_create) ? 500 : 201);
    }
}