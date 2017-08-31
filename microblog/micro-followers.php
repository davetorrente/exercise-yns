<?php
session_start();
require_once "Database.php";
$database = new Database();

$userid = $_POST['user_id'];

$database->query("SELECT users.username, users.upload, users.description FROM users INNER JOIN follows ON users.id = follows.follow_id WHERE user_id='$userid' AND isFollow=true");
$followUsers = $database->resultset();
echo json_encode($followUsers);
