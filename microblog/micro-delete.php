<?php
require "Database.php";
$database = new Database();
date_default_timezone_set("Asia/Manila");
$datetime = date('Y-m-d H:i:s');
session_start();
$message['success'] = false;
if(isset($_POST['id']))
{
    $delete_id = (int)$_POST['id'];
    $database->query("SELECT E.id, E.user_id FROM tweets E INNER JOIN tweets B on B.parent_tweet = E.id WHERE B.id='$delete_id'");
    $findParentTweet = $database->resultset();
    if(!empty($findParentTweet))
    {
        $tweetID = $findParentTweet[0]['id'];
        $userID = $findParentTweet[0]['user_id'];
        $database->query("UPDATE tweets SET isRetweet = false WHERE id='$tweetID' AND user_id='$userID'");
        $database->execute();
    }
    $database->query('DELETE FROM tweets WHERE id = :id');
    $database->bind(':id',$delete_id);
    $database->execute();
    $message['success'] = true;
}
echo json_encode(array("message"=>$message, "parentTweet"=>$findParentTweet));