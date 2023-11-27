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
		<h1>Posztok</h1>
        <h3>Minden kapcsolat rendelkezik egy poszttal amit az adott kapcsolat mögötti ember betölt. Az alábbi oldalon ezt lehet kezelni!</h3>
        <iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>
		
	</body>
</html>
