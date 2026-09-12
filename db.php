<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "material_db";

$conn = mysqli_connect($host, $username, $password);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci")) {
    die("Database creation failed: " . mysqli_error($conn));
}

if (!mysqli_select_db($conn, $database)) {
    die("Database selection failed: " . mysqli_error($conn));
}

$createTable = "CREATE TABLE IF NOT EXISTS materials (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    subject_name VARCHAR(255) NOT NULL,
    semester TINYINT UNSIGNED NOT NULL,
    material_type VARCHAR(100) NOT NULL,
    uploaded_by VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (!mysqli_query($conn, $createTable)) {
    die("Table creation failed: " . mysqli_error($conn));
}

mysqli_set_charset($conn, "utf8mb4");

?>
