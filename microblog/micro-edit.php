<?php
require "Database.php";
$database = new Database();
date_default_timezone_set("Asia/Manila");
$datetime = date('Y-m-d H:i:s');
session_start();
$message['success'] = false;
$editTweet = htmlspecialchars($_POST['status']);
$tweetID = (int)$_POST['id'];
$database->query('UPDATE tweets SET tweet = :tweet WHERE id = :id');
$database->bind(':tweet',$editTweet);
$database->bind(':id',$tweetID);
$database->execute();
$message['success'] = true;
$database->query("SELECT tweet, modified FROM tweets WHERE id='$tweetID'");
$editTweetSelect = $database->resultset();
$database->execute();
echo json_encode(array('message' => $message, 'tweet' => $editTweetSelect[0]['tweet'], 'date' =>$editTweetSelect[0]['modified'] ));