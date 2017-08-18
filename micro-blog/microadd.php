<?php
require "Database.php";
$database = new Database();
date_default_timezone_set("Asia/Manila");
$datetime = date('Y-m-d H:i:s');
session_start();
$error = '';
$message['success'] = false;
$user_id = htmlspecialchars($_POST['user_id']);
$tweet  = htmlspecialchars($_POST['tweet']);
$database->query("INSERT INTO tweets (tweet, user_id, created) VALUES(:tweet, :user_id, :created)");
$database->bind(':tweet',$tweet);
$database->bind(':user_id',$user_id);
$database->bind(':created',$datetime);
$database->execute();
if(!empty($database->lastInsertId())){
    $message['success'] = true;
}
echo json_encode($message);