<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>html_php-1-2</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div class="container ">
    <br/>
    <br/>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form class="form-group" method="post" action="">
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
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="button" name="answer" id="answer" onclick="arithmetic()">Calculate</button>
                </div>
            </form>
            <p id="showresult"></p>
        </div>
    </div>
</div>
<script src="http://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script>
   function arithmetic()
   {
      var first_num = parseInt(document.getElementById('first_num').value);
      var second_num = parseInt(document.getElementById('second_num').value);
      var answer = null;
       if(first_num === '' || second_num === '')
       {
           alert("Invalid");
       }
       var operation = document.getElementById('operation').value;
       switch(operation) {
           case "Add":
               answer = first_num + second_num;
               break;
           case "Subtract":
               answer = first_num - second_num;
               break;
           case "Multiply":
               answer = first_num * second_num;
               break;
           case "Divide":
               answer = first_num / second_num;
               break;
           default:
               alert("Please select your desired operation");
       }
       document.getElementById('showresult').textContent = "The answer is: "+ answer;

   }
</script>
</body>
</html>

