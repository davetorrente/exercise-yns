<?php
session_start();
require "Database.php";
$database = new Database();

$datetime = date('Y-m-d H:i:s');
if(isset($_POST['submit-quiz'])) {
    $totalCorrect = 0;
    $totalCount = 10;
    $database->query('SELECT answer FROM answers INNER JOIN questions ON answers.question_id = questions.id ' );
    $select = $database->resultset();

    for($i=0; $i<count($_POST)-1; $i++)
    {
        if($_POST['question-'.($i+1).'-answers'] == $select[$i]['answer'])
        {
            $totalCorrect++;
        }

    }

    $user_id = $_SESSION["userID"];
    $database->query("SELECT user_id FROM grades WHERE user_id = '$user_id'");
    $userID = $database->resultset();
    if(!empty($userID)){
        $database->query('UPDATE grades SET score = :score WHERE user_id = :id');
        $database->bind(':score',$totalCorrect);
        $database->bind(':id',$user_id);
        $database->execute();
    }else{
        $database->query("INSERT INTO grades (user_id, score, created) VALUES(:user_id, :score, :created)");
        $database->bind(':user_id', $user_id);
        $database->bind(':score',$totalCorrect);
        $database->bind(':created',$datetime);
        $database->execute();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>PHP Quiz</title>
    <link rel="stylesheet" type="text/css" href="css/result.css" />
    <link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic' rel='stylesheet' type='text/css'>
</head>
<body>

<div class="container">
    <div class="row margin-top">
        <div class="col-md-12">
            <div>
                <p class="form-title Arabella">
                   Your Score is <?php echo isset($totalCorrect) ? $totalCorrect . ' out of' . $totalCount : ''; ?>

                </p>
                <p class="form-title Arabella"><button type="submit" class="btn btn-success"  name="exit-button" id="exit-button" style="width:auto">EXIT</button></p>
            </div>
        </div>
    </div>
</div>
</body>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" ></script>
<script>
    $(document).ready(function(){
       $("#exit-button").on('click',function(e){
           e.preventDefault();
           location.href = '/quizzes/quiz.php';
       });
    });
</script>
</html>



