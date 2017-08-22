<?php
require "Database.php";
$database = new Database();
date_default_timezone_set("Asia/Manila");
$datetime = date('Y-m-d H:i:s');
session_start();
$message['success'] = false;
if(isset($_POST['id']))
{
    $delete_id = $_POST['id'];
    $database->query('DELETE FROM tweets WHERE id = :id');
    $database->bind(':id',$delete_id);
    $database->execute();
    $message['success'] = true;
}
echo json_encode($message);