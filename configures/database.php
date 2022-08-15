<?php


$DB_HOST = 'localhost';
$DB_USER = 'Christian';
$DB_PASS = '042901cjay';
$DB_MAIN = 'product_database';

try {
    $conn = new PDO("mysql:host=$DB_HOST;dbname=$DB_MAIN", $DB_USER, $DB_PASS);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
} catch (PDOException $ex) {
    echo 'Something went wrong...';
}





//check for connection
