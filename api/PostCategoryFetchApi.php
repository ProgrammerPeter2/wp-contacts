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
        $category_result = array("categories" => $this->db->getAllCategories());
        return new WP_REST_Response($category_result, ($category_result["categories"]) ? 200 : 500);
    }
}