<?php
$DB_TYPE = 'mysql'; //Type of database<br>
$DB_HOST = 'localhost'; //Host name<br>
$DB_USER = 'root'; //Host Username<br>
$DB_PASS = ''; //Host Password<br>
$DB_NAME = 'shop_db'; //Database name<br><br>

$conn = new PDO("$DB_TYPE:host=$DB_HOST; dbname=$DB_NAME;", $DB_USER, $DB_PASS); // PDO Connection

?>