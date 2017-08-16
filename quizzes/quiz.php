<?php
session_start();
require "Database.php";
$database = new Database();
$database->query('SELECT questions.id, question, answer1, answer2, answer3, answer FROM questions INNER JOIN answers ON questions.id = answers.question_id ORDER by questions.id ASC' );
$questions = $database->resultset();
$questionIDs = array();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>PHP Quiz</title>
    <link rel="stylesheet" type="text/css" href="css/quiz.css" />
    <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic' rel='stylesheet' type='text/css'>
</head>
<body>
<div id="page-wrap">
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
        <input type="submit" value="Submit Quiz" id="submit-quiz" />
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

