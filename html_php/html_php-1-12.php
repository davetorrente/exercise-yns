<?php
session_start();
if (!isset($_SESSION['user']))
    header("Location: html_php-1-13.php");
if(isset($_GET['logout']) == 1){
    session_destroy();
    header("Location: html_php-1-13.php");
}

$count = 0;
if (($handle = fopen("test.csv", "r")) !== FALSE):
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE):
        $count++;
    endwhile ;
    fclose($handle);
endif;

$page = '';
if(isset($_GET['page']))
{
    $page = $_GET['page'];
    if($page=='' || $page == 1)
    {
        $page = 1;
    }
    else{
        $page = $page*10 -10 +1;
    }
}
else{
    $page = 1;
}
$endpage   = $page+10-1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>html_php-1-12</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/custom.css" type="text/css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigatipon</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">List Page</a>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="?logout=1">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>Welcome <?php if (isset($_SESSION['user'])) {
                echo $_SESSION['user'];
                }?></h1>
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
                        <?php
                        $row = 1;
                        if (($handle = fopen("test.csv", "r")) !== FALSE): ?>
                            <?php  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE): ?>
                                <?php $num = count($data); ?>
                                <tr>
                                    <?php if($page == $row): ?>
                                        <?php for ($c=0; $c < $num; $c++): ?>
                                            <td><?php echo htmlspecialchars($data[$c]); ?></td>
                                        <?php endfor ?>
                                        <?php if($page == $endpage):
                                            break;
                                        endif ?>
                                        <?php $page++ ?>
                                    <?php endif ?>
                                </tr>
                                <?php $row++; ?>
                            <?php endwhile ?>
                            <?php fclose($handle); ?>
                        <?php endif ?>
                        </tbody>
                    </table>

                </div>
                <?php $page = $count / 10; ?>
                <?php $b =  ceil($page); ?>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col col-xs-4">Page 1 of <?php echo $b; ?>
                        </div>
                        <div class="col col-xs-8">
                            <ul class="pagination hidden-xs pull-right">
                                <?php for($i=1; $i<=$b; $i++): ?>
                                    <li><a href="html_php-1-12.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                <?php endfor ?>
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