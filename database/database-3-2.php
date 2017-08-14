<?php
require "Database.php";
$database = new Database();

$sqlUser = "CREATE TABLE IF NOT ExISTS users (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
username VARCHAR(30) NOT NULL,
email VARCHAR(30) NOT NULL,
description VARCHAR(255),
phone int(11) NOT NULL,
country VARCHAR(30) NOT NULL,
created DATETIME DEFAULT CURRENT_TIMESTAMP,
gender  enum('male','female') DEFAULT NULL
)";

$sqlPost = "CREATE TABLE IF NOT ExISTS posts (
id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
post VARCHAR(255) NOT NULL,
created DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

$database->query($sqlUser);
$database->execute();
echo "SUCCESS CREATING users table" . "<br/>";
$database->query($sqlPost);
$database->execute();
echo "SUCCESS CREATING posts table";