<?php

$servername = 'localhost';
$username = 'barnabas';
$password = 'Pa55word';

$connection = new mysqli($servername, $username, $password);

if ($connection->connect_error){
    die("Error creating database: $connection->connect_error");
}

$sql = "CREATE DATABASE mCashTest";

if ($connection->query($sql) === TRUE) {
    echo "Database created successfully!";
} else {
    echo "Error creating database: $connection->error";
}

$connection->close();

?>