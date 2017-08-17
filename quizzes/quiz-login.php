<?php
require "Database.php";
$database = new Database();
session_start();
if (isset($_SESSION['quizUser'])){
    header("Location: quiz.php");
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
        $passwordlength = strlen($password);
        if($passwordlength < 6)
        {
            $passwordError = "Password must be at least 6 characters";
            $error++;
        }
    }
    if($error == 0)
    {
        $username = "";
        $password = "";
        $_SESSION['quizUser'] = $_POST["username"];
        header("Location: quiz.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz Login</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="css/login.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="container-fluid">
        <div class="row">
            <div class="logo text-center">
                <a href="quiz-register.php"><h1>Practice</h1></a>
            </div>

            <div id="polina" class="col-sm-6">
                <h4 class="text-center">Login as a New Quizzer</h4>
                <form class="form-horizontal" method="post" novalidate>
                    <div class="form-group has-success has-feedback">
                        <div class="col-sm-12">
                            <input type="text" id="username" name="username" class="form-control"  value="<?php echo isset($username) ? $username : ''; ?>" placeholder="Username" autofocus>
                            <span style="color:red"><?php echo isset($usernameError) ? $usernameError : ''; ?></span>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group has-success has-feedback">
                        <div class="col-sm-12">
                            <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                            <span style="color:red"><?php echo isset($passwordError) ? $passwordError : ''; ?></span>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" name="login" class="btn btn-success">Submit</button>
                    </div>
                </form>
                <br>
                <div class="text-right">
                    <p>Not Yet Registered?<a href="quiz-register.php"> Register Here </a></p>
                </div>
            </div>
        </div>

    </div>
</div>
</body>
</html>