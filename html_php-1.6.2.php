<?php

$username = $_GET['username'];
$email = $_GET['email'];
$description = $_GET['description'];
$country =  $_GET['country'];
$gender = $_GET['gender'];
$phone = $_GET['phone'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>html_php-1-1</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/custom.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-offset-2 col-md-8 col-lg-offset-3 col-lg-6">
            <div class="well profile">
                <div class="col-sm-12">
                    <div class="col-xs-12 col-sm-8">
                        <h2><?php echo isset($username) ? $username : ''; ?></h2>
                        <p><strong>Email: </strong> <?php echo isset($email) ? $email : ''; ?></p>
                        <p><strong>Description: </strong> <?php echo isset($description) ? $description : ''; ?></p>
                        <p><strong>Phone: </strong> <?php echo isset($phone) ? $phone : ''; ?></p>
                        <p><strong>Gender: </strong><?php echo isset($gender) ? $gender : ''; ?>
                        </p>
                        <p><strong>Country: </strong> <?php echo isset($country) ? $country : ''; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>