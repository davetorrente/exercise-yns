<?php
require "Database.php";
$database = new Database();
session_start();
if (isset($_SESSION['authUser']))
    header("Location: database-3-6.php");

if(isset($_POST['register'])) {
    $error = 0;
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);
    $email = htmlspecialchars($_POST["email"]);
    $description = htmlspecialchars($_POST["description"]);
    $phone = htmlspecialchars($_POST['phone']);
    $country = htmlspecialchars($_POST['country']);
    if(isset($_POST['gender']))
    {
        $gender = htmlspecialchars($_POST['gender']);
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
            if(strlen($username) < '6') {
            $usernameError = "Your Username Must Contain At Least 6 Characters!";
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
        if (!preg_match($regex, $_POST["email"])) {
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
    if(!empty($password) && ($password == $_POST["cpassword"])) {
    $cpassword = $_POST["cpassword"];
        if (strlen($_POST["password"]) < '8') {
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
    elseif(!empty($password)) {
        $confirmError = "Please Check You've Entered Or Confirmed Your Password!";
        $error++;
    }else {
         $passwordError = "Password is required";
        $error++;
    }
    if(empty($_POST['cpassword']))
    {
        $confirmError = "Confirm Password is required";
        $error++;
    }

    if (empty($description)) {
        $descriptionError = "Description is required";
        $error++;
    }
    if (empty($phone)) {
        $phoneError = "Phone number is required";
        $error++;
    }else{
        if(!preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", $phone)) {
            $phoneError = "Phone is invalid";
            $error++;
        }
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
        $hashpassword = md5($password);
        $database->query("INSERT INTO users (username, password, email, description , phone, country, gender, upload) VALUES('$username', '$hashpassword', '$email', '$description', '$phone', '$country', '$gender', '$moveFile')");
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
                    <option <?php if(isset($country)):
                        echo $country== 'Afghanistan' ? "selected" : "";
                    endif; ?> value="Afghanistan" >Afghanistan
                    </option>
                    <option  <?php if(isset($country)):
                        echo $country== 'Albania' ? "selected" : "";
                    endif; ?> value="Albania">Albania
                    </option>
                    <option <?php if(isset($country)):
                        echo $country== 'Algeria' ? "selected" : "";
                    endif; ?> value="Algeria">Algeria
                    </option>
                    <option <?php if(isset($country)):
                        echo $country== 'American Samoa' ? "selected" : "";
                    endif; ?> value="American Samoa">American Samoa</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Andorra' ? "selected" : "";
                    endif; ?> value="Andorra" >Andorra</option>
                    <option  <?php if(isset($country)):
                        echo $country== 'Angola' ? "selected" : "";
                    endif; ?> value="Angola">Angola</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Anguilla' ? "selected" : "";
                    endif; ?> value="Anguilla">Anguilla</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Antigua & Barbuda' ? "selected" : "";
                    endif; ?> value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
                    <option  <?php if(isset($country)):
                        echo $country== 'Argentina' ? "selected" : "";
                    endif; ?> value="Argentina">Argentina</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Armenia' ? "selected" : "";
                    endif; ?> value="Armenia" >Armenia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Aruba' ? "selected" : "";
                    endif; ?> value="Aruba">Aruba</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Australia' ? "selected" : "";
                    endif; ?> value="Australia" >Australia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Austria' ? "selected" : "";
                    endif; ?> value="Austria" >Austria</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Azerbaijan' ? "selected" : "";
                    endif; ?> value="Azerbaijan" >Azerbaijan</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Bahamas' ? "selected" : "";
                    endif; ?> value="Bahamas">Bahamas</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Bahrain' ? "selected" : "";
                    endif; ?> value="Bahrain">Bahrain</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Bangladesh' ? "selected" : "";
                    endif; ?> value="Bangladesh" >Bangladesh</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Barbados' ? "selected" : "";
                    endif; ?> value="Barbados">Barbados</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Belarus' ? "selected" : "";
                    endif; ?> value="Belarus" >Belarus</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Belgium' ? "selected" : "";
                    endif; ?> value="Belgium" >Belgium</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Belize' ? "selected" : "";
                    endif; ?> value="Belize" >Belize</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Benin' ? "selected" : "";
                    endif; ?> value="Benin" >Benin</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Bermuda' ? "selected" : "";
                    endif; ?> value="Bermuda">Bermuda</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Bhutan' ? "selected" : "";
                    endif; ?> value="Bhutan" >Bhutan</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Bolivia' ? "selected" : "";
                    endif; ?> value="Bolivia">Bolivia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Bonaire' ? "selected" : "";
                    endif; ?> value="Bonaire">Bonaire</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Bosnia &amp; Herzegovina' ? "selected" : "";
                    endif; ?> value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Botswana' ? "selected" : "";
                    endif; ?> value="Botswana">Botswana</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Brazil' ? "selected" : "";
                    endif; ?> value="Brazil">Brazil</option>
                    <option <?php if(isset($country)):
                        echo $country== 'British Indian Ocean Ter' ? "selected" : "";
                    endif; ?> value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Brunei' ? "selected" : "";
                    endif; ?> value="Brunei">Brunei</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Bulgaria' ? "selected" : "";
                    endif; ?> value="Bulgaria">Bulgaria</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Burkina Faso' ? "selected" : "";
                    endif; ?> value="Burkina Faso">Burkina Faso</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Burundi' ? "selected" : "";
                    endif; ?> value="Burundi">Burundi</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Cambodia' ? "selected" : "";
                    endif; ?> value="Cambodia">Cambodia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Cameroon' ? "selected" : "";
                    endif; ?> value="Cameroon">Cameroon</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Canada' ? "selected" : "";
                    endif; ?> value="Canada">Canada</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Canary Islands' ? "selected" : "";
                    endif; ?> value="Canary Islands">Canary Islands</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Cape Verde' ? "selected" : "";
                    endif; ?> value="Cape Verde">Cape Verde</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Cayman Islands"' ? "selected" : "";
                    endif; ?> value="Cayman Islands">Cayman Islands</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Central African Republic' ? "selected" : "";
                    endif; ?> value="Central African Republic">Central African Republic</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Chad' ? "selected" : "";
                    endif; ?> value="Chad">Chad</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Channel Islands' ? "selected" : "";
                    endif; ?> value="Channel Islands">Channel Islands</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Chile' ? "selected" : "";
                    endif; ?> value="Chile">Chile</option>
                    <option <?php if(isset($country)):
                        echo $country== 'China' ? "selected" : "";
                    endif; ?> value="China">China</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Christmas Island' ? "selected" : "";
                    endif; ?> value="Christmas Island">Christmas Island</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Cocos Island' ? "selected" : "";
                    endif; ?> value="Cocos Island">Cocos Island</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Colombia' ? "selected" : "";
                    endif; ?> value="Colombia">Colombia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Comoros' ? "selected" : "";
                    endif; ?> value="Comoros">Comoros</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Congo' ? "selected" : "";
                    endif; ?> value="Congo">Congo</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Cook Islands' ? "selected" : "";
                    endif; ?> value="Cook Islands">Cook Islands</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Costa Rica' ? "selected" : "";
                    endif; ?> value="Costa Rica">Costa Rica</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Cote DIvoire' ? "selected" : "";
                    endif; ?> value="Cote DIvoire">Cote D'Ivoire</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Croatia' ? "selected" : "";
                    endif; ?> value="Croatia">Croatia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Cuba' ? "selected" : "";
                    endif; ?> value="Cuba">Cuba</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Curaco' ? "selected" : "";
                    endif; ?> value="Curaco">Curacao</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Cyprus' ? "selected" : "";
                    endif; ?> value="Cyprus">Cyprus</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Czech Republic' ? "selected" : "";
                    endif; ?> value="Czech Republic">Czech Republic</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Denmark' ? "selected" : "";
                    endif; ?> value="Denmark">Denmark</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Djibouti' ? "selected" : "";
                    endif; ?> value="Djibouti">Djibouti</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Dominica' ? "selected" : "";
                    endif; ?> value="Dominica">Dominica</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Dominican Republic' ? "selected" : "";
                    endif; ?> value="Dominican Republic">Dominican Republic</option>
                    <option <?php if(isset($country)):
                        echo $country== 'East Timor' ? "selected" : "";
                    endif; ?> value="East Timor">East Timor</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Ecuador' ? "selected" : "";
                    endif; ?> value="Ecuador">Ecuador</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Egypt' ? "selected" : "";
                    endif; ?> value="Egypt">Egypt</option>
                    <option <?php if(isset($country)):
                        echo $country== 'El Salvador' ? "selected" : "";
                    endif; ?> value="El Salvador">El Salvador</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Equatorial Guinea' ? "selected" : "";
                    endif; ?> value="Equatorial Guinea">Equatorial Guinea</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Eritrea' ? "selected" : "";
                    endif; ?> value="Eritrea">Eritrea</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Estonia' ? "selected" : "";
                    endif; ?> value="Estonia">Estonia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Ethiopia' ? "selected" : "";
                    endif; ?> value="Ethiopia">Ethiopia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Falkland Islands' ? "selected" : "";
                    endif; ?> value="Falkland Islands">Falkland Islands</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Faroe Islands' ? "selected" : "";
                    endif; ?> value="Faroe Islands">Faroe Islands</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Fiji' ? "selected" : "";
                    endif; ?> value="Fiji">Fiji</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Finland' ? "selected" : "";
                    endif; ?> value="Finland">Finland</option>
                    <option <?php if(isset($country)):
                        echo $country== 'France' ? "selected" : "";
                    endif; ?> value="France">France</option>
                    <option <?php if(isset($country)):
                        echo $country== 'French Guiana' ? "selected" : "";
                    endif; ?> value="French Guiana">French Guiana</option>
                    <option <?php if(isset($country)):
                        echo $country== 'French Polynesia' ? "selected" : "";
                    endif; ?> value="French Polynesia">French Polynesia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'French Southern Ter' ? "selected" : "";
                    endif; ?> value="French Southern Ter">French Southern Ter</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Gabon' ? "selected" : "";
                    endif; ?> value="Gabon">Gabon</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Gambia' ? "selected" : "";
                    endif; ?> value="Gambia">Gambia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Georgia' ? "selected" : "";
                    endif; ?> value="Georgia">Georgia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Germany' ? "selected" : "";
                    endif; ?> value="Germany">Germany</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Ghana' ? "selected" : "";
                    endif; ?> value="Ghana">Ghana</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Gibraltar' ? "selected" : "";
                    endif; ?> value="Gibraltar">>Gibraltar</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Great Britain' ? "selected" : "";
                    endif; ?> value="Great Britain">Great Britain</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Greece' ? "selected" : "";
                    endif; ?> value="Greece">Greece</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Greenland' ? "selected" : "";
                    endif; ?> value="Greenland" >Greenland</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Grenada' ? "selected" : "";
                    endif; ?> value="Grenada">Grenada</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Guadeloupe' ? "selected" : "";
                    endif; ?> value="Guadeloupe">Guadeloupe</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Guam' ? "selected" : "";
                    endif; ?> value="Guam">Guam</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Guatemala' ? "selected" : "";
                    endif; ?> value="Guatemala">Guatemala</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Guinea' ? "selected" : "";
                    endif; ?> value="Guinea">Guinea</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Guyana' ? "selected" : "";
                    endif; ?> value="Guyana">Guyana</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Haiti' ? "selected" : "";
                    endif; ?> value="Haiti">Haiti</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Hawaii' ? "selected" : "";
                    endif; ?> value="Hawaii">Hawaii</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Honduras' ? "selected" : "";
                    endif; ?> value="Honduras">Honduras</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Hong Kong' ? "selected" : "";
                    endif; ?> value="Hong Kong">Hong Kong</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Hungary' ? "selected" : "";
                    endif; ?> value="Hungary">Hungary</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Iceland' ? "selected" : "";
                    endif; ?> value="Iceland">Iceland</option>
                    <option <?php if(isset($country)):
                        echo $country== 'India' ? "selected" : "";
                    endif; ?> value="India">India</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Indonesia' ? "selected" : "";
                    endif; ?> value="Indonesia">Indonesia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Iran' ? "selected" : "";
                    endif; ?> value="Iran">Iran</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Iraq' ? "selected" : "";
                    endif; ?> value="Iraq">Iraq</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Ireland' ? "selected" : "";
                    endif; ?> value="Ireland">Ireland</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Isle of Man' ? "selected" : "";
                    endif; ?> value="Isle of Man">Isle of Man</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Israel' ? "selected" : "";
                    endif; ?> value="Israel">Israel</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Italy' ? "selected" : "";
                    endif; ?> value="Italy">Italy</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Jamaica' ? "selected" : "";
                    endif; ?> value="Jamaica">Jamaica</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Japan' ? "selected" : "";
                    endif; ?> value="Japan">Japan</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Jordan' ? "selected" : "";
                    endif; ?> value="Jordan">Jordan</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Kazakhstan' ? "selected" : "";
                    endif; ?> value="Kazakhstan">Kazakhstan</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Kenya' ? "selected" : "";
                    endif; ?> value="Kenya">Kenya</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Kiribati' ? "selected" : "";
                    endif; ?> value="Kiribati">Kiribati</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Korea North' ? "selected" : "";
                    endif; ?> value="Korea North">Korea North</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Korea South' ? "selected" : "";
                    endif; ?> value="Korea South">Korea South</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Kuwait' ? "selected" : "";
                    endif; ?> value="Kuwait">Kuwait</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Kyrgyzstan' ? "selected" : "";
                    endif; ?> value="Kyrgyzstan">Kyrgyzstan</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Laos' ? "selected" : "";
                    endif; ?> value="Laos">Laos</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Latvia' ? "selected" : "";
                    endif; ?> value="Latvia">Latvia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Lebanon' ? "selected" : "";
                    endif; ?> value="Lebanon">Lebanon</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Lesotho' ? "selected" : "";
                    endif; ?> value="Lesotho">Lesotho</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Liberia' ? "selected" : "";
                    endif; ?> value="Liberia">Liberia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Libya' ? "selected" : "";
                    endif; ?> value="Libya">Libya</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Liechtenstein' ? "selected" : "";
                    endif; ?> value="Liechtenstein">Liechtenstein</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Lithuania' ? "selected" : "";
                    endif; ?> value="Lithuania">Lithuania</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Luxembourg' ? "selected" : "";
                    endif; ?> value="Luxembourg">Luxembourg</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Macau' ? "selected" : "";
                    endif; ?> value="Macau">Macau</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Macedonia' ? "selected" : "";
                    endif; ?> value="Macedonia">Macedonia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Madagascar' ? "selected" : "";
                    endif; ?> value="Madagascar">Madagascar</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Malaysia' ? "selected" : "";
                    endif; ?> value="Malaysia">Malaysia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Malawi' ? "selected" : "";
                    endif; ?> value="Malawi">Malawi</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Maldives' ? "selected" : "";
                    endif; ?> value="Maldives">Maldives</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Mali' ? "selected" : "";
                    endif; ?> value="Mali">Mali</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Malta' ? "selected" : "";
                    endif; ?> value="Malta">Malta</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Marshall Islands' ? "selected" : "";
                    endif; ?> value="Marshall Islands">Marshall Islands</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Martinique' ? "selected" : "";
                    endif; ?> value="Martinique">Martinique</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Mauritania' ? "selected" : "";
                    endif; ?> value="Mauritania">Mauritania</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Mauritius' ? "selected" : "";
                    endif; ?> value="Mauritius">Mauritius</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Mayotte' ? "selected" : "";
                    endif; ?> value="Mayotte">Mayotte</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Mexico' ? "selected" : "";
                    endif; ?> value="Mexico">Mexico</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Midway Islands' ? "selected" : "";
                    endif; ?> value="Midway Islands">Midway Islands</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Moldova' ? "selected" : "";
                    endif; ?> value="Moldova">Moldova</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Monaco' ? "selected" : "";
                    endif; ?> value="Monaco">Monaco</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Mongolia' ? "selected" : "";
                    endif; ?> value="Mongolia">Mongolia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Montserrat' ? "selected" : "";
                    endif; ?> value="Montserrat">Montserrat</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Morocco' ? "selected" : "";
                    endif; ?> value="Morocco">Morocco</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Mozambique' ? "selected" : "";
                    endif; ?> value="Mozambique">Mozambique</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Myanmar' ? "selected" : "";
                    endif; ?> value="Myanmar">Myanmar</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Nambia' ? "selected" : "";
                    endif; ?> value="Nambia">Nambia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Nauru' ? "selected" : "";
                    endif; ?> value="Nauru">Nauru</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Nepal' ? "selected" : "";
                    endif; ?> value="Nepal">Nepal</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Netherland Antilles' ? "selected" : "";
                    endif; ?> value="Netherland Antilles">Netherland Antilles</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Netherlands' ? "selected" : "";
                    endif; ?> value="Netherlands">Netherlands (Holland, Europe)</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Nevis' ? "selected" : "";
                    endif; ?> value="Nevis">Nevis</option>
                    <option <?php if(isset($country)):
                        echo $country== 'New Caledonia' ? "selected" : "";
                    endif; ?> value="New Caledonia">New Caledonia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'New Zealand' ? "selected" : "";
                    endif; ?> value="New Zealand">New Zealand</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Nicaragua' ? "selected" : "";
                    endif; ?> value="Nicaragua">Nicaragua</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Niger' ? "selected" : "";
                    endif; ?> value="Niger">Niger</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Nigeria' ? "selected" : "";
                    endif; ?> value="Nigeria">Nigeria</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Niue' ? "selected" : "";
                    endif; ?> value="Niue">Niue</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Norfolk Island' ? "selected" : "";
                    endif; ?> value="Norfolk Island">Norfolk Island</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Norway' ? "selected" : "";
                    endif; ?> value="Norway">Norway</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Oman' ? "selected" : "";
                    endif; ?> value="Oman">Oman</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Pakistan' ? "selected" : "";
                    endif; ?> value="Pakistan">Pakistan</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Palau Island' ? "selected" : "";
                    endif; ?> value="Palau Island">Palau Island</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Palestine' ? "selected" : "";
                    endif; ?> value="Palestine">Palestine</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Panama' ? "selected" : "";
                    endif; ?> value="Panama">Panama</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Papua New Guinea' ? "selected" : "";
                    endif; ?> value="Papua New Guinea">Papua New Guinea</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Paraguay' ? "selected" : "";
                    endif; ?> value="Paraguay">Paraguay</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Peru' ? "selected" : "";
                    endif; ?> value="Peru">Peru</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Phillipines' ? "selected" : "";
                    endif; ?> value="Phillipines">Philippines</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Pitcairn Island' ? "selected" : "";
                    endif; ?> value="Pitcairn Island">Pitcairn Island</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Poland' ? "selected" : "";
                    endif; ?> value="Poland">Poland</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Portugal' ? "selected" : "";
                    endif; ?> value="Portugal">Portugal</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Puerto Rico' ? "selected" : "";
                    endif; ?> value="Puerto Rico">Puerto Rico</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Qatar' ? "selected" : "";
                    endif; ?> value="Qatar">Qatar</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Republic of Montenegro' ? "selected" : "";
                    endif; ?> value="Republic of Montenegro">Republic of Montenegro</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Republic of Serbia' ? "selected" : "";
                    endif; ?> value="Republic of Serbia">Republic of Serbia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Reunion' ? "selected" : "";
                    endif; ?> value="Reunion">Reunion</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Romania' ? "selected" : "";
                    endif; ?> value="Romania">Romania</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Russia' ? "selected" : "";
                    endif; ?> value="Russia">Russia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Rwanda' ? "selected" : "";
                    endif; ?> value="Rwanda">Rwanda</option>
                    <option <?php if(isset($country)):
                        echo $country== 'St Barthelemy' ? "selected" : "";
                    endif; ?> value="St Barthelemy">St Barthelemy</option>
                    <option <?php if(isset($country)):
                        echo $country== 'St Eustatius' ? "selected" : "";
                    endif; ?> value="St Eustatius">St Eustatius</option>
                    <option <?php if(isset($country)):
                        echo $country== 'St Helena' ? "selected" : "";
                    endif; ?> value="St Helena">St Helena</option>
                    <option <?php if(isset($country)):
                        echo $country== 'St Kitts-Nevis' ? "selected" : "";
                    endif; ?> value="St Kitts-Nevis">St Kitts-Nevis</option>
                    <option <?php if(isset($country)):
                        echo $country== 'St Lucia' ? "selected" : "";
                    endif; ?> value="St Lucia">St Lucia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'St Maarten' ? "selected" : "";
                    endif; ?> value="St Maarten">St Maarten</option>
                    <option <?php if(isset($country)):
                        echo $country== 'St Pierre &amp; Miquelon' ? "selected" : "";
                    endif; ?> value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
                    <option <?php if(isset($country)):
                        echo $country== 'St Vincent & Grenadines' ? "selected" : "";
                    endif; ?> value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Saipan' ? "selected" : "";
                    endif; ?> value="Saipan">Saipan</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Samoa' ? "selected" : "";
                    endif; ?> value="Samoa">Samoa</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Samoa American' ? "selected" : "";
                    endif; ?> value="Samoa American">Samoa American</option>
                    <option <?php if(isset($country)):
                        echo $country== 'San Marino' ? "selected" : "";
                    endif; ?> value="San Marino">San Marino</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Sao Tome & Principe' ? "selected" : "";
                    endif; ?> value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Saudi Arabia' ? "selected" : "";
                    endif; ?> value="Saudi Arabia">Saudi Arabia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Senegal' ? "selected" : "";
                    endif; ?> value="Senegal">Senegal</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Serbia' ? "selected" : "";
                    endif; ?> value="Serbia">Serbia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Seychelles' ? "selected" : "";
                    endif; ?> value="Seychelles">Seychelles</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Sierra Leone' ? "selected" : "";
                    endif; ?> value="Sierra Leone">Sierra Leone</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Singapore' ? "selected" : "";
                    endif; ?> value="Singapore">Singapore</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Slovakia' ? "selected" : "";
                    endif; ?> value="Slovakia">Slovakia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Slovenia' ? "selected" : "";
                    endif; ?> value="Slovenia">Slovenia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Solomon Islands' ? "selected" : "";
                    endif; ?> value="Solomon Islands">Solomon Islands</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Somalia' ? "selected" : "";
                    endif; ?> value="Somalia">Somalia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'South Africa' ? "selected" : "";
                    endif; ?> value="South Africa">South Africa</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Spain' ? "selected" : "";
                    endif; ?> value="Spain">Spain</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Sri Lanka' ? "selected" : "";
                    endif; ?> value="Sri Lanka">Sri Lanka</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Sudan' ? "selected" : "";
                    endif; ?> value="Sudan">Sudan</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Suriname' ? "selected" : "";
                    endif; ?> value="Suriname">Suriname</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Swaziland' ? "selected" : "";
                    endif; ?> value="Swaziland">Swaziland</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Sweden' ? "selected" : "";
                    endif; ?> value="Sweden">Sweden</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Switzerland' ? "selected" : "";
                    endif; ?>value="Switzerland">Switzerland</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Syria' ? "selected" : "";
                    endif; ?> value="Syria">Syria</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Tahiti' ? "selected" : "";
                    endif; ?> value="Tahiti">Tahiti</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Taiwan' ? "selected" : "";
                    endif; ?> value="Taiwan">Taiwan</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Tajikistan' ? "selected" : "";
                    endif; ?> value="Tajikistan">Tajikistan</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Tanzania' ? "selected" : "";
                    endif; ?> value="Tanzania">Tanzania</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Thailand' ? "selected" : "";
                    endif; ?> value="Thailand">Thailand</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Togo' ? "selected" : "";
                    endif; ?> value="Togo">Togo</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Tokelau' ? "selected" : "";
                    endif; ?> value="Tokelau">Tokelau</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Tonga' ? "selected" : "";
                    endif; ?> value="Tonga">Tonga</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Trinidad' ? "selected" : "";
                    endif; ?> value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Tunisia' ? "selected" : "";
                    endif; ?> value="Tunisia">Tunisia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Turkey' ? "selected" : "";
                    endif; ?> value="Turkey">Turkey</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Turkmenistan' ? "selected" : "";
                    endif; ?> value="Turkmenistan">Turkmenistan</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Turks' ? "selected" : "";
                    endif; ?> value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Tuvalu' ? "selected" : "";
                    endif; ?> value="Tuvalu">Tuvalu</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Uganda' ? "selected" : "";
                    endif; ?> value="Uganda">Uganda</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Ukraine' ? "selected" : "";
                    endif; ?> value="Ukraine">Ukraine</option>
                    <option <?php if(isset($country)):
                        echo $country== 'United Arab Erimates' ? "selected" : "";
                    endif; ?> value="United Arab Erimates">United Arab Emirates</option>
                    <option <?php if(isset($country)):
                        echo $country== 'United Kingdom' ? "selected" : "";
                    endif; ?> value="United Kingdom">United Kingdom</option>
                    <option <?php if(isset($country)):
                        echo $country== 'United States of America' ? "selected" : "";
                    endif; ?> value="United States of America">United States of America</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Uraguay' ? "selected" : "";
                    endif; ?>  value="Uraguay">Uruguay</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Uzbekistan' ? "selected" : "";
                    endif; ?> value="Uzbekistan">Uzbekistan</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Vanuatu' ? "selected" : "";
                    endif; ?> value="Vanuatu">Vanuatu</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Vatican City State' ? "selected" : "";
                    endif; ?> value="Vatican City State">Vatican City State</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Venezuela' ? "selected" : "";
                    endif; ?> value="Venezuela">Venezuela</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Vietnam' ? "selected" : "";
                    endif; ?> value="Vietnam" >Vietnam</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Virgin Islands (Brit)' ? "selected" : "";
                    endif; ?> value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Virgin Islands (USA)' ? "selected" : "";
                    endif; ?> value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Wake Island' ? "selected" : "";
                    endif; ?> value="Wake Island">Wake Island</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Wallis' ? "selected" : "";
                    endif; ?> value="Wallis">Wallis</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Yemen' ? "selected" : "";
                    endif; ?> value="Yemen">Yemen</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Zaire' ? "selected" : "";
                    endif; ?> value="Zaire">Zaire</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Argentina' ? "selected" : "";
                    endif; ?> value="Zambia">Zambia</option>
                    <option <?php if(isset($country)):
                        echo $country== 'Zimbabwe' ? "selected" : "";
                    endif; ?> value="Zimbabwe">Zimbabwe</option>
                    </select>
                     <span style="color:red"><?php echo isset($countryError) ? $countryError : ''; ?></span>
            </div>
           
        </div> <!-- /.form-group -->
         <div class="form-group">
            <label for="upload" class="col-sm-3 control-label">Upload</label>
            <div class="col-sm-9">
               <input class="form-control" type="file" name="upload" id="upload" value="<?php echo 1; ?>" >
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