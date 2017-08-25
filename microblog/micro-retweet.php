<?php
require "Database.php";
$database = new Database();
date_default_timezone_set("Asia/Manila");
$datetime = date('Y-m-d H:i:s');
session_start();
if (isset($_SESSION['microUser'])) {
    $userAuth = $_SESSION['microUser'];
    $database->query("SELECT * FROM users WHERE username = '$userAuth'");
    $user = $database->resultset();
}
$message['isRetweet'] = false;
$tweetId = htmlspecialchars($_POST['tweet_id']);
$userId = htmlspecialchars($_POST['user_id']);

$userAuth = $_SESSION['microUser'];
$database->query("SELECT username FROM users WHERE id = '$userId'");
$userThatTweet = $database->resultset();

if(($_POST['type']=='forRetweet'))
{
    $tweet = $_POST['tweet'];
    $isRetweet = true;
    $database->query("UPDATE tweets SET isRetweet = :isRetweet WHERE id='$tweetId' AND user_id='$userId'");
    $database->bind(':isRetweet',$isRetweet);
    $database->execute();
    $database->query("INSERT INTO retweets (retweet, user_id, tweet_id, created) VALUES(:retweet, :user_id, :tweet_id, :created)");
    $database->bind(':retweet',$tweet);
    $database->bind(':user_id',$user[0]['id']);
    $database->bind(':tweet_id', $tweetId);
    $database->bind(':created',$datetime);
    $database->execute();
    if(!empty($database->lastInsertId())){
        $database->query('SELECT users.username, users.upload, retweets.id, retweets.retweet, retweets.created FROM users INNER JOIN retweets ON users.id = retweets.user_id WHERE retweets.id = :id' );
        $database->bind(':id', $database->lastInsertId());
        $lastTweet = $database->resultset();
        $message['isRetweet'] = true;
        echo json_encode(array('message' => $message, 'query'=>$lastTweet, 'userTweet' => $userThatTweet));
    }
}

if(($_POST['type']=='forDelete'))
{
    $sessionUserID = $user[0]['id'];
    $database->query("SELECT isRetweet FROM tweets WHERE id='$tweetId' AND user_id='$userId'");
    $findTweet = $database->resultset();
    if($findTweet[0]['isRetweet'])
    {
        $isRetweet = false;
        $database->query("UPDATE tweets SET isRetweet = :isRetweet WHERE id='$tweetId' AND user_id='$userId'");
        $database->bind(':isRetweet',$isRetweet);
        $database->execute();
        $database->query("SELECT id FROM retweets WHERE user_id = '$sessionUserID' AND tweet_id = '$tweetId'");
        $findRetweet = $database->resultset();
        $database->query('DELETE FROM retweets WHERE user_id = :user_id AND tweet_id = :tweetId');
        $database->bind(':user_id',$sessionUserID);
        $database->bind(':tweetId',$tweetId);
        $database->execute();
        $message['success'] = true;
        echo json_encode(array('message'=>$message, 'userID' => $sessionUserID, 'findTweet' => $findRetweet));
    }

}


