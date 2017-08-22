<?php
require "Database.php";
require "modals/delete-modal.php";
require "modals/edit-modal.php";
$database = new Database();
session_start();
if (!isset($_SESSION['microUser']))
    header("Location: micro-login.php");
if(isset($_GET['logout']) == 1) {
    session_destroy();
    header("Location: micro-login.php");
}

if (isset($_SESSION['microUser'])) {
    $userAuth = $_SESSION['microUser'];
    $database->query("SELECT * FROM users WHERE username = '$userAuth'");
    $user = $database->resultset();
}
$database->query("SELECT users.username, users.upload, tweets.id, tweets.user_id, tweets.tweet, tweets.created, tweets.modified FROM users INNER JOIN tweets ON users.id = tweets.user_id ORDER BY tweets.modified DESC");
$userTweets = $database->resultset();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Micro Blog</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
    <link rel="stylesheet" href="css/dashboard.css">
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
        <a class="navbar-brand" href="microblog.php">Micro Blog</a>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="active"><a href="microblog.php">Home</a></li>
                <li><a href="micro-profile.php?username=<?php echo $user[0]['username'];?>"><img src="<?php echo $user[0]['upload'];?>" class="nav-profile img-circle"> Profile</a></li>
                <li><a href="?logout=1">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container" id="mainDiv">
<section class="row sectionUser">
    <div class="col-md-4 col-md-offset-4">
        <div class="alert" id="alertMessage" style="display: none;"></div>
        <!-- Say Hi to the User by User Authentication -->
        <h3>Hi <?php echo $user[0]['username']; ?>.
        </h3>
        <form id="createTweet" method="post">
            <div class="form-group">
                <textarea class="form-control" name="tweet" id="tweet" rows="3" placeholder="Your Tweet.."></textarea>
<!--                <p style="display: inline-block">Total number of characters: </p><span style="display: inline-block" id="tweetCount">140</span>-->
            </div>
            <div class="form-group">
                <input class="form-control" type="hidden" name="hidden_id" value="<?php echo $user[0]['id'];?>">
            </div>
            <button type="button" class="btn btn-info" name="btnAdd" id="btnAdd">Create Tweet</button>
        </form>
    </div>
</section>

<section class="row section2" >
    <div class="col-md-6 col-md-offset-3" id="showdata">
            <?php foreach($userTweets as $userTweet): ?>
            <article class="post">
                <div class="alert alert-edit" id="alertMessage" style="display: none;"></div>
                <div class="info postByUser">
                    <div class="row">
                        <div class="col-md-2">
                            <a href="micro-profile.php?username=<?php echo $userTweet['username']; ?>"><img src="<?php echo $userTweet['upload'];?>" alt="sample profile pic" class="postImage"></a>
                        </div>
                        <div class="col-md-6 userName">
                            <h4 ><?php echo $userTweet["username"]; ?></h4>
                            <p>Posted on  <?php echo $userTweet['modified']; ?></p>
                        </div>
                    </div>
                </div>
                <p class="contentPost"><?php echo $userTweet['tweet']; ?></p>
                <div class="clearfix"></div>
                <div class="interaction tweet-interact">
                    <a href="javascript:;" class="retweet"><i class="fa fa-retweet" id="iconRetweet" aria-hidden="true"></i> |</a>
                <?php if($user[0]['id'] == $userTweet['user_id']): ?>
                    <a href="javascript:;"  class="tweet-edit" data="<?php echo $userTweet['id'];?>">Edit |</a>
                    <a href="javascript:;" class="tweet-delete" data="<?php echo $userTweet['id'];?>">Delete |</a>
                <?php endif; ?>
                </div>
            </article>
        <?php endforeach ?>
    </div>
</section>
</div>

</body>
</html>
<script src="http://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="js/main.js"></script>
