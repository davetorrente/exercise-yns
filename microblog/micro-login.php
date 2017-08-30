<?php
session_start();
require "Database.php";
$database = new Database();

if (!empty($_SESSION['microUser'])){
    header("Location: micro-blog.php");
    exit;
}
if(isset($_POST['login'])) {
    $error = 0;
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST['password']) ;
    $usernameExist = '';
    $passwordExist = '';
    if(empty($_POST["username"])) {
        $usernameError = "Username is required";
        $error++;
    }else {
            $database->query("SELECT username FROM users WHERE username = '$username'");
            $usernameExist = $database->resultset();
            if(empty($usernameExist)){
                $usernameError = "Username not exist";
                $error++;
            }
        
    }
    if(empty($_POST["password"])) {
        $passwordError = "Password is required";
        $error++;
    }else{
            $database->query("SELECT password FROM users WHERE username = '$username'");
            $passwordExist = $database->resultset();
            if(!empty($passwordExist)){
                $passwordDB = $passwordExist[0]['password'];
                if(base64_encode($password) != $passwordDB)
                {
                     $passwordError = "Password is incorrect";
                     $error++;
                }
            }
    }   
    if($error == 0)
    {
        $username = "";
        $password = "";
        $_SESSION['microUser'] = $_POST["username"];
        header("Location: micro-blog.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Microblog Login</title>

    <!-- CSS -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/form-elements.css">
    <link rel="stylesheet" href="assets/css/register.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="assets/ico/favicon.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

</head>

<body>

<!-- Top content -->
<div class="top-content">
    <div class="inner-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 form-box">
                    <div class="form-top">
                        <div class="form-top-left">
                            <h3>Login to Microblog</h3>
                            <p>Fill up the information to log in:</p>
                        </div>
                        <div class="form-top-right">
                            <i class="fa fa-lock"></i>
                        </div>
                    </div>
                    <?php echo isset($message) ? $message : ''; ?>
                    <div class="form-bottom">
                        <form role="form" method="post" class="login-form">
                            <div class="form-group">
                                <label class="sr-only" for="username">Username</label>
                                <input type="text" id="username" name="username" class="form-control"  value="<?php echo isset($username) ? $username : ''; ?>" <?php echo !empty($usernameError) ? "autofocus": '' ;?> placeholder="Username..">
                                <span style="color:red"><?php echo isset($usernameError) ? $usernameError : ''; ?></span>
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="form-password">Password</label>
                                <input type="password" id="password" name="password" class="form-control"  value="<?php echo isset($password) ? $password : ''; ?>" <?php echo !empty($passwordError) ? "autofocus": '' ;?> placeholder="Password..">
                                <span style="color:red"><?php echo isset($passwordError) ? $passwordError : ''; ?></span>
                            </div>
                            <div class="text-right">
                                <p>Not Yet Registered?<a href="micro-register.php"> Register Here </a></p>
                            </div>
                            <button type="submit" name="login" class="btn">Sign in!</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<!-- Javascript -->
<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.backstretch.min.js"></script>
<script src="assets/js/scripts.js"></script>


</body>

</html>