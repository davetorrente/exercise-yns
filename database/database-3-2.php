<?php
require "Database.php";
$database = new Database();

$sqlUser = "CREATE TABLE users (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
username VARCHAR(30) NOT NULL,
email VARCHAR(30) NOT NULL,
description VARCHAR(255),
phone int(11) NOT NULL,
country VARCHAR(30) NOT NULL,
created DATETIME NULL,
gender  enum('male','female') DEFAULT NULL
)";

$sqlPost = "CREATE TABLE posts (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
post VARCHAR(255) NOT NULL,
created DATETIME NULL,
modified DATETIME NULL
)";

$database->query($sqlUser);
$database->execute();
echo "SUCCESS CREATING users table" . "<br/>";
$database->query($sqlPost);
$database->execute();
echo "SUCCESS CREATING posts table";