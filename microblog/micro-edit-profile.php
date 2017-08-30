<?php
session_start();
require_once  "Database.php";
$database = new Database();
if (empty($_SESSION['microUser'])){
    header("Location: micro-login.php");
    exit;
}else{
    $userAuth = $_SESSION['microUser'];
    $database->query("SELECT * FROM users WHERE username = '$userAuth'");
    $user = $database->resultset();
    $sessionUserID = $user[0]['id'];
}
$error = 0;
$firstname = $user[0]['firstname'];
$lastname = $user[0]['lastname'];
$username = $user[0]['username'];
$email = $user[0]['email'];
$password = base64_decode($user[0]['password']);

if($user[0]['gender'] == 'male')
{
    $male = $user[0]['gender'];
}else{
    $female = $user[0]['gender'];
}
if(isset($_POST['profSave'])) {
    $firstname = htmlspecialchars($_POST["firstname"]);
    $lastname = htmlspecialchars($_POST["lastname"]);
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);
    $email = htmlspecialchars($_POST["email"]);
    print_r($_FILES);
    if(empty($firstname)){
        $firstnameError = "First Name is required";
        $error++;
    }else{
        if(!ctype_alpha($firstname))
        {
            $firstnameError = "Firstname must be alphabetic characters";
            $error++;
        }else{

            if(strlen($firstname) < '4' || strlen($firstname) > '10')  {
                $firstnameError = "Your First Name Must Contain At Least 4 to 10 Characters! ";
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

            if(strlen($lastname) < '4' || strlen($lastname) > '10')  {
                $lastnameError = "Your Last Name Must Contain At Least 4 to 10 Characters! ";
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

            if(strlen($username) < '6' || strlen($username) > '10') {
                $usernameError = "Your Username Must Contain At Least 6 to 10 Characters!";
                $error++;
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
        $file = $_FILES['upload'];
        $newFile = '';
        $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
        $ext = substr(strtolower(strrchr($file['name'], '.')), 1);
        if(in_array($ext, $arr_ext))
        {
            $time = date("d-m-Y")."-".time();
            $newfileName = str_replace("'","",$file['name']);
            $moveFile = './profile-img/' .$time."-".$newfileName;
            move_uploaded_file($file['tmp_name'], $moveFile);
            chmod($moveFile, 0666);
        }

        $hashpassword = base64_encode($password);
        $database->query("UPDATE users SET firstname = '$firstname', lastname = '$lastname', username= '$username', email='$email', password = '$hashpassword', gender = '$gender', upload='$moveFile' WHERE id = '$sessionUserID'");
        $database->execute();
        unset($_POST);
        $profileUser = $user[0]['username'];
        header("Location: micro-profile?username=$profileUser");
        die();
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Micro-Edit-Profile</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>Edit Profile</h1>
    <hr>
    <div class="row">
        <!-- left column -->
        <!-- edit form column -->
        <div class="col-md-9 personal-info">
            <h3>Personal info</h3>

            <form class="form-horizontal" role="form" method="post" id="formProfile" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-lg-3 control-label">First name:</label>
                    <div class="col-lg-8">
                        <input type="text" id="firstname" name="firstname" class="form-control"  value="<?php echo isset($firstname) ? $firstname : ''; ?>" <?php echo !empty($firstnameError) ? "autofocus": '' ;?> >
                        <span style="color:red"><?php echo isset($firstnameError) ? $firstnameError : ''; ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Last name:</label>
                    <div class="col-lg-8">
                        <input type="text" id="lastname" name="lastname" class="form-control"  value="<?php echo isset($lastname) ? $lastname : ''; ?>" <?php echo !empty($lastnameError) ? "autofocus": '' ;?> >
                        <span style="color:red"><?php echo isset($lastnameError) ? $lastnameError : ''; ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">User name:</label>
                    <div class="col-lg-8">
                        <input type="text" id="username" name="username" class="form-control"  value="<?php echo isset($username) ? $username : ''; ?>" <?php echo !empty($usernameError) ? "autofocus": '' ;?> >
                        <span style="color:red"><?php echo isset($usernameError) ? $usernameError : ''; ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Email:</label>
                    <div class="col-lg-8">
                        <input type="text" id="email" name="email" class="form-control"  value="<?php echo isset($email) ? $email : ''; ?>" <?php echo !empty($emailError) ? "autofocus": '' ;?> >
                        <span style="color:red"><?php echo isset($emailError) ? $emailError : ''; ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Password:</label>
                    <div class="col-lg-8">
                        <input type="password" id="password" name="password" class="form-control"  value="<?php echo isset($password) ? $password : ''; ?>" <?php echo !empty($passwordError) ? "autofocus": '' ;?> >
                        <span style="color:red"><?php echo isset($passwordError) ? $passwordError : ''; ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Gender:</label>
                    <div class="row">
                        <div class="col-sm-3 ">
                            <label class="radio-inline">
                                <input type="radio" name="gender" value="Male" id="gender" <?php echo isset($male) ? 'checked' : '';?>>Male
                            </label>
                        </div>
                        <div class="col-sm-3">
                            <label class="radio-inline">
                                <input type="radio" name="gender" value="Female" id="gender" <?php echo isset($female) ? 'checked' : '';?>>Female
                            </label>
                        </div>
                    </div>
                    <span style="color:red; display: block;"><?php echo isset($genderError) ? $genderError : ''; ?></span>
                </div>
                <div class="form-group">
                    <label for="upload" class="col-sm-3 control-label">Upload</label>
                    <div class="col-sm-8">
                        <input class="form-control" type="file" name="upload" id="upload" value="<?php echo 1; ?>" >
                        <span style="color:red"><?php echo isset($uploadError) ? $uploadError : ''; ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        <button type="submit" name="profSave" id="profSave" class="btn btn-primary">Save changes</button>
                        <a href="micro-blog.php" class="btn btn-default">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<hr>
</body>
<script src="http://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</html>

