<?php
require "Database.php";
$database = new Database();
if(isset($_POST['register'])) {
    $error = 0;
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);
    $cpassword = htmlspecialchars($_POST["cpassword"]);
    $email = htmlspecialchars($_POST["email"]);


    if(empty($username)) {
        $usernameError = "Username is required";
        $error++;
    }else {
        if(!ctype_alnum($username))
        {
            $usernameError = "Username must be alphanumeric characters";
            $error++;
        }else{

            if(strlen($username) < '6' || strlen($username) > '10') {
                $usernameError = "Your Username Must Contain At Least 6 to 10 Characters!";
                $error++;
            }else{
                $database->query("SELECT username FROM users WHERE username = '$username'");
                $usernameExist = $database->resultset();
                if(!empty($usernameExist)){
                    $usernameError = "Username already exist";
                    $error++;
                }
            }
        }
    }
    if (empty($email)) {
        $emailError = "Email is required";
        $error++;
    }else {
        $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
        if (!preg_match($regex, $email)) {
            $emailError = "Email is invalid";
            $error++;
        }else{
            $database->query("SELECT email FROM users WHERE email = '$email'");
            $emailExist = $database->resultset();
            if(!empty($emailExist)){
                $emailError = "Email already exist";
                $error++;
            }
        }
    }
    if(empty($password)){
        $passwordError = "Password is required";
        $error++;
    }else{
        if (strlen($password) < '8') {
            $passwordError = "Your Password Must Contain At Least 8 Characters!";
            $error++;
        }
        elseif(!preg_match("#[0-9]+#",$password)) {
            $passwordError = "Your Password Must Contain At Least 1 Number!";
            $error++;

        }
        elseif(!preg_match("#[A-Z]+#",$password)) {
            $passwordError = "Your Password Must Contain At Least 1 Capital Letter!";
            $error++;
        }
        elseif(!preg_match("#[a-z]+#",$password)) {
            $passwordError = "Your Password Must Contain At Least 1 Lowercase Letter!";
            $error++;
        }
    }
    if(empty($cpassword))
    {
        $confirmError = "Confirm Password is required";
        $error++;
    }else{
        if($cpassword != $password){
            $confirmError = "Confirm Password must match your password";
            $error++;
        }
    }

    if(isset($_POST['gender']))
    {
        $gender = htmlspecialchars($_POST['gender']);
    }
    if (empty($gender)) {
        $genderError = "Gender is required";
        $error++;
    }else{
        if($gender == 'Male')
        {
            $male = $gender;
        }
        else{
            $female = $gender;
        }
    }
    if($error == 0)
    {
        $hashpassword = md5($password);
        $database->query("INSERT INTO users (username, password, email, gender) VALUES('$username', '$hashpassword', '$email', '$gender')");
        $database->execute();
        session_destroy();
        unset($_POST);
        header("Location: quiz-register.php?success=register");
        die();
    }
    if(isset($_GET['success'])){
        $message = "<div id='hideMe' align='center' class='alert-success'>You may now login</div>";
    }
}
if(!empty($_SESSION['microUser']))
    header("Location: quiz.php");

if(isset($_GET['success']) && $error == 0)
{
    $message = "<div id='hideMe' align='center' class='alert-success'>You may now login</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz Register</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="css/style.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="container-fluid">
        <div class="row">
           <div class="logo text-center">
            <a href="quiz-register.php"><h1>Practice</h1></a>
            </div>
            <div class="headText text-center col-sm-6">
                <h1>PHP QUIZ</h1>
                <p>Take a quiz to challenge yourself. The exam consists of 10 questions with multiple choices. </p>
                <p>You need to login to take the exam</p>
            </div>
            <div id="polina" class="col-sm-6">
                <?php echo isset($message) ? $message : ''; ?>
                <h4 class="text-center">Register as a New Quizzer</h4>
                <form class="form-horizontal" method="post" enctype="multipart/form-data" novalidate>

                    <div class="form-group has-success has-feedback">
                        <div class="col-sm-12">
                            <input type="text" id="username" name="username" class="form-control"  value="<?php echo isset($username) ? $username : ''; ?>" <?php echo !empty($usernameError) ? "autofocus": '' ;?> placeholder="Username">
                            <span style="color:red"><?php echo isset($usernameError) ? $usernameError : ''; ?></span>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group has-success has-feedback">
                        <div class="col-sm-12">
                            <input type="email" id="email" name="email" class="form-control"  value="<?php echo isset($email) ? $email : ''; ?>" <?php echo !empty($emailError) ? "autofocus": '' ;?> placeholder="Email">
                            <span style="color:red"><?php echo isset($emailError) ? $emailError : ''; ?></span>
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group has-success has-feedback">
                        <div class="col-sm-12">
                            <input type="password" id="password" name="password" class="form-control"  value="<?php echo isset($password) ? $password : ''; ?>" <?php echo !empty($passwordError) ? "autofocus": '' ;?> placeholder="Password">
                            <span style="color:red"><?php echo isset($passwordError) ? $passwordError : ''; ?></span>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group has-success has-feedback">
                        <div class="col-sm-12">
                            <input type="password" id="cpassword" name="cpassword" class="form-control"  value="<?php echo isset($cpassword) ? $cpassword : ''; ?>" <?php echo !empty($confirmError) ? "autofocus": '' ;?> placeholder="Confirm Password">
                            <span style="color:red"><?php echo isset($confirmError) ? $confirmError : ''; ?></span>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-1">Gender</label>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-4 cold-sm-offset-1">
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" value="Male" id="gender" <?php echo isset($male) ? 'checked' : '';?>>Male
                                    </label>
                                </div>
                                <div class="col-sm-4 cold-sm-offset-1">
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" value="Female" id="gender" <?php echo isset($female) ? 'checked' : '';?>>Female
                                    </label>
                                </div>
                            </div>
                            <span style="color:red; display: block;"><?php echo isset($genderError) ? $genderError : ''; ?></span>
                        </div>
                    </div> <!-- /.form-group -->

                    <div class="text-center">
                        <button type="submit" class="btn btn-success" name="register">Submit</button>
                    </div>
                </form>
                <br>
                <div class="text-right">
                    <p>Already Registered?<a href="quiz-login.php"> Login Here </a></p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>