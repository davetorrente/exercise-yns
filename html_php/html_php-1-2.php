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
    $first_num = $_POST['first_num'];
    $second_num = $_POST['second_num'];
    $default = '';
    $answer;
    if(isset($_POST["operation"]))
    {
        $operation  = $_POST["operation"];
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
?>
<div class="container ">
    <br/>
    <br/>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form class="form-group" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="form-group">
                    <label for="first_number">First Number:</label>
                    <input class="form-control" type="number" name="first_num" id="first_num">
                </div>
                <div class="form-group">
                    <label for="second_number">Second Number:</label>
                    <input class="form-control" type="number" name="second_num" id="second_num">
                </div>
                <div class="form-group">
                    <label for="sel1">Arithmetic Operation:</label>
                    <select class="form-control" name="operation" id="operation">
                        <option name="" value="selected">Select Operation</option>
                        <option value="Add">Add</option>
                        <option value="Subtract">Subtract</option>
                        <option value="Multiply">Multiply</option>
                        <option value="Divide">Divide</option>
                    </select>
                    <h4><?php echo isset($default) ? $default : ''; ?></h4>
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

