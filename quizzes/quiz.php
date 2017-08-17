<?php
session_start();

require "Database.php";
$database = new Database();
$database->query('SELECT questions.id, question, answer1, answer2, answer3, answer FROM questions INNER JOIN answers ON questions.id = answers.question_id ORDER by questions.id ASC' );
$questions = $database->resultset();

if (isset($_SESSION['quizUser'])) {
    $username = $_SESSION["quizUser"];
    $database->query("SELECT * FROM users WHERE username = '$username'");
    $user = $database->resultset();
    $userID = $user[0]['id'];
    $_SESSION["userID"] = $userID;
}else{
    header("Location: quiz-login.php");
}
if(isset($_GET['logout']) == 1){
    session_destroy();
    header("Location: quiz-login.php");
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>PHP Quiz</title>
    <link rel="stylesheet" type="text/css" href="css/quiz.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic' rel='stylesheet' type='text/css'>

</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container" id="navbar-quiz">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigatipon</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="quiz.php">QUIZ PHP</a>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="quiz.php">Home</a></li>
                    <li><a href="?logout=1"> <img src="<?php echo $user[0]['upload'];?>" class="profile-image img-circle"> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

<div class="container" id="page-wrap">
    <form action="grade.php" method="post" id="quiz" novalidate>
        <ul id="test-questions">
            <?php $totalquestions = count($questions);?>
        <?php for($i=0; $i<$totalquestions; $i++): ?>
        <li>
        <div class="quiz-overlay"></div>
        <h3><?php echo $questions[$i]['question']; ?></h3>
               <div class="mtm" data="">
                       <input type="radio" name="question-<?php echo $i+1; ?>-answers" id="question-<?php echo $i+1; ?>-answers-A" value="<?php echo $questions[$i]['answer1'] ?>"/>
                       <label for="question-<?php echo $i+1; ?>-answers-A" class="fwrd labela">a.  <?php echo $questions[$i]['answer1'] ?></label>
               </div>
                <div class="mtm">
                    <input type="radio" name="question-<?php echo $i+1; ?>-answers" id="question-<?php echo $i+1; ?>-answers-B" value="<?php echo $questions[$i]['answer2'] ?>"/>
                    <label for="question-<?php echo $i+1; ?>-answers-B" class="fwrd labelb">b.  <?php echo $questions[$i]['answer2'] ?></label>
                </div>
                <div class="mtm">
                    <input type="radio" name="question-<?php echo $i+1; ?>-answers" id="question-<?php echo $i+1; ?>-answers-C" value="<?php echo $questions[$i]['answer3'] ?>"/>
                    <label for="question-<?php echo $i+1; ?>-answers-C" class="fwrd labelc">c.  <?php echo $questions[$i]['answer3'] ?></label>
                </div>
                 <p class="quiz-progress"><?php echo ($i+1); ?> of <?php echo $totalquestions; ?></p>
        </li>
        <?php endfor ?>
        </ul>
        <input type="submit" value="Submit Quiz" name="submit-quiz" id="submit-quiz" />
    </form>
    <div class="nomargin"></div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script>
<script>
    (function($) {
        var timeout= null;
        var $mt = 0;
        $("#quiz .fwrd").on('click',function(){
            clearTimeout(timeout);
            timeout = setTimeout(function(){
                $mt = $mt - 430;
                $("#test-questions").css("margin-top", $mt);
            }, 333);
        });
    }(jQuery))
</script>
</body>
</html>

