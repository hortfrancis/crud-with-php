<?php 

// Set database credentials 
$server = 'localhost';
$username = 'root';
$password = 'pw123';
$database_name = 'phpcrud';

try {

    $database_connection = new PDO("mysql:host=$server;dbname=$database_name", $username, $password);

} catch (PDOException $e) {

    echo 'Connection to database failed: ' . $e->getMessage();
    exit;
}