<?php

require "Database.php";
$database = new Database();
$postform = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

if($postform)
{
    $username = $_POST['username'];
    $email = $postform['email'];
    $password = $postform['password'];
    $password   = password_hash( $password, PASSWORD_BCRYPT, array('cost' => 11));
    $file = $_FILES['upload'];
   print_r($file);
//    $database->query('INSERT INTO users (username, email, password, upload) VALUES(:username, :email, :password, :upload)');
//    $database->bind(':username',$username);
//    $database->bind(':email',$email);
//    $database->bind(':password',$password);
//    $database->bind(':upload',$filenew);
//    $database->execute();
//    echo $username;
//    die();

//    if($database->lastInsertId())
//    {
//        echo json_encode(array('success' =>'SUCCESS!'));
//    }

}
