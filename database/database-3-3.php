<?php
require "Database.php";
$database = new Database();
$datetime = date('Y-m-d H:i:s');
if(isset($_POST['delete']))
{
    $delete_id = $_POST['delete_id'];
    $database->query('DELETE FROM posts WHERE id = :id');
    $database->bind(':id',$delete_id);
    $database->execute();
}
if(isset($_POST['edit']))
{
      $edit_id = htmlspecialchars($_POST['edit-id']);
      header("Location: database-3-3-edit.php?id=$edit_id");
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
        $database->query('INSERT INTO posts (post, created) VALUES(:post, :created)');
        $database->bind(':post',$post);
        $database->bind(':created',$datetime);
        $database->execute();
    }
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

$pages = $countPosts[0]['totalPost'] / 10;
$b =  ceil($pages);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Database 3-3</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="css/database-3-3.css" type="text/css">

</head>
<body>
<div class="container ">
    <br/>
    <br/>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
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
            <h1>Posts</h1>
            <div>
                <?php
                foreach($rows as $row) :
                    ?>
                    <h3><?php echo $row['post']; ?></h3>
                    <p>Posted on <?php echo $row['modified'] ?></p>
                    <div style="display:inline-block">
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

                    <?php
                endforeach;
                ?>
            </div>
            <?php if(!empty($rows)): ?>
            <div class="panel-footer">
                <div class="row">
                    <div class="col col-xs-4">Page <?php echo $page==0 ? 1 : $page ; ?> of <?php echo $b; ?>
                    </div>
                    <div class="col col-xs-8">
                        <ul class="pagination hidden-xs pull-right">
                            <?php for($i=1; $i<=$b; $i++): ?>
                                <li><a href="database-3-3.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php endfor ?>
                        </ul>
                        <ul class="pagination visible-xs pull-right">
                            <li><a href="#">«</a></li>
                            <li><a href="#">»</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>



<!--</div>-->
</body>
<script src="http://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</html>