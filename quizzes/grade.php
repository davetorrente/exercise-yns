<?php
session_start();
require "Database.php";
$database = new Database();
/**
 * Created by PhpStorm.
 * User: YNS
 * Date: 16/08/2017
 * Time: 1:30 PM
 */
$answer = array();

$database->query('SELECT answer FROM answers INNER JOIN questions ON answers.question_id = questions.id ' );
$select = $database->resultset();


$totalCorrect = 0;
$totalCount = 10;

for($i=0; $i<count($_POST); $i++)
{
    if($_POST['question-'.($i+1).'-answers'] == $select[$i]['answer'])
    {
        $totalCorrect++;
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
<body class="bg-for-submit-name">

<div class="container">
    <div class="row">
            <span class="image-position"><a href="https://www.facebook.com/meuix/?ref=settings" target="_blank">
	           <img src="https://lh4.googleusercontent.com/fLEIj3iQb7O1FhjOpLFbJtHmsMlLGmLynSWUvAP70qF0HLEBty-FANvwweg7Sv2XqSpzOKNI=w1366-h638"></a>
	        </span>
    </div>
    <div class="row margin-top">
        <div class="col-md-12">
            <div class="wrap">
                <p class="form-title Arabella">
                   Your Score is <?php echo isset($totalCorrect) ? $totalCorrect . ' out of' . $totalCount : ''; ?>
                </p>
            </div>
        </div>
    </div>
</div>
</body>

</html>



