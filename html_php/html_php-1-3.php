<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>html_php-1-3</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<?php
if(isset($_POST['answer']))
{
    $error = 0;
    $first_num = htmlspecialchars($_POST['first_num']);
    $checkSecond = htmlspecialchars($_POST['second_num']);
    $second_num = $checkSecond;
    $remainder = 0;
    $tmp = 0;
    $answer;
    if(empty($first_num) && empty($second_num))
    {
        $first_numErr = 'Please input a number';
        $second_numErr = 'Please input a number';
        $error++;
    }
    else if(empty($first_num) && !empty($second_num))
    {
        $first_numErr = 'Please input a number';
        $error++;
    }
    else if(!empty($first_num) && empty($second_num))
    {
        $second_numErr = 'Please input a number';
        $error++;
    }
    if($error == 0)
    {
        while ($second_num !=0)
        {
            $remainder = $first_num % $second_num;
            $tmp = $second_num;
            $second_num = $remainder;
            $first_num = $tmp;
            $answer = $tmp;
        }
    }


}
?>
<div class="container ">
    <br/>
    <br/>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
             <h3>Find the GCD of two numbers</h3>
            <form class="form-group" method="post" action="<?php htmlentities($_SERVER['PHP_SELF']); ?>">
                <div class="form-group">
                    <label for="first_number">First Number:</label>
                    <input class="form-control" type="number" name="first_num" id="first_num" value="<?php echo isset($first_num) ? $first_num : ''; ?>">
                    <span style="color:red"><?php echo isset($first_numErr) ? $first_numErr : ''; ?></span>
                </div>
                <div class="form-group">
                    <label for="second_number">Second Number:</label>
                    <input class="form-control" type="number" name="second_num" id="second_num" value="<?php echo isset($checkSecond) ? $checkSecond : ''; ?>">
                    <span style="color:red"><?php echo isset($second_numErr) ? $second_numErr : ''; ?></span>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit" name="answer" id="answer">Calculate</button>
                </div>
            </form>
            <h2><?php echo isset($answer) ? 'The GCD is: ' .$answer : ''; ?></h2>
        </div>
    </div>
</div>
</body>
</html>

