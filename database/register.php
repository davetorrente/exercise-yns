<?php

require "Database.php";
$database = new Database();
$postform = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

if($postform)
{
    $username = $postform['username'];
    $email = $postform['email'];

//    $database->query("SELECT * FROM users WHERE username = '$username'");
//    $findUser = $database->resultset();
//    if(!empty($findUser))
//    {
//        echo json_encode(array("userError" => true));
//    }
//    $database->query("SELECT * FROM users WHERE username = '$email'");
//    $findEmail = $database->resultset();
//    if(!empty($findUser))
//    {
////        echo json_encode(array("emailError" => true));
//    }
    $password = $postform['password'];
    $password   = password_hash( $password, PASSWORD_BCRYPT, array('cost' => 11));
    $file = $_FILES['upload'];
    $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
    $ext = substr(strtolower(strrchr($file['name'], '.')), 1);
    if(in_array($ext, $arr_ext))
    {
        move_uploaded_file($file['tmp_name'], $_SERVER["DOCUMENT_ROOT"]. '/database/profile-img/' .$file['name']);
    }
    $database->query('INSERT INTO users (username, email, password, upload) VALUES(:username, :email, :password, :upload)');
    $database->bind(':username',$username);
    $database->bind(':email',$email);
    $database->bind(':password',$password);
    $database->bind(':upload',$file['name']);
    $database->execute();
    echo json_encode(array("success" => true));

}
