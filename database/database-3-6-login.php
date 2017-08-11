<?php
session_start();
if(isset($_POST['login'])) {
    $error = 0;
    if(empty($_POST["username"])) {
        $usernameError = "Name is required";
        $error++;
    }
    else {
        if(!ctype_alnum($_POST["username"]))
        {
            $userError = "Name must be alphanumeric characters";
            $error++;
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
        $_SESSION['user'] = $_POST["username"];
        header("Location: html_php-1-12.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Login Page</title>

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
<div class="login">
    <h1>Login</h1>

    <form method="post" id="loginForm">
        <input type="text" id="username" name="username" placeholder="Username"/>
        <span style="color:red"><?php echo isset($usernameError) ? $usernameError : ''; ?></span>
        <input type="password" id="password" name="password" placeholder="Password"/>
        <span style="color:red"><?php echo isset($passwordError) ? $passwordError : ''; ?></span>
        <button class="btn btn-primary btn-block btn-large" id="login" name="login">Let me in.</button>
    </form>
    <div class="form-group">
        <a href="/database/database-3-6-register.php"><h4>Register?</h4></a>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>