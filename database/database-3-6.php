<?php
require "Database.php";
$database = new Database();
session_start();
if (!isset($_SESSION['authUser']))
    header("Location: database-3-6-login.php");
if(isset($_GET['logout']) == 1){
    session_destroy();
    header("Location: database-3-6.php");
}
$postform = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

if(isset($_POST['delete']))
{
    $delete_id = $_POST['delete_id'];
    $database->query('DELETE FROM posts WHERE id = :id');
    $database->bind(':id',$delete_id);
    $database->execute();
}
if(isset($_POST['edit']))
{
    $edit_id = $_POST['edit-id'];
    header("Location: database-3-3-edit.php?id=$edit_id");
}


if(isset($postform['submit']))
{
    $error = 0;
    if(empty($_POST["post"])) {
        $postError = "Post is required";
        $error++;
    }
    else {
        if(!ctype_alnum($_POST["post"]))
        {
            $postError = "Name must be alphanumeric characters";
            $error++;
        }
    }
    if($error==0)
    {
        $post = $postform['post'];
        $database->query('INSERT INTO posts (post) VALUES(:post)');
        $database->bind(':post',$post);

        $database->execute();
        if($database->lastInsertId())
        {
            echo 'SUCCESS!';
        }
    }
}

$database->query('SELECT * FROM posts ORDER by modified DESC ');
$rows = $database->resultset();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>database login</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="css/dashboard.css" rel="stylesheet">

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
            <a class="navbar-brand" href="">Database Implementation</a>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="database-3-6.php">Home</a></li>
                    <li><a href="?logout=1"> <img src="profile-img/sample.jpg" class="profile-image img-circle"> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container ">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h3>Welcome <?php if (isset($_SESSION['authUser'])) {
                        echo $_SESSION['authUser'];
                    }?></h3>
                <form class="form-group" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
                    <div class="form-group">
                        <label for="Date">Add Post</label>
                        <textarea class="form-control" name="post" id="post" rows="3" placeholder="What's on your mind.."></textarea>
                        <span style="color:red">  <?php echo isset($postError) ? $postError : ''; ?></span>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit" name="submit" id="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Add Post-->
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col col-xs-6">
                                <h3 class="panel-title">Posts</h3>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-list">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Post</th>
                                <th>Created</th>
                                <th>Modified</th>
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
                                                <td><?php echo $data[$c]; ?></td>
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
<script src="http://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</html>