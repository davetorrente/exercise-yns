<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>html_php-1-2</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<?php
if(isset($_POST['answer']))
{
    $error = 0;
    $first_num = htmlspecialchars($_POST['first_num']);
    $second_num = htmlspecialchars($_POST['second_num']);
    $operation = htmlspecialchars($_POST["operation"]);
    $answer;
    $default = '';
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
    if($operation == 'selected')
    {
        $operationErr = 'Please select a operation';
        $error++;
    }
    if($error == 0)
    {
        if(isset($operation))
        {
            switch ($operation) {
                case 'Add':
                    $answer = $first_num + $second_num;
                    break;
                case 'Subtract':
                    $answer = $first_num - $second_num;
                    break;
                case 'Multiply':
                    $answer = $first_num * $second_num;
                    break;
                case 'Divide':
                    $answer = $first_num / $second_num;
                    break;

                default:
                    $default = "Please select your operation";
                    break;
            }
        }
    }
}
?>
<div class="container ">
    <br/>
    <br/>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form class="form-group" method="post" action="<?php echo htmlentities($_SERVER["PHP_SELF"]);?>">
                <div class="form-group">
                    <label for="first_number">First Number:</label>
                    <input class="form-control" type="number" name="first_num" id="first_num" value="<?php echo isset($first_num) ? $first_num : ''; ?>">
                    <span style="color:red"><?php echo isset($first_numErr) ? $first_numErr : ''; ?></span>
                </div>
                <div class="form-group">
                    <label for="second_number">Second Number:</label>
                    <input class="form-control" type="number" name="second_num" id="second_num" value="<?php echo isset($second_num) ? $second_num : ''; ?>">
                    <span style="color:red"><?php echo isset($second_numErr) ? $second_numErr : ''; ?></span>
                </div>
                <div class="form-group">
                    <label for="sel1">Arithmetic Operation:</label>
                    <select class="form-control" name="operation" id="operation">
                        </option>
                        <option name="" value="selected">Select Operation</option>
                        <option <?php if(isset($operation)):
                            echo $operation == 'Add' ? "selected" : "";
                        endif; ?> value="Add">Add</option>
                        <option <?php if(isset($operation)):
                            echo $operation == 'Subtract' ? "selected" : "";
                        endif; ?> value="Subtract">Subtract</option>
                        <option <?php if(isset($operation)):
                            echo $operation == 'Multiply' ? "selected" : "";
                        endif; ?> value="Multiply">Multiply</option>
                        <option <?php if(isset($operation)):
                            echo $operation == 'Divide' ? "selected" : "";
                        endif; ?> value="Divide">Divide</option>
                    </select>
                    <span style="color:red"><?php echo isset($operationErr) ? $operationErr : ''; ?></span>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit" name="answer" id="answer">Calculate</button>
                </div>
            </form>
            <h2><?php echo isset($answer) ? 'The answer is: ' .$answer : ''; ?></h2>
        </div>
    </div>
</div>
</body>
</html>

