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
        <script>
            const API_ROOT = "<?=get_site_url()?>/wp-json/";
            const $ = jQuery;
            $(document).ready(() => {
                init_overlay("#create_category", "Create a Post Category");
                init_overlay("#create_post", "Create a new Post")

                $("#create_post_btn").on('click', () => {
                    $.ajax({
                        url: API_ROOT + "contacts/posts/category",
                        method: "get",
                        success: (data) => {
                            let options = "<option value=''>Kérlek válassz!</option>"
                            data.categories.forEach((category, _, __) => {
                                options += `<option value="${category.slug}">${category.name}</option>`
                            })
                            $("#post_category").html(options)
                            show_overlay('#create_post')
                        }
                    })
                })
                $("#post_name").on('change', () => {
                    $("#post_slug").val($("#post_name").val().toLowerCase().replace(' ', '-'))
                })
                $("#post_create_form").on('submit', (e) => {
                    e.preventDefault()
                    let name = $("#post_name").val()
                    let category = $("#post_category").val()
                    let slug = $("#post_slug").val()
                    if(category === '') {
                        alert("A kategória mező üres!")
                        return
                    }

                    $.ajax({
                        url: API_ROOT + "contacts/posts/create",
                        method: "put",
                        body: JSON.stringify({"name": name, "category": category, "slug": slug}),
                        processData: false,
                        headers: {"Content-Type": "application/json"},
                        error: error => alert(error),
                        success: data => {
                            hide_overlay("#create_post")
                            $("#post_name").val("")
                            $("#post_category").val("")
                            $("#post_slug").val("")
                            alert(`Post - ${data.name} - created successfully!`)
                        }
                    })
                })

                $("#post_category_form").on('submit', (e) => {
                    e.preventDefault()
                    let name = $("#pcf_name").val()
                    let slug = $("#pcf_slug").val()
                    $.ajax({
                        url: API_ROOT + "contacts/posts/category/create",
                        method: "post",
                        body: JSON.stringify({"name": name, "slug": slug}),
                        processData: false,
                        headers: {
                            "Content-Type": "application/json"
                        },
                        success: (data) => {
                            hide_overlay("#create_category")
                            $("#pcf_name").val("")
                            $("#pcf_slug").val("")
                            alert("Post Category " + data.result.name + " successfully created!")
                        },
                        error: error => console.log(error)
                    })
                })
                $("#pcf_name").on('change', () => {
                    $("#pcf_slug").val($("#pcf_name").val().toLowerCase().replace(' ', '-'))
                })
            })
        </script>
	</body>
</html>
