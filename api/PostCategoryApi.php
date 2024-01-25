<?php

use contacts\api\BaseApi;
use contacts\models\PostCategory;
use WP_REST_Request;
use WP_REST_Response;

include_once __DIR__."/BaseApi.php";
include_once dirname(__DIR__)."/models/PostCategory.php";

class PostCategoryApi extends BaseApi {
    public function onRest(WP_REST_Request $data)
    {
        $json_payload = json_decode($data->body, true);
        if(!(array_key_exists("name") && array_key_exists("slug"))){
            return new WP_REST_Response(array("error" => "Required parameters are missing!"), 400);
        }
        $category_to_create = new PostCategory(0, $json_payload["name"], $json_payload["slug"]);
        $category_to_create = $this->db->create_category($category_to_create);
        return new WP_REST_Response(array("result" => json_encode($category_to_create)), (!$category_to_create) ? 500 : 201);
    }
}