<?php
namespace contacts\templates\shortcodes;

use contacts\models\Contact;

require_once dirname(__FILE__).'/BaseShortcode.php';

class KodShortcode extends BaseShortcode {
	public function renderShortcode( $atts, $content, $tag ): string {
		return Contact::renderKod();
	}

}