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
                    <label for="input_number">Enter a number:</label>
                    <input class="form-control" type="number" name="input_number" id="input_number">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="button" name="answer" id="answer" onclick="printnumbers()">Calculate</button>
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

    function checkprimenumber(n){
        for(c=2; c<=n - 1; c++){
            if (n%c === 0){
                return false;
            }
            return true;
        }
    }

    function printprimenumber(number){
        if(checkprimenumber(number) == true){
            document.write(number+" is Prime Number <br />");
        }else{
            /*document.write(number+" is Not Prime Number");*/
        }
    }

    function printnumbers(range){
        for (i=1; i<=range; i++){
            printprimenumber(i);
        }
    }

    var maxnumber = parseInt(document.getElementById('input_number').value);
    printnumbers(maxnumber);

</script>
</body>
</html>

