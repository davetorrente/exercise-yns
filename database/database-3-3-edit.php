<?php
require "Database.php";

$database = new Database();

$postform = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

$edit_id =  $_GET['id'];
$post = '';
$database->query('SELECT * FROM posts WHERE id = :id' );
$database->bind(':id', $edit_id);
$post = $database->resultset();

if(isset($postform['editsubmit']))
{
    $error = 0;
    if(empty($_POST["editpost"])) {
        $editError = "Edit your post";
        $error++;
    }
    if($error==0) {
        if(isset($_POST['editpost']))
        {
            $editpost = $_POST['editpost'];
            $database->query('UPDATE posts SET post = :post WHERE id = :id');
            $database->bind(':post',$editpost);
            // $database->bind(':modified',$mysql_date_now);
            $database->bind(':id',$edit_id);
            $database->execute();
            $database->query('SELECT * FROM posts WHERE id = :id' );
            $database->bind(':id', $edit_id);
            $post = $database->resultset();
            header("Location: database-3-3.php");
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Database 3-3-edit</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>
<body>
<div class="container ">
    <br/>
    <br/>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form class="form-group" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                    <label for="Date">Edit Post</label>
                    <input class="form-control" name="editpost" id="editpost" value="<?php echo $post[0]['post'];?>"></input>
                    <span style="color:red">  <?php echo isset($editError) ? $editError : ''; ?></span>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit" name="editsubmit" id="editsubmit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--</div>-->
</body>
<script src="http://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script>

</script>
</html>