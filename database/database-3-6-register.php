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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Register Page</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<body>
<div class="register">
    <h1>Register</h1>
    <div class="alert alert-success" style="display: none;">
    </div>
    <form method="post" id="registerForm" enctype="multipart/form-data">
        <div class="form-group" id="userDiv">
            <input  type="text" id="username" name="username" placeholder="Username"/>
        </div>
        <div class="form-group">
            <input  type="text" id="email" name="email" placeholder="Email"/>
        </div>
        <div class="form-group">
            <input  type="password" id="password" name="password" placeholder="Password"/>
        </div>
        <div class="form-group">
            <input  type="password" id="password2" name="password2" placeholder="Confirm Password"/>
        </div>
        <div class="form-group">
            <input type="file" name="upload" id="upload">
        </div>
        <button class="btn btn-primary btn-block btn-large" id="register" name="register">Submit</button>
    </form>
    <br/>
    <div class="form-group">
        <a href="/database/database-3-6-login.php"><h4>Login?</h4></a>
    </div>

</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script
        src="http://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
        crossorigin="anonymous"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/additional-methods.min.js"></script>
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>