<?php
namespace contacts\api;

use contacts\models\PostCategory;
use WP_REST_Request;
use WP_REST_Response;

include_once __DIR__."/BaseApi.php";
include_once dirname(__DIR__)."/models/Post.php";

class PostFetchApi extends BaseApi {
    public function onRest(WP_REST_Request $data)
    {
        $post_result = $this->db->getAllPost();
        return new WP_REST_Response(array("result" => $post_result), ($post_result) ? 200 : 500);
    }
}