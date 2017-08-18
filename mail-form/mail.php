<?php
require_once 'libs/phpmailer/PHPMailerAutoload.php';
if(isset($_POST['contact-us']))
{
    $error = 0;
    $username = htmlspecialchars($_POST["username"]);
    $email= htmlspecialchars($_POST["email"]);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST['message']);
    if(empty($username)) {
        $usernameError = ' <div class="alert alert-danger custom-alert" style="display:block">
                                       Username is required
                            </div>';
        $error++;
    }else {
        if(!ctype_alnum($username))
        {
            $usernameError = ' <div class="alert alert-danger custom-alert" style="display:block">
                                       Username must be alphanumeric characters
                                </div>';
            $error++;
        }else{
            if(strlen($username) <= '6') {
                $usernameError = '<div class="alert alert-danger custom-alert" style="display:block">
                                      Your Username Must Contain At Least 6 Characters!
                                </div>';
                $error++;
            }
        }
    }
    if (empty($email)) {
        $emailError = ' <div class="alert alert-danger custom-alert" style="display:block">
                                       Email is required
                                </div>';
        $error++;
    }else {
        $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
        if (!preg_match($regex, $email)) {
            $emailError = ' <div class="alert alert-danger custom-alert" style="display:block">
                                      Email is invalid
                                </div>';
            $error++;
        }
    }
    if (empty($subject)) {
        $subjectError = ' <div class="alert alert-danger custom-alert" style="display:block">
                                       Subject is required
                                </div>';
        $error++;
    }
    if (empty($message)) {
        $messageError = '<div class="alert alert-danger custom-alert" style="display:block">
                                     Message is required
                                </div>';
        $error++;
    }else{
        if(strlen($message) <= 10 )
        {
            $messageError = ' <div class="alert alert-danger custom-alert" style="display:block">
                                    "Your Message Must Contain At Least 10 Characters!
                                </div>';
            $error++;
        }
    }
    if($error == 0)
    {
        $m= new PHPMailer;
        $m->isSMTP();
        $m->SMTPAuth=true;
        $m->Host='smtp.gmail.com';
        $m->Username='email.dummy009@gmail.com';//replace with your email address
        $m->Password='Davepogi0#';//replace with your password
        $m->SMTPSecure='ssl';
        $m->Port=465;

        $m->isHTML();
        $m->Subject = $subject;
        $m->Body='From:'.$username.'('.$email.')<p>'.$message.'</p>';

        $m->FromName='Contact';
        $m->AddAddress('email.dummy009@gmail.com','Some one');
        if ($m->send()) {
            $thankMessage = "<p id='hideMe' class='alert-success text-center'>Thanks, we have your message and will reply soon.</p>";
            $username = "";
            $email= "";
            $subject = "";
            $message = "";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mail Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<div class="container">
    <h4 class="text-center">Contact Us</h4>
    <form action="" class="contact-form" method="POST">
        <?php echo isset($thankMessage) ? $thankMessage : ''; ?>
        <div class="form-group">
            <input type="text" name="username" id="username" class="username form-control" placeholder="Your Username"  value="<?php echo isset($username) ? $username : ''; ?>" autofocus>
            <i class="fa fa-user"></i>
            <span class="asterix">*</span>
            <span class="cross">x</span>
            <span class="verify"><i class="fa fa-check" aria-hidden="true"></i></span>
            <?php echo isset($usernameError) ? $usernameError : ''; ?>
        </div>

        <div class="form-group">
            <input type="text" name="email" class=" email form-control" placeholder="Your Email"  value="<?php echo isset($email) ? $email : ''; ?>">
            <i class="fa fa-envelope"></i>
            <span class="asterix">*</span>
            <span class="cross">x</span>
            <span class="verify"><i class="fa fa-check" aria-hidden="true"></i></span>
            <?php echo isset($emailError) ? $emailError : ''; ?>
        </div>


        <div class="form-group">
            <input type="text" name="subject" class="subject form-control" placeholder="Your subject" value="<?php echo isset($subject) ? $subject : ''; ?>">
            <i class="fa fa-pencil"></i>
            <span class="asterix">*</span>
            <span class="cross">x</span>
            <span class="verify"><i class="fa fa-check" aria-hidden="true"></i></span>
            <?php echo isset($subjectError) ? $subjectError : ''; ?>
        </div>


        <div class="form-group">
            <textarea class=" message form-control" name="message"><?php echo isset($message) ? $message : ''; ?></textarea>
            <i class="fa fa-comments message-icon"></i>
            <span class="asterix">*</span>
            <span class="cross">x</span>
            <span class="verify"><i class="fa fa-check" aria-hidden="true"></i></span>
            <?php echo isset($messageError) ? $messageError : ''; ?>
        </div>
        <div class="form-group">
            <input type="submit" name="contact-us" value="send" class="btn btn-success btn-block">
            <i class="fa fa-paper-plane send-icon"></i>
        </div>
    </form>
</div>
</body>
<script src="http://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</html>
