<?php
namespace contacts\api;
use contacts\mysqldb;
use WP_REST_Request;

require_once dirname(__FILE__, 2).'/class_mysqldb.php';
require_once dirname(__DIR__, 4).'/wp-includes/rest-api/class-wp-rest-request.php';
class BaseApi {
	private string $namespace;
	private string $route;
	private string $method;
	protected mysqldb $db;

	/**
	 * @param string $namespace
	 * @param string $route
	 */
	public function __construct( string $namespace, string $route, string $method) {
		$this->namespace     = $namespace;
		$this->route         = $route;
		$this->method = $method;
		$this->db = new mysqldb();
	}

	public function onRest(WP_REST_Request $data)
    {
		return "Simple Response!";
	}

	public function registerEndpoint(): void
    {
		$args = array(
			"methods" => $this->method,
			"callback" => array($this, 'onRest')
		);
		register_rest_route($this->namespace, $this->route, $args);
	}

}