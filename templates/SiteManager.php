<?php
namespace contacts\templates;


class SiteManager {
	public function editContacts(): void
    {
		require_once __DIR__.'/sites/EditContacts.php';
	}

	public function registerSites(): void
    {
		add_menu_page("Elérhetőségek módosítása", "Elérhetőségek", "manage_options",
			"contacts", array($this, 'editContacts'), "dashicons-admin-users");
	}
}