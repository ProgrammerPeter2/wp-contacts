<?php
namespace contacts;
require_once __DIR__."/class_mysqldb.php";

if(!defined("ABSPATH")){
    die("Access denied!");
}

if(!defined("INSTALL")){
    die("Access denied!");
}

$db = new mysqldb();

function create_table(mysqldb $db, string $table, array $fields){
    $full_table = $db->get_table_name($table);
    $sql = "create table if not exists $full_table (" . implode(", ", $fields) . ") collate=utf8mb3_hungarian_ci";
    return $db->executeSQL($sql) != false;
}

create_table($db, "posts", array(
    "id int(255) auto_increment primary key", 
    "name varchar(255) null",
    "sort int(10) not null"
));

create_table($db, "holders", array(
    "id int(255) auto_increment",
    "post int(255) not null",
    "holder int(255) not null",
    "class varchar(255) not null",
    "email varchar(255) null"
));