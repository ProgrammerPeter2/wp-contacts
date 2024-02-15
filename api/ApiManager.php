<?php
namespace contacts\api;

use WP_REST_Server;

require_once __DIR__.'/BaseApi.php';
require_once __DIR__.'/EditContactsApi.php';
require_once __DIR__.'/PostCategoryCreateApi.php';
require_once __DIR__.'/PostCategoryFetchApi.php';
require_once __DIR__.'/PostCreateApi.php';
require_once dirname(__DIR__, 4).'/wp-includes/rest-api/class-wp-rest-server.php';

class ApiManager {
	private BaseApi $example;
	private EditContactsApi $edit_contacts;
	private PostCategoryCreateApi $post_category_create;
	private PostCategoryFetchApi $post_category_fetch;
	private PostCreateApi $post_create;

	public function __construct(string $namespace) {
		$this->example = new BaseApi($namespace, "test", "get");
		$this->edit_contacts = new EditContactsApi($namespace, "edit", WP_REST_Server::CREATABLE);
		$this->post_category_create = new PostCategoryCreateApi($namespace, "posts/category/create", WP_REST_Server::CREATABLE);
		$this->post_category_fetch = new PostCategoryFetchApi($namespace, "posts", "GET");
		$this->post_create = new PostCreateApi($namespace, "posts/create", "PUT");
	}

	public function registerAllEndpoints(): void
    {
		$this->example->registerEndpoint();
		$this->edit_contacts->registerEndpoint();
		$this->post_category_create->registerEndpoint();
		$this->post_category_fetch->registerEndpoint();
		$this->post_create->registerEndpoint();
	}
}