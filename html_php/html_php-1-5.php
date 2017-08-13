<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>html_php-1-5</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<?php
if(isset($_POST['answer']))
{
    $answer = '';
    $inputDate = $_POST['event_startDate'];
    $answer = date('Y-m-d', strtotime($inputDate . ' +3 day'));
    $day = date("l", strtotime($inputDate . ' +3 day' ));

}
?>
<div class="container ">
    <br/>
    <br/>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form class="form-group" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                    <label for="Date">Input Date:</label>
                    <input class="form-control" type="date" name="event_startDate" id="event_startDate">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit" name="answer" id="answer">Calculate</button>
                </div>
            </form>
            <h2><?php echo !empty($answer) ? 'Three days after is : ' .$answer : ''; ?></h2>
            <h2><?php echo isset($day) ? 'It is ' . $day : ''; ?></h2>
        </div>
    </div>
</div>
</body>
</html>

