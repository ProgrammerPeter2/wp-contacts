<?php
require_once __DIR__."/class_mysqldb.php";

if(!defined("ABSPATH")){
    die("Access denied!");
}

if(!defined("INSTALL")){
    die("Access denied!");
}

$db = new mysqldb();

function exec_table_creation(string $table, array $fields){
    $full_table = $db->get_table_name($table);
    $sql = "create table if not exists $full_table (" + implode(", ", $fields) + ") collate=utf8mb3_hungarian_ci;
}