<?php
namespace contacts\templates\shortcodes;

use contacts\models\Contact;
use contacts\mysqldb;

require_once __DIR__.'/BaseShortcode.php';
require_once dirname(__FILE__, 3).'/class_mysqldb.php';

class ContactShortcode extends BaseShortcode {
	public function renderShortcode( $atts, $content, $tag ): string {
		if(!is_array($atts)) return "<p style=\"color: red\">Hiba! Nem adtál meg tulajdonságokat!</p>";
		$db = new mysqldb();
        $contacts = $db->getContactByPost($db->getPostByName($atts["post"]));
		if(!array_key_exists("email", $atts)) {
            return $this->renderContacts($contacts, $atts[0] != "noTitle");
        }
		else {
            return $this->renderContacts($contacts, $atts[0] != "noTitle", $atts["email"]);
        }
	}

    private function renderContacts(array $contacts, bool $showTitle, string $emailText = null): string{
        $resp = "<div class='contact'>";
        if($showTitle) $resp = "<h4>".$contacts[0]->post->name."</h4>";
        $resp .= '<div style="display: flex">';
        foreach ($contacts as $rawContact) {
            $contact = Contact::toContact($rawContact);
            $resp.= (!empty($emailText)) ? $contact->renderToHTML(true, true, $emailText) : $contact->renderToHTML(true);
        }
        $resp .= "</div>";
        return $resp;
    }
}