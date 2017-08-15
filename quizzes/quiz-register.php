<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>html_php-1-1</title>
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
                <h4 class="text-center">Register as a New Quizzer</h4>
                <form class="form-horizontal">
                    <div class="form-group has-success has-feedback">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="inputSuccess" placeholder="Username">
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group has-success has-feedback">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="inputSuccess" placeholder="Email">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group has-success has-feedback">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="inputSuccess" placeholder="Password">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="form-group has-success has-feedback">
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="inputSuccess" placeholder="Confirm Password">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-success">Submit</button>
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