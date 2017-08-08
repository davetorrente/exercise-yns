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
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">User Information</h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                        <tr>
                            <th class="hidden-xs">ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Gender</th>
                            <th>Country</th>
                            <th>Profile Pic</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $row = 1; ?>
                        <?php if (($handle = fopen("test.csv", "r")) !== FALSE): ?>
                            <?php  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE): ?>
                                <tr>
                                    <?php $num = count($data); ?>
                                    <?php $row++; ?>
                                    <?php for ($c=0; $c < $num; $c++): ?>
                                        <?php if($c==6): ?>
                                            <td><img src="/profile-img/<?php echo $data[$c]; ?>" class="img-responsive img-profile"></td>
                                        <?php else: ?>

                                            <td><?php echo $data[$c]; ?></td>
                                        <?php endif ?>


                                    <?php endfor ?>
                                </tr>
                            <?php endwhile ?>
                            <?php fclose($handle); ?>
                        <?php endif ?>

                        </tbody>
                    </table>

                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col col-xs-4">Page 1 of 5
                        </div>
                        <div class="col col-xs-8">
                            <ul class="pagination hidden-xs pull-right">
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                            </ul>
                            <ul class="pagination visible-xs pull-right">
                                <li><a href="#">«</a></li>
                                <li><a href="#">»</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</body>
</html>