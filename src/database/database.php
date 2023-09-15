<?php

$servername = getenv('DB_HOST');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');
$port = getenv('DB_PORT');
$dbname = getenv('DB_NAME');

$conn = mysqli_connect($servername, $username, $password, null, $port);
if (!$conn) die("Connection failed: " . mysqli_connect_error());

$dbname = getenv('DB_NAME');
$result = $conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
if ($result === false) die(mysqli_error($conn));
mysqli_close($conn);

$conn = mysqli_connect($servername, $username, $password, $dbname, $port);
$migrations = $files = scandir(__DIR__ . '/migrations');
foreach ($migrations as $migration) {
    if (!str_contains($migration, 'php')) continue;
    $query = require __DIR__ . "/migrations/$migration";
    if ($conn->query($query) === false) die(mysqli_error($conn));
}