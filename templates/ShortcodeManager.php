<?php
namespace contacts\templates;
use contacts\templates\shortcodes\BaseShortcode;
use contacts\templates\shortcodes\ContactShortcode;
use contacts\templates\shortcodes\KodShortcode;

require_once __DIR__.'/shortcodes/BaseShortcode.php';
require_once __DIR__.'/shortcodes/ContactShortcode.php';
require_once __DIR__.'/shortcodes/KodShortcode.php';

class ShortcodeManager {
	private BaseShortcode $example;
	private ContactShortcode $contact;
	private KodShortcode $kod;

	public function __construct() {
		$this->example = new BaseShortcode('pelda');
		$this->contact = new ContactShortcode('kapcsolat');
		$this->kod = new KodShortcode('kod');
	}

	public function registerAllShortcodes(): void
    {
		$this->example->registerShortcode();
		$this->contact->registerShortcode();
		$this->kod->registerShortcode();
	}
}