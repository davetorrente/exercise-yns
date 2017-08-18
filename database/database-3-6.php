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


if(isset($_POST['submit']))
{
    $error = 0;
    if(empty($_POST["post"])) {
        $postError = "Post is required";
        $error++;
    }

    if($error==0)
    {
        $post = htmlspecialchars($_POST['post']);
        $database->query('INSERT INTO posts (post) VALUES(:post)');
        $database->bind(':post',$post);
        $database->execute();
    }
}
if(isset($_POST['delete']))
{
    $delete_id = htmlspecialchars($_POST['delete_id']);
    $database->query('DELETE FROM posts WHERE id = :id');
    $database->bind(':id',$delete_id);
    $database->execute();
}
if(isset($_POST['edit']))
{
    $edit_id = htmlspecialchars($_POST['edit-id']);
    header("Location: database-3-6-edit.php?id=$edit_id");
}


$page = 0;
if(isset($_GET['page']))
{
    $page = $_GET['page'];
    if($page=='' || $page == 1)
    {
        $page1 = 0;
    }else{
        $page1 = $page*10 -10;
    }
}else{
    $page1 = 0;
}
$database->query("SELECT COUNT(*) as totalPost FROM posts ORDER by modified DESC");
$countPosts = $database->resultset();

$database->query("SELECT * FROM posts ORDER by modified DESC LIMIT $page1, 10");
$rows = $database->resultset();

if (isset($_SESSION['authUser'])) {
    $userAuth = $_SESSION['authUser'];
    $database->query("SELECT * FROM users WHERE username = '$userAuth'");
    $user = $database->resultset();
//    print_r($user);
//    die();
}

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
        <div class="container" id="navbar-quiz">
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
                    <li><a href="?logout=1"> <img src="<?php echo $user[0]['upload'];?>" class="profile-image img-circle"> Logout</a></li>
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
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody id ="output">
                              <?php foreach($rows as $row): ?>
                                  <tr>
                                      <td><?php echo htmlspecialchars($row['id']); ?></td>
                                      <td><?php echo htmlspecialchars($row['post']); ?></td>
                                      <td><?php echo htmlspecialchars($row['created']); ?></td>
                                      <td><?php echo htmlspecialchars($row['modified']); ?></td>
                                          <td><div style="display:inline-block">
                                          <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
                                              <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>" />
                                              <input type="submit" name="delete" value="Delete"/>
                                          </form>
                                      </div>

                                      <div style="display:inline-block">
                                          <form method="post" action="">
                                              <input type="hidden" name="edit-id" value="<?php echo $row['id']; ?>" />
                                              <input type="submit" name="edit" value="Edit"/>
                                          </form>
                                      </div>
                                      </td>
                                  </tr>

                            <?php endforeach ?>
                            </tbody>
                        </table>

                    </div>
                    <?php $pages = $countPosts[0]['totalPost'] / 10; ?>
                    <?php $b =  ceil($pages); ?>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col col-xs-4">Page <?php echo $page==0 ? 1 : $page ; ?> of <?php echo $b; ?>
                            </div>
                            <div class="col col-xs-8">
                                <ul class="pagination hidden-xs pull-right">
                                    <?php for($i=1; $i<=$b; $i++): ?>
                                        <li><a href="database-3-6.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
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
<script src="main.js" type="text/javascript"></script>
</html>