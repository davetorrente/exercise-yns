<?php
require "Database.php";
$database = new Database();
date_default_timezone_set("Asia/Manila");
$datetime = date('Y-m-d H:i:s');
session_start();
$message['isRetweet'] = false;
$tweetId = htmlspecialchars($_POST['tweet_id']);
$userId = htmlspecialchars($_POST['user_id']);
$retweet = htmlspecialchars($_POST['retweet']);
$database->query("SELECT count('retweet') as totalRetweet FROM retweets WHERE tweet_id='$tweetId'");
$findTweet = $database->resultset();
if($findTweet[0]['totalRetweet'] > 0)
{
    $database->query("SELECT isRetweet FROM retweets WHERE tweet_id='$tweetId' AND user_id='$userId'");
    $selectIsRetweet = $database->resultset();
    //check the value of isRetweet
    $isRetweet = $selectIsRetweet[0]['isRetweet'] ? false : true;
    $database->query("UPDATE retweets SET isRetweet = :isRetweet WHERE tweet_id='$tweetId' AND user_id='$userId'");
    $database->bind(':isRetweet',$isRetweet);
    $database->execute();
    $message['isRetweet'] = $isRetweet;
    echo json_encode($message);

}else{
    $database->query("INSERT INTO retweets (tweet_id, user_id, retweet, isRetweet, created) VALUES(:tweet_id, :user_id, :retweet, :isRetweet, :created)");
    $database->bind(':tweet_id',$tweetId);
    $database->bind(':user_id',$userId);
    $database->bind(':retweet',$retweet);
    $database->bind(':isRetweet',true);
    $database->bind(':created',$datetime);
    $database->execute();
    if(!empty($database->lastInsertId())){
        $message['isRetweet'] = true;
        echo json_encode($message);
    }
}
