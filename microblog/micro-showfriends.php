<?php
session_start();
require_once "Database.php";
$database = new Database();

$database->query("SELECT users.username FROM follows INNER JOIN users ON follows.follow_id = users.id WHERE user_id='$getUserID' AND isFollow=true GROUP BY users.username ");
$followUsers = $database->resultset();
