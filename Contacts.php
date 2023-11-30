<?php
/*
 * Plugin Name: DÖK Kapcsolatok
 * Description: Dinamikus kapcsolatok oldal
 * Author: Horváth Péter
 * Version: 1.0
 * */

use contacts\api\ApiManager;
use contacts\assets\AssetManager;
use contacts\templates\ShortcodeManager;
use contacts\templates\SiteManager;

if(!defined('ABSPATH')) exit;
require_once __DIR__.'/templates/ShortcodeManager.php';
require_once __DIR__.'/assets/AssetManager.php';
require_once __DIR__.'/api/ApiManager.php';
require_once __DIR__.'/templates/SiteManager.php';

class Contacts {
	public ShortcodeManager $shortcodes;
	public ApiManager $api;
	public SiteManager $sites;
	public AssetManager $assets;

	public function __construct() {
		//declare managers
		$this->shortcodes = new ShortcodeManager();
		$this->api = new ApiManager("contacts");
		$this->sites = new SiteManager();
		$this->assets = new AssetManager();
		//register actions
		add_action('init', array($this->shortcodes, 'registerAllShortcodes'));
		add_action('admin_init', array($this->assets, 'loadAdminAssets'));
		add_action('rest_api_init', array($this->api, 'registerAllEndpoints'));
		add_action('admin_menu', array($this->sites, 'registerSites'));
	}
}

function install(){
	define("INSTALL", true);
	require_once __DIR__."/Installer.php";
}

register_activation_hook(__FILE__,'install');

new Contacts;