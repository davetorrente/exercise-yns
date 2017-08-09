<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>html_php-1-1</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
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
                        </tr>
                        </thead>
                        <tbody>
                        <?php $row = 1; ?>
                        <?php $count = 0; ?>
                        <?php if (($handle = fopen("test.csv", "r")) !== FALSE): ?>
                            <?php  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE): ?>
                                <?php $count++; ?>
                                <tr>
                                    <?php $num = count($data); ?>
                                    <?php $row++; ?>
                                    <?php for ($c=0; $c < $num; $c++): ?>
                                        <td><?php echo $data[$c]; ?></td>
                                    <?php endfor ?>
                                </tr>
                            <?php endwhile ?>
                            <?php fclose($handle); ?>
                        <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
</body>
</html>