<?php
require "Database.php";
$database = new Database();

$error = 0;
if(isset($_POST['register'])) {
    $firstname = htmlspecialchars($_POST["firstname"]);
    $lastname = htmlspecialchars($_POST["lastname"]);
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);
    $email = htmlspecialchars($_POST["email"]);
    $cpassword = htmlspecialchars($_POST["cpassword"]);
    if(empty($firstname)){
        $firstnameError = "First Name is required";
        $error++;
    }else{
        if(!ctype_alpha($firstname))
        {
            $firstnameError = "Firstname must be alphabetic characters";
            $error++;
        }else{

            if(strlen($firstname) < '4' || strlen($firstname) > '15')  {
                $firstnameError = "Your First Name Must Contain At Least 4 to 15 Characters! ";
                $error++;
            }
        }
    }
    if(empty($lastname)){
        $lastnameError = "Last Name is required";
        $error++;
    }else{
        if(!ctype_alpha($lastname))
        {
            $lastnameError = "Last Name must be alphabetic characters";
            $error++;
        }else{

            if(strlen($lastname) < '4' || strlen($lastname) > '15')  {
                $lastnameError = "Your Last Name Must Contain At Least 4 to 15 Characters! ";
                $error++;
            }
        }
    }

    if(empty($username)) {
        $usernameError = "Username is required";
        $error++;
    }else {
        if(!ctype_alnum($username))
        {
            $usernameError = "Username must be alphanumeric characters";
            $error++;
        }else{

            if(strlen($username) < '4' || strlen($username) > '15') {
                $usernameError = "Your Username Must Contain At Least 4 to 15 Characters!";
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
        $defaultPicture = "./profile-img/default-user.png";
        $hashpassword = base64_encode($password);
        $database->query("INSERT INTO users (firstname, lastname, username, password, email, gender, upload) VALUES('$firstname', '$lastname', '$username', '$hashpassword', '$email', '$gender', '$defaultPicture')");
        $database->execute();
        session_destroy();
        unset($_POST);
        header("Location: micro-register.php?success=register");
        die();
    }
}
if(isset($_GET['success']) && $error == 0)
{
    $message = "<div id='hideMe' align='center' class='alert-success'>You may now login</div>";
}
if(!empty($_SESSION['microUser'])) {
    header("Location: micro-blog.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Microblog Register</title>

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
                            <h3>Register to Microblog</h3>
                            <p>Fill up the information to have an account:</p>
                        </div>
                        <div class="form-top-right">
                            <i class="fa fa-lock"></i>
                        </div>
                    </div>
                    <?php echo isset($message) ? $message : ''; ?>
                    <div class="form-bottom">
                        <form role="form" method="post" class="login-form">
                            <div class="row">
                                <div class="form-group col-xs-6">
                                    <label class="sr-only" for="firstname">First Name</label>
                                    <input type="text" id="firstname" name="firstname" class="form-control"  value="<?php echo isset($firstname) ? $firstname : ''; ?>" <?php echo !empty($firstnameError) ? "autofocus": '' ;?> placeholder="First Name..">
                                    <span style="color:red"><?php echo isset($firstnameError) ? $firstnameError : ''; ?></span>
                                </div>
                                <div class="form-group col-xs-6">
                                    <label class="sr-only" for="lastname">Last Name</label>
                                    <input type="text" id="lastname" name="lastname" class="form-control"  value="<?php echo isset($lastname) ? $lastname : ''; ?>" <?php echo !empty($lastnameError) ? "autofocus": '' ;?> placeholder="Last Name..">
                                    <span style="color:red"><?php echo isset($lastnameError) ? $lastnameError : ''; ?></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="sr-only" for="username">Username</label>
                                <input type="text" id="username" name="username" class="form-control"  value="<?php echo isset($username) ? $username : ''; ?>" <?php echo !empty($usernameError) ? "autofocus": '' ;?> placeholder="Username..">
                                <span style="color:red"><?php echo isset($usernameError) ? $usernameError : ''; ?></span>
                            </div>

                            <div class="form-group">
                                <label class="sr-only" for="username">Username</label>
                                <input type="text" id="email" name="email" class="form-control"  value="<?php echo isset($email) ? $email : ''; ?>" <?php echo !empty($emailError) ? "autofocus": '' ;?> placeholder="Email..">
                                <span style="color:red"><?php echo isset($emailError) ? $emailError : ''; ?></span>
                            </div>

                            <div class="form-group">
                                <label class="sr-only" for="form-password">Password</label>
                                <input type="password" id="password" name="password" class="form-control"  value="<?php echo isset($password) ? $password : ''; ?>" <?php echo !empty($passwordError) ? "autofocus": '' ;?> placeholder="Password..">
                                <span style="color:red"><?php echo isset($passwordError) ? $passwordError : ''; ?></span>
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="form-password">Password</label>
                                <input type="password" id="cpassword" name="cpassword" class="form-control"  value="<?php echo isset($cpassword) ? $cpassword : ''; ?>" <?php echo !empty($confirmError) ? "autofocus": '' ;?> placeholder="Confirm Password..">
                                <span style="color:red"><?php echo isset($confirmError) ? $confirmError : ''; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
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
                            <div class="text-right">
                                <p>Already Registered?<a href="micro-login.php"> Login Here </a></p>
                            </div>
                            <button type="submit" name="register" class="btn">Sign up!</button>
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