<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calendar</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1 align="center">Practice 5-2: <b> Calendar</b></h1>
        </div>
    </div>

</div>


    <?php
    include 'MyCalendar.php';
    $daysOfWeek = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");

//    echo date('t',strtotime('2017-08-01'));
//    $month = "08";
//    $daysInMonths = '31';
//    $monthEndingDay= date('N',strtotime('2017-08-31'));
//    $monthStartDay= date('N',strtotime('2017-08-01'));
//    echo $monthEndingDay;
//    echo $monthStartDay;
//    $daysOfWeek = array(
    //"Sun","Mon","Tue","Wed","Thu","Fri","Sat");
//    echo count($daysOfWeek);
    $naviHref = htmlentities($_SERVER['PHP_SELF']);
    $calendar = new MyCalendar($naviHref);
    echo $calendar->show();
    ?>
</body>
<script src="http://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</html>