<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>html_php-1-1</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>
<body>
<div class="container" style="top: 20%; position: absolute;">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h3>FizzBuzz</h3>
        <form class="form-group" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
            <div class="form-group">
                <label for="input_num">Input a number:</label>
                <input class="form-control" type="number" name="input_num" id="input_num">
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit" name="answer" id="answer">Calculate</button>
            </div>
        </form>
            <?php
            if(isset($_POST['answer']))
            {
                $input_num = $_POST['input_num'];
                for($i=1; $i<=$input_num; $i++)
                {
                    if($i % 15 == 0)
                    {
                        echo "FizzBuzz" . " ";
                    }
                    else if($i % 3 == 0)
                    {
                        echo "Fizz" . " ";
                    }
                    else if($i % 5 == 0)
                    {
                        echo"Buzz" . " ";
                    }
                    else {
                        echo $i . " ";
                    }
                }
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>