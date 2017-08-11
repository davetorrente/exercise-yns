<?php
require "Database.php";
$database = new Database();
$postform = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if(isset($postform['username']) && isset($postform['password']))
{
    $username = $postform['username'];
    $password = $postform['password'];

}

echo json_encode($_POST);