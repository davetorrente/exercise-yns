<?php
require "Database.php";
$database = new Database();
date_default_timezone_set("Asia/Manila");
$datetime = date('Y-m-d H:i:s');
session_start();
if (isset($_SESSION['microUser'])) {
    $userAuth = $_SESSION['microUser'];
    $database->query("SELECT id FROM users WHERE username = '$userAuth'");
    $user = $database->resultset();
}

$message['isFollow'] = false;
$follow_id = htmlspecialchars($_POST['follow_id']);
$user_id = $user[0]['id'];
$database->query("SELECT id, isFollow FROM follows WHERE follow_id='$follow_id' AND user_id='$user_id'");
$findParentTweet = $database->resultset();
if(!empty($findParentTweet))
{
    $isFollow = $findParentTweet[0]['isFollow'] ? false : true;
    $database->query("UPDATE follows SET isFollow = :isFollow WHERE follow_id='$follow_id' AND user_id='$user_id'");
    $database->bind(':isFollow',$isFollow);
    $database->execute();
    $message['isFollow'] = $isFollow;
}else{
    $database->query("INSERT INTO follows (user_id, follow_id, isFollow, created) VALUES(:user_id, :follow_id, :isFollow, :created)");
    $database->bind(':user_id',$user_id);
    $database->bind(':follow_id', $follow_id);
    $database->bind(':isFollow', true);
    $database->bind(':created',$datetime);
    $database->execute();
    $message['isFollow'] = true;
}

echo json_encode($message);
