<?php
require_once __DIR__."/class_mysqldb.php";

if(!defined("ABSPATH")){
    die("Access denied!");
}

if(!defined("INSTALL")){
    die("Access denied!");
}

$db = new mysqldb();

function create_table(string $table, array $fields){
    global $db;
    $full_table = $db->get_table_name($table);
    $sql = "create table if not exists $full_table (" + implode(", ", $fields) + ") collate=utf8mb3_hungarian_ci";
    echo $sql;
}

create_table("posts", array(
    "id int(255) auto_increment primary key", 
    "name varchar(255) null",
    "sort int(10) not null"
));