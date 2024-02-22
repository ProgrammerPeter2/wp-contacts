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
        <button onclick="show_overlay('#create_category')">Create category</button>
        <button id="create_post_btn">Create Post</button>
		<div class="overlay-bg inactive-bg">
            <div class="overlay" id="create_category">
                <form id="post_category_form">
                    <div class="field">
                        <p>Név:<p>
                        <input id="pcf_name" type="text"/>
                    </div>
                    <div class="field">
                        <p>Azonosító:<p>
                        <input id="pcf_slug" type="text"/>
                    </div>
                    <button type="submit">Create it</button>
                </form>
            </div>
            <div class="overlay" id="create_post">
                <form id="post_create_form">
                    <div class="field">
                        <p>Név:<p>
                        <input id="post_name" type="text"/>
                    </div>
                    <div class="field">
                        <p>Kategória:<p>
                        <select id="post_category"></select>
                    </div>
                    <div class="field">
                        <p>Azonosító:<p>
                        <input id="post_slug" type="text"/>
                    </div>
                    <button type="submit">Create it</button>
                </form>
            </div>
        </div>
	</body>
</html>
