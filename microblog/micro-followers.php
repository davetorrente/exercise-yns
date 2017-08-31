<?php
session_start();
require_once "Database.php";
$database = new Database();

$userid = $_POST['user_id'];

$database->query("SELECT users.username, users.upload FROM users INNER JOIN follows ON users.id = follows.user_id WHERE follows.follow_id='$userid' AND isFollow=true");
$userFollows = $database->resultset();
echo json_encode($userFollows);

