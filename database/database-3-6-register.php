<?php
require "Database.php";
$database = new Database();
session_start();
if (isset($_SESSION['authUser']))
    header("Location: database-3-6.php");
$postform = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
if(isset($postform['register'])) {
    $error = 0;
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $description = $_POST["description"];
    $phone = $_POST['phone'];
    $country = $_POST['country'];

    if(empty($username)) {
        $usernameError = "Username is required";
        $error++;
    }
    else {
        if(!ctype_alnum($username))
        {
            $usernameError = "Username must be alphanumeric characters";
            $error++;
        }
        else{
            if (strlen($username) <= '6') {
            $usernameError = "Your Username Must Contain At Least 6 Characters!";
            $error++;
            }
            else{
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
    }
    else {
        $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
        if (!preg_match($regex, $_POST["email"])) {
            $emailError = "Email is invalid";
            $error++;
        }
        else{
            $database->query("SELECT email FROM users WHERE email = '$email'");
            $emailExist = $database->resultset();
            if(!empty($emailExist)){
                $emailError = "Email already exist";
                $error++;
            }
        }
    }
    if(!empty($password) && ($password == $_POST["cpassword"])) {
    $cpassword = $_POST["cpassword"];
        if (strlen($_POST["password"]) <= '8') {
            $passwordError = "Your Password Must Contain At Least 8 Characters!";
        }
        elseif(!preg_match("#[0-9]+#",$password)) {
            $passwordError = "Your Password Must Contain At Least 1 Number!";
        }
        elseif(!preg_match("#[A-Z]+#",$password)) {
            $passwordError = "Your Password Must Contain At Least 1 Capital Letter!";
        }
        elseif(!preg_match("#[a-z]+#",$password)) {
            $passwordError = "Your Password Must Contain At Least 1 Lowercase Letter!";
        }
    }
    elseif(!empty($password)) {
        $confirmError = "Please Check You've Entered Or Confirmed Your Password!";
    } else {
         $passwordError = "Password is required";
    }

    if (empty($description)) {
        $descriptionError = "Description is required";
        $error++;
    }
    if (empty($phone)) {
        $phoneError = "Phone number is required";
        $error++;
    }
    else{
        if(!preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", $phone)) {
            $phoneError = "Phone is invalid";
            $error++;
        }
    }
    if (empty($_POST["gender"])) {
        $genderError = "Gender is required";
        $error++;
    }
    else{
        if($_POST['gender'] == 'Male')
        {
             $male = $_POST['gender']; 
        }
        else{
        $female = $_POST['gender'];
        }
    }
    if (empty($country)) {
        $countryError = "Country is required";
        $error++;
    }
    if (empty($_FILES["upload"]['name'])) {
        $uploadError = "Image is required";
        $error++;
    }
    if($error == 0)
    {
        $file = $_FILES['upload'];
        $dbFile = 'profile-img/' .$file['name'];
        $arr_ext = array('jpg', 'jpeg', 'gif', 'png');
        $ext = substr(strtolower(strrchr($file['name'], '.')), 1);
        if(in_array($ext, $arr_ext))
        {
            $newFile = '/database/profile-img/' .$file['name'];
            move_uploaded_file($file['tmp_name'], $_SERVER["DOCUMENT_ROOT"]. $newFile);
        }
        $hashpassword = md5($password);
        $country = $_POST['country'];
        $gender =  $_POST['gender'];
        $database->query("INSERT INTO users (username, password, email, description , phone, country, gender, upload) VALUES('$username', '$hashpassword', '$email', '$description', '$phone', '$country', '$gender', '$dbFile')");
        $database->execute();
        $username = "";
        $email = "";
        $description = "";
        $phone = "";
        $gender = "";
        $message = "<div id='hideMe' align='center' class='alert-success'>You may now login</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>database register</title>
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
                <li><a href="database-3-6-login.php">Login</a></li>
                <li class="active"><a href="database-3-6-register.php">Register</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <form method="post" id="registerForm" class="form-horizontal" role="form" enctype='multipart/form-data' novalidate>
        <?php echo isset($message) ? $message : ''; ?>
        <h2>Registration Form</h2>
        <div class="form-group">
            <label for="username" class="col-sm-3 control-label">User Name</label>
            <div class="col-sm-9">
                <input type="text" id="username" name="username" class="form-control"  value="<?php echo isset($username) ? $username : ''; ?>" autofocus>
                 <span style="color:red"><?php echo isset($usernameError) ? $usernameError : ''; ?></span>
            </div>           
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-9">
                <input type="email" id="email" name="email" class="form-control" value="<?php echo isset($email) ? $email : ''; ?>"> 
                 <span style="color:red"><?php echo isset($emailError) ? $emailError : ''; ?></span>
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="col-sm-3 control-label">Password</label>
            <div class="col-sm-9">
                <input type="password" id="password" name="password" class="form-control">
                 <span style="color:red"><?php echo isset($passwordError) ? $passwordError : ''; ?></span>
            </div>      
        </div>
         <div class="form-group">
            <label for="password2" class="col-sm-3 control-label">Confirm Password</label>
            <div class="col-sm-9">
                <input type="password" id="cpassword" name="cpassword"class="form-control">
                <span style="color:red"><?php echo isset($confirmError) ? $confirmError : ''; ?></span>
            </div>
        </div>
        <div class="form-group">
            <label for="description" class="col-sm-3 control-label">Description</label>
            <div class="col-sm-9">
                <textarea class="form-control" rows="5" name="description" id="description"><?php echo isset($description) ? $description : ''; ?></textarea>
                 <span style="color:red"><?php echo isset($descriptionError) ? $descriptionError : ''; ?></span>
            </div>
        </div>
        <div class="form-group">
            <label for="phone" class="col-sm-3 control-label">Phone</label>
            <div class="col-sm-9">
                <input class="form-control" type="text" name="phone" id="phone" value="<?php echo isset($phone) ? $phone : ''; ?>" placeholder="XXX-XXXX-XXXX">
                <span style="color:red"><?php echo isset($phoneError) ? $phoneError : ''; ?></span>
            </div>      
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3">Gender</label>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-4">
                        <label class="radio-inline">
                             <input type="radio" name="gender" value="Male" id="gender" <?php echo isset($male) ? 'checked' : '';?>>Male
                        </label>
                    </div>
                    <div class="col-sm-4">
                        <label class="radio-inline">
                            <input type="radio" name="gender" value="Female" id="gender" <?php echo isset($female) ? 'checked' : '';?>>Female
                        </label>
                    </div>
                </div>
                 <span style="color:red; display: block;"><?php echo isset($genderError) ? $genderError : ''; ?></span>
            </div>
        </div> <!-- /.form-group -->
        <div class="form-group">
            <label for="country" class="col-sm-3 control-label">Country</label>
            <div class="col-sm-9">
                <select class="form-control" name="country" id="country" >
                        <option value="">Country...</option>
                        <option value="Afganistan" <?php echo isset($_POST['country']) == 'Afganistan' ? 'selected' : ''; ?>>Afghanistan</option>
                        <option value="Albania"<?php echo isset($_POST['country']) == 'Albania' ? 'selected' : ''; ?>>Albania</option>
                        <option value="Algeria" <?php echo isset($_POST['country']) == 'Algeria' ? 'selected' : ''; ?>>Algeria</option>
                        <option value="American Samoa" <?php echo isset($_POST['country']) == 'American Samoa' ? 'selected' : ''; ?>>American Samoa</option>
                        <option value="Andorra" <?php echo isset($_POST['country']) == 'American Samoa' ? 'selected' : ''; ?>>Andorra</option>
                        <option value="Angola" <?php echo isset($_POST['country']) == 'American Samoa' ? 'selected' : ''; ?>>Angola</option>
                        <option value="Anguilla" <?php echo isset($_POST['country']) == 'American Samoa"' ? 'selected' : ''; ?>>Anguilla</option>
                        <option value="Antigua &amp; Barbuda" <?php echo isset($_POST['country']) == 'Antigua &amp; Barbuda' ? 'selected' : ''; ?>>Antigua &amp; Barbuda</option>
                        <option value="Argentina" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Argentina</option>
                        <option value="Armenia" <?php echo isset($_POST['country']) == 'Armenia' ? 'selected' : ''; ?>>Armenia</option>
                        <option value="Aruba" <?php echo isset($_POST['country']) == 'Aruba' ? 'selected' : ''; ?>>Aruba</option>
                        <option value="Australia" <?php echo isset($_POST['country']) == 'Australia' ? 'selected' : ''; ?>>Australia</option>
                        <option value="Austria" <?php echo isset($_POST['country']) == 'Austria' ? 'selected' : ''; ?>>Austria</option>
                        <option value="Azerbaijan" <?php echo isset($_POST['country']) == 'Azerbaijan' ? 'selected' : ''; ?>>Azerbaijan</option>
                        <option value="Bahamas" <?php echo isset($_POST['country']) == 'Bahamas' ? 'selected' : ''; ?>>Bahamas</option>
                        <option value="Bahrain" <?php echo isset($_POST['country']) == 'Bahrain' ? 'selected' : ''; ?>>Bahrain</option>
                        <option value="Bangladesh" <?php echo isset($_POST['country']) == 'Bangladesh' ? 'selected' : ''; ?>>Bangladesh</option>
                        <option value="Barbados" <?php echo isset($_POST['country']) == 'Barbados' ? 'selected' : ''; ?>>Barbados</option>
                        <option value="Belarus" <?php echo isset($_POST['country']) == 'Belarus' ? 'selected' : ''; ?>>Belarus</option>
                        <option value="Belgium" <?php echo isset($_POST['country']) == 'Belgium' ? 'selected' : ''; ?>>Belgium</option>
                        <option value="Belize" <?php echo isset($_POST['country']) == 'Belize' ? 'selected' : ''; ?>>Belize</option>
                        <option value="Benin" <?php echo isset($_POST['country']) == 'Benin' ? 'selected' : ''; ?>>Benin</option>
                        <option value="Bermuda" <?php echo isset($_POST['country']) == 'Bermuda' ? 'selected' : ''; ?>>Bermuda</option>
                        <option value="Bhutan" <?php echo isset($_POST['country']) == 'Bhutan' ? 'selected' : ''; ?>>Bhutan</option>
                        <option value="Bolivia" <?php echo isset($_POST['country']) == 'Bolivia' ? 'selected' : ''; ?>>Bolivia</option>
                        <option value="Bonaire" <?php echo isset($_POST['country']) == 'Bonaire' ? 'selected' : ''; ?>>Bonaire</option>
                        <option value="Bosnia &amp; Herzegovina" <?php echo isset($_POST['country']) == 'Bosnia &amp; Herzegovina' ? 'selected' : ''; ?>>Bosnia &amp; Herzegovina</option>
                        <option value="Botswana" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Botswana</option>
                        <option value="Brazil" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Brazil</option>
                        <option value="British Indian Ocean Ter" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>British Indian Ocean Ter</option>
                        <option value="Brunei" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Brunei</option>
                        <option value="Bulgaria" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Bulgaria</option>
                        <option value="Burkina Faso" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Burkina Faso</option>
                        <option value="Burundi" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Burundi</option>
                        <option value="Cambodia" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Cambodia</option>
                        <option value="Cameroon" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Cameroon</option>
                        <option value="Canada" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Canada</option>
                        <option value="Canary Islands" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Canary Islands</option>
                        <option value="Cape Verde" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Cape Verde</option>
                        <option value="Cayman Islands" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Cayman Islands</option>
                        <option value="Central African Republic" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Central African Republic</option>
                        <option value="Chad" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Chad</option>
                        <option value="Channel Islands" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Channel Islands</option>
                        <option value="Chile" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Chile</option>
                        <option value="China" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>China</option>
                        <option value="Christmas Island" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Christmas Island</option>
                        <option value="Cocos Island" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Cocos Island</option>
                        <option value="Colombia" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Colombia</option>
                        <option value="Comoros" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Comoros</option>
                        <option value="Congo" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Congo</option>
                        <option value="Cook Islands" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Cook Islands</option>
                        <option value="Costa Rica" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Costa Rica</option>
                        <option value="Cote DIvoire" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Cote D'Ivoire</option>
                        <option value="Croatia" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Croatia</option>
                        <option value="Cuba" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Cuba</option>
                        <option value="Curaco" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Curacao</option>
                        <option value="Cyprus" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Cyprus</option>
                        <option value="Czech Republic" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Czech Republic</option>
                        <option value="Denmark" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Denmark</option>
                        <option value="Djibouti" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Djibouti</option>
                        <option value="Dominica" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Dominica</option>
                        <option value="Dominican Republic" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Dominican Republic</option>
                        <option value="East Timor" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>East Timor</option>
                        <option value="Ecuador" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Ecuador</option>
                        <option value="Egypt" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Egypt</option>
                        <option value="El Salvador" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>El Salvador</option>
                        <option value="Equatorial Guinea" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Equatorial Guinea</option>
                        <option value="Eritrea" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Eritrea</option>
                        <option value="Estonia" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Estonia</option>
                        <option value="Ethiopia" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Ethiopia</option>
                        <option value="Falkland Islands" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Falkland Islands</option>
                        <option value="Faroe Islands" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Faroe Islands</option>
                        <option value="Fiji" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Fiji</option>
                        <option value="Finland" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Finland</option>
                        <option value="France" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>France</option>
                        <option value="French Guiana" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>French Guiana</option>
                        <option value="French Polynesia" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>French Polynesia</option>
                        <option value="French Southern Ter" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>French Southern Ter</option>
                        <option value="Gabon" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Gabon</option>
                        <option value="Gambia" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Gambia</option>
                        <option value="Georgia" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Georgia</option>
                        <option value="Germany" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Germany</option>
                        <option value="Ghana" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Ghana</option>
                        <option value="Gibraltar" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Gibraltar</option>
                        <option value="Great Britain" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Great Britain</option>
                        <option value="Greece" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Greece</option>
                        <option value="Greenland" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Greenland</option>
                        <option value="Grenada" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Grenada</option>
                        <option value="Guadeloupe" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Guadeloupe</option>
                        <option value="Guam" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Guam</option>
                        <option value="Guatemala" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Guatemala</option>
                        <option value="Guinea" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Guinea</option>
                        <option value="Guyana" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Guyana</option>
                        <option value="Haiti" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Haiti</option>
                        <option value="Hawaii" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Hawaii</option>
                        <option value="Honduras" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Honduras</option>
                        <option value="Hong Kong" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Hong Kong</option>
                        <option value="Hungary" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Hungary</option>
                        <option value="Iceland" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Iceland</option>
                        <option value="India" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>India</option>
                        <option value="Indonesia" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Indonesia</option>
                        <option value="Iran" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Iran</option>
                        <option value="Iraq" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Iraq</option>
                        <option value="Ireland" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Ireland</option>
                        <option value="Isle of Man" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Isle of Man</option>
                        <option value="Israel" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Israel</option>
                        <option value="Italy" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Italy</option>
                        <option value="Jamaica" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Jamaica</option>
                        <option value="Japan" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Japan</option>
                        <option value="Jordan" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Jordan</option>
                        <option value="Kazakhstan" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Kazakhstan</option>
                        <option value="Kenya" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Kenya</option>
                        <option value="Kiribati" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Kiribati</option>
                        <option value="Korea North" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Korea North</option>
                        <option value="Korea Sout" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Korea South</option>
                        <option value="Kuwait" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Kuwait</option>
                        <option value="Kyrgyzstan" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Kyrgyzstan</option>
                        <option value="Laos"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Laos</option>
                        <option value="Latvia"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Latvia</option>
                        <option value="Lebanon"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Lebanon</option>
                        <option value="Lesotho"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Lesotho</option>
                        <option value="Liberia"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Liberia</option>
                        <option value="Libya"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Libya</option>
                        <option value="Liechtenstein"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Liechtenstein</option>
                        <option value="Lithuania"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Lithuania</option>
                        <option value="Luxembourg"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Luxembourg</option>
                        <option value="Macau"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Macau</option>
                        <option value="Macedonia"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Macedonia</option>
                        <option value="Madagascar"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Madagascar</option>
                        <option value="Malaysia"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Malaysia</option>
                        <option value="Malawi"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Malawi</option>
                        <option value="Maldives"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Maldives</option>
                        <option value="Mali"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Mali</option>
                        <option value="Malta"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Malta</option>
                        <option value="Marshall Islands"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Marshall Islands</option>
                        <option value="Martinique"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Martinique</option>
                        <option value="Mauritania"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Mauritania</option>
                        <option value="Mauritius"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Mauritius</option>
                        <option value="Mayotte"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Mayotte</option>
                        <option value="Mexico"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Mexico</option>
                        <option value="Midway Islands"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Midway Islands</option>
                        <option value="Moldova"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Moldova</option>
                        <option value="Monaco"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Monaco</option>
                        <option value="Mongolia"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Mongolia</option>
                        <option value="Montserrat"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Montserrat</option>
                        <option value="Morocco"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Morocco</option>
                        <option value="Mozambique"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Mozambique</option>
                        <option value="Myanmar"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Myanmar</option>
                        <option value="Nambia"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Nambia</option>
                        <option value="Nauru"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Nauru</option>
                        <option value="Nepal"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Nepal</option>
                        <option value="Netherland Antilles"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Netherland Antilles</option>
                        <option value="Netherlands"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Netherlands (Holland, Europe)</option>
                        <option value="Nevis"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Nevis</option>
                        <option value="New Caledonia"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>New Caledonia</option>
                        <option value="New Zealand"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>New Zealand</option>
                        <option value="Nicaragua"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Nicaragua</option>
                        <option value="Niger"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Niger</option>
                        <option value="Nigeria"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Nigeria</option>
                        <option value="Niue"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Niue</option>
                        <option value="Norfolk Island"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Norfolk Island</option>
                        <option value="Norway"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Norway</option>
                        <option value="Oman"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Oman</option>
                        <option value="Pakistan"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Pakistan</option>
                        <option value="Palau Island"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Palau Island</option>
                        <option value="Palestine"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Palestine</option>
                        <option value="Panama"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Panama</option>
                        <option value="Papua New Guinea"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Papua New Guinea</option>
                        <option value="Paraguay"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Paraguay</option>
                        <option value="Peru"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Peru</option>
                        <option value="Phillipines"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Philippines</option>
                        <option value="Pitcairn Island"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Pitcairn Island</option>
                        <option value="Poland"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Poland</option>
                        <option value="Portugal"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Portugal</option>
                        <option value="Puerto Rico"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Puerto Rico</option>
                        <option value="Qatar"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Qatar</option>
                        <option value="Republic of Montenegro"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Republic of Montenegro</option>
                        <option value="Republic of Serbia"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Republic of Serbia</option>
                        <option value="Reunion"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Reunion</option>
                        <option value="Romania"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Romania</option>
                        <option value="Russia"<?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Russia</option>
                        <option value="Rwanda" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Rwanda</option>
                        <option value="St Barthelemy" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>St Barthelemy</option>
                        <option value="St Eustatius" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>St Eustatius</option>
                        <option value="St Helena" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>St Helena</option>
                        <option value="St Kitts-Nevis" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>St Kitts-Nevis</option>
                        <option value="St Lucia" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>St Lucia</option>
                        <option value="St Maarten" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>St Maarten</option>
                        <option value="St Pierre &amp; Miquelon" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>St Pierre &amp; Miquelon</option>
                        <option value="St Vincent &amp; Grenadines" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>St Vincent &amp; Grenadines</option>
                        <option value="Saipan" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Saipan</option>
                        <option value="Samoa" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Samoa</option>
                        <option value="Samoa American" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Samoa American</option>
                        <option value="San Marino" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>San Marino</option>
                        <option value="Sao Tome &amp; Principe" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Sao Tome &amp; Principe</option>
                        <option value="Saudi Arabia" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Saudi Arabia</option>
                        <option value="Senegal" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Senegal</option>
                        <option value="Serbia" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Serbia</option>
                        <option value="Seychelles" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Seychelles</option>
                        <option value="Sierra Leone" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Sierra Leone</option>
                        <option value="Singapore" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Singapore</option>
                        <option value="Slovakia" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Slovakia</option>
                        <option value="Slovenia" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Slovenia</option>
                        <option value="Solomon Islands" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Solomon Islands</option>
                        <option value="Somalia" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Somalia</option>
                        <option value="South Africa" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>South Africa</option>
                        <option value="Spain" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Spain</option>
                        <option value="Sri Lanka" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Sri Lanka</option>
                        <option value="Sudan" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Sudan</option>
                        <option value="Suriname" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Suriname</option>
                        <option value="Swaziland" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Swaziland</option>
                        <option value="Sweden" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Sweden</option>
                        <option value="Switzerland" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Switzerland</option>
                        <option value="Syria" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Syria</option>
                        <option value="Tahiti" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Tahiti</option>
                        <option value="Taiwan" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Taiwan</option>
                        <option value="Tajikistan" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Tajikistan</option>
                        <option value="Tanzania" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Tanzania</option>
                        <option value="Thailand" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Thailand</option>
                        <option value="Togo" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Togo</option>
                        <option value="Tokelau" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Tokelau</option>
                        <option value="Tonga" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Tonga</option>
                        <option value="Trinidad &amp; Tobago" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Trinidad &amp; Tobago</option>
                        <option value="Tunisia" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Tunisia</option>
                        <option value="Turkey" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Turkey</option>
                        <option value="Turkmenistan" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Turkmenistan</option>
                        <option value="Turks &amp; Caicos Is" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Turks &amp; Caicos Is</option>
                        <option value="Tuvalu" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Tuvalu</option>
                        <option value="Uganda" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Uganda</option>
                        <option value="Ukraine" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Ukraine</option>
                        <option value="United Arab Erimates" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>United Arab Emirates</option>
                        <option value="United Kingdom" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>United Kingdom</option>
                        <option value="United States of America" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>United States of America</option>
                        <option value="Uraguay" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Uruguay</option>
                        <option value="Uzbekistan" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Uzbekistan</option>
                        <option value="Vanuatu" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Vanuatu</option>
                        <option value="Vatican City State" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Vatican City State</option>
                        <option value="Venezuela" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Venezuela</option>
                        <option value="Vietnam" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Vietnam</option>
                        <option value="Virgin Islands (Brit)" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Virgin Islands (Brit)</option>
                        <option value="Virgin Islands (USA)" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Virgin Islands (USA)</option>
                        <option value="Wake Island" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Wake Island</option>
                        <option value="Wallis &amp; Futana Is" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Wallis &amp; Futana Is</option>
                        <option value="Yemen" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Yemen</option>
                        <option value="Zaire" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Zaire</option>
                        <option value="Zambia" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Zambia</option>
                        <option value="Zimbabwe" <?php echo isset($_POST['country']) == 'Argentina' ? 'selected' : ''; ?>>Zimbabwe</option>
                    </select>
                     <span style="color:red"><?php echo isset($countryError) ? $countryError : ''; ?></span>
            </div>
           
        </div> <!-- /.form-group -->
         <div class="form-group">
            <label for="upload" class="col-sm-3 control-label">Upload</label>
            <div class="col-sm-9">
               <input class="form-control" type="file" name="upload" id="upload" >
               <span style="color:red"><?php echo isset($uploadError) ? $uploadError : ''; ?></span>
            </div> 
        </div>
        <div class="form-group">
            <div class="col-sm-9 col-sm-offset-3">
                <button type="submit" name="register" class="btn btn-primary btn-block">Register</button>
            </div>
        </div>
    </form> <!-- /form -->
</div> <!-- ./container -->
</body>
</html>