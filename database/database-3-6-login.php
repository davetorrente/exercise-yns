<?php
require "Database.php";
$database = new Database();
session_start();
if (isset($_SESSION['authUser']))
    header("Location: database-3-6.php");
if(isset($_POST['login'])) {
    $error = 0;
    $username = $_POST["username"];
    $password = $_POST['password'];
    $usernameExist = '';
    $passwordExist = '';
    if(empty($_POST["username"])) {
        $usernameError = "Username is required";
        $error++;
    }
    else {
        if(!ctype_alnum($username))
        {
            $userError = "Username must be alphanumeric characters";
            $error++;
        }
        else{
            $database->query("SELECT username FROM users WHERE username = '$username'");
            $usernameExist = $database->resultset();
            if(empty($usernameExist)){
                $usernameError = "Username not exist";
                $error++;
            }
            else{
                $database->query("SELECT password FROM users WHERE username = '$username'");
                $passwordExist = $database->resultset();
                if($passwordExist[0]['password'] <> md5($password))
                {
                    $passwordError = "Password is incorrect";
                    $error++;
                }
            }
        }
    }
    if(empty($_POST["password"])) {
        $passwordError = "Password is required";
        $error++;
    }
    else {
        $password = $_POST["password"];
        $passwordlength= strlen($password);
        if($passwordlength= strlen($password) < 6)
        {
            $passwordError = "Password must be at least 6 characters";
            $error++;
        }
    }
    if($error == 0)
    {
        $username = "";
        $password = "";
        $_SESSION['authUser'] = $_POST["username"];
        header("Location: database-3-6.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>database login</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="css/register.css" rel="stylesheet">

</head>
<body>
<nav class="navbar navbar-default">
    <div class="container">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigatipon</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="">Database Implementation</a>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="database-3-6.php">Home</a></li>
                <li class="active"><a href="database-3-6-login.php">Login</a></li>
                <li><a href="database-3-6-register.php">Register</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <form method="post" id="registerForm" class="form-horizontal" role="form" enctype='multipart/form-data' novalidate>
        <h2>Login Form</h2>
        <div class="form-group">
            <label for="username" class="col-sm-3 control-label">User Name</label>
            <div class="col-sm-9">
                <input type="text" id="username" name="username" class="form-control"  value="<?php echo isset($username) ? $username : ''; ?>" autofocus>
                <span style="color:red"><?php echo isset($usernameError) ? $usernameError : ''; ?></span>
            </div>
        </div>
        <div class="form-group">
            <label for="username" class="col-sm-3 control-label">Password</label>
            <div class="col-sm-9">
                <input type="password" id="password" name="password" class="form-control">
                <span style="color:red"><?php echo isset($passwordError) ? $passwordError : ''; ?></span>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-9 col-sm-offset-3">
                <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
            </div>
        </div>
    </form> <!-- /form -->
</div> <!-- ./container -->
</body>
</html>