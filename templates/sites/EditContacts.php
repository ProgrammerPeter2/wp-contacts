<?php


use contacts\api\EditContactsApi;
use contacts\mysqldb;

require_once dirname(__DIR__, 2).'/api/EditContactsApi.php';
require_once dirname(__FILE__, 3).'/class_mysqldb.php';
require_once dirname(__FILE__, 3).'/models/Contact.php';

$db = new mysqldb();
?>
<!DOCTYPE html>
<html>
    <head>
        <style>
            .contactform{
                margin-right: 20px;
            }
            .contactform h4{
                margin-bottom: -20px;
            }
            .hiddenButton{
                background: inherit;
                border-width: 0;
            }
        </style>
    </head>
	<body>
		<h1>Elérhetőségek módosítása</h1>
        <iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>
		<form id="contactform" method="post" action="<?=EditContactsApi::getUrl()?>" target="dummyframe">
            <?php
            $all_contacts = $db->getAllContacts();
            for($i = count($all_contacts) -1 ; $i > -1; $i--){
                if($i == 0) echo "<h2 style='margin-top: 60px'>Köd csoportvezetők</h2>";
                echo "<div style=\"display: flex;\">";
                foreach ( $all_contacts[$i] as $contacts ) {
                    echo $contacts->renderForm();
                }
                echo "</div>";
            }
            ?>
            <button class="button-primary" type="submit" >Módosítás</button>
        </form>
	</body>
</html>
