<?php

$servername = getenv('DB_HOST');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');
$port = getenv('DB_PORT');
$dbname = getenv('DB_NAME');

$conn = mysqli_connect($servername, $username, $password, null, $port);

if (!$conn) die("Connection failed: " . mysqli_connect_error());

$query = "CREATE DATABASE IF NOT EXISTS " . getenv('DB_NAME');
