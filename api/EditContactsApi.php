<?php
namespace contacts\api;

use contacts\models\Contact;
use contacts\models\ContactPair;
use Exception;
use WP_REST_Request;
use WP_REST_Response;

require_once __DIR__.'/BaseApi.php';
require_once dirname(__FILE__, 2).'/models/Contact.php';
require_once dirname(__FILE__, 2).'/models/ContactPair.php';

class EditContactsApi extends BaseApi {
	public function onRest(WP_REST_Request $data)
    {
		$params = $data->get_params();
		$param_keys = array_keys($params);
		$contacts = $this->db->getEachContacts();
		$contactPairs = ContactPair::fromContactArray($contacts);
		for($i = 0; $i < count($params); $i+=3){
			foreach ( $contactPairs as $contact_pair ) {
				$dataset = array("id" => explode("-", $param_keys[$i])[0],
				                 "holder" => $params[$param_keys[$i]],
				                 "class" => $params[$param_keys[$i+1]],
				                 "email" => $params[$param_keys[$i+2]]);
				if($contact_pair->isCloneThisDataset($dataset)){
					if(!$contact_pair->isTheSame()) $this->db->editContactByPost($contact_pair->clone);
				}
			}
		}
		wp_redirect($data->get_header("Referer"));
	}

    public static function getUrl(): string
    {
        return get_site_url()."/wp-json/contacts/edit";
    }

}