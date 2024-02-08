<?php
namespace contacts\api;

use contacts\models\PostCategory;
use WP_REST_Request;
use WP_REST_Response;

include_once __DIR__."/BaseApi.php";
include_once dirname(__DIR__)."/models/PostCategory.php";

class PostCategoryFetchApi extends BaseApi {
    public function onRest(WP_REST_Request $data)
    {
        $include_posts = !empty($data->get_param("posts"));
        $post_result = ($include_posts) ? array("posts" => $this->db->getAllPost()) : array();
        $category_result = array("categories" => $this->db->getAllCategories());
        $result = ($include_posts) ? array_merge($post_result, $category_result) : $category_result;
        return new WP_REST_Response($result, (($include_posts) ? $post_result && $category_result : $category_result) ? 200 : 500);
    }
}