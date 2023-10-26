<?php
namespace contacts\api;

use WP_REST_Server;

require_once __DIR__.'/BaseApi.php';
require_once __DIR__.'/EditContactsApi.php';
require_once dirname(__DIR__, 4).'/wp-includes/rest-api/class-wp-rest-server.php';

class ApiManager {
	private BaseApi $example;
	private EditContactsApi $edit_contacts;

	public function __construct(string $namespace) {
		$this->example = new BaseApi($namespace, "test", "get");
		$this->edit_contacts = new EditContactsApi($namespace, "edit", WP_REST_Server::CREATABLE);
	}

	public function registerAllEndpoints(): void
    {
		$this->example->registerEndpoint();
		$this->edit_contacts->registerEndpoint();
	}
}