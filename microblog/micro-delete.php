<?php
require "Database.php";
$database = new Database();
date_default_timezone_set("Asia/Manila");
$datetime = date('Y-m-d H:i:s');
session_start();
$message['success'] = false;
if(isset($_POST['type']))
{
    $typeDelete = $_POST['type'];
    $delete_id = (int)$_POST['id'];
    if($typeDelete == 'tweet-delete')
    {
        $database->query('DELETE FROM tweets WHERE id = :id');
        $database->bind(':id',$delete_id);
        $database->execute();
        $message['success'] = true;
        echo json_encode(array("message"=>$message));
    }
    else if($typeDelete == 'retweet-delete')
    {
        $database->query("SELECT tweets.id, tweets.user_id FROM tweets INNER JOIN retweets ON tweets.id = retweets.tweet_id WHERE retweets.id ='$delete_id'");
        $tweetParent = $database->resultset();
        $tweetParentID = $tweetParent[0]['id'];
        $database->query("UPDATE tweets SET isRetweet = false WHERE id='$tweetParentID'");
        $database->execute();

        $database->query('DELETE FROM retweets WHERE id = :id');
        $database->bind(':id',$delete_id);
        $database->execute();
        $message['success'] = true;
        echo json_encode(array("message"=>$message, "tweetParent"=> $tweetParent));
    }
}

