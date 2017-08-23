<?php
//a
require "Database.php";
require "modals/delete-modal.php";
require "modals/edit-modal.php";
require "modals/retweet-modal.php";
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
if(isset($_GET['username'])){
    $userProfile= $_GET['username'];
    $database->query("SELECT * FROM users where username='$userProfile'");
    $userInfos = $database->resultset();
    $database->query("SELECT users.username, users.upload, tweets.id, tweets.user_id, tweets.tweet, tweets.created, tweets.modified, tweets.isRetweet  FROM users INNER JOIN tweets ON users.id = tweets.user_id WHERE users.username='$userProfile' ORDER BY tweets.modified DESC ");
    $profileTweets = $database->resultset();
}
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
                <li><a href="microblog.php">Home</a></li>
                <li class="active"><a href="micro-profile.php?username=<?php echo $userInfos[0]['username'];?>"><img src="<?php echo $userInfos[0]['upload'];?>" class="nav-profile img-circle"> Profile</a></li>
                <li><a href="?logout=1">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="row profile-div">
    <div class="col-md-3">
        <div class="profile-pic">
            <img src="<?php echo $userInfos[0]['upload'];?>" alt="sample profile pic" class="img-thumbnail img-profile">
        </div>
        <p>Lorem ipsum dolor sit amet, eos aeque eirmod tamquam eu, per vidisse ullamcorper ne, omnes eirmod reprimique sea ex. Usu cu consul tempor, vix ad simul dolores adipisci.</p>
    </div>
    <div class="col-md-9">
        <h1 class="samplePosts">
            <!-- If it is the logged in user, it will display "Your Profile" -->
            <?php if($userInfos[0]['username'] == $_SESSION['microUser']): ?>
                Your Profile
                <!-- If it is not the logged in user, it will display username's Profile -->
            <?php else: ?>
                <?php echo $userInfos['0']['username'] . "'s" . " Profile"; ?>
            <?php endif; ?>
        </h1>
        <section class="row sectionUser">
            <div class="col-md-6 col-md-offset-3">
                <div class="alert" id="alertMessage" style="display: none;"></div>
                <?php if($userInfos[0]['username'] == $_SESSION['microUser']): ?>
                    <form id="createTweet" method="post">
                        <div class="form-group">
                            <textarea class="form-control" name="tweet" id="tweet" rows="3" placeholder="Your Tweet.."></textarea>
                            <!--                <p style="display: inline-block">Total number of characters: </p><span style="display: inline-block" id="tweetCount">140</span>-->
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="hidden" name="hidden_id" value="<?php echo $userInfos[0]['id'] ;?>">
                        </div>
                        <button type="button" class="btn btn-info" name="btnAdd" id="btnAdd">Create Tweet</button>
                    </form>
                <?php endif; ?>
            </div>
        </section>
        <section class="row">
            <div class="col-md-6 col-md-offset-3" id="showdata">
                <div class="alert" id="alertMessage" style="display: none;"></div>
                <?php foreach($profileTweets as $profileTweet): ?>
                    <article class="post">
                        <div class="info postByUser">
                            <div class="row">
                                <div class="col-md-2">
                                    <a href="micro-profile.php?username=<?php echo $profileTweet['username']; ?>"> <img src="<?php echo $profileTweet['upload'];?>" alt="sample profile pic" class="postImage"></a>
                                </div>
                                <div class="col-md-6 userName">
                                    <h4><?php echo $profileTweet["username"]?></h4>
                                    <p>Posted on  <?php echo $profileTweet['created']; ?></p>
                                </div>
                            </div>
                        </div>
                        <p class="contentPost"><?php echo $profileTweet['tweet']; ?></p>

                        <div class="interaction comment-interact">
                            <?php if($user[0]['id'] != $profileTweet['user_id']): ?>
                                <a href="javascript:;" class="retweet"><i class="fa fa-retweet" id="iconRetweet" aria-hidden="true" <?php echo $profileTweet['isRetweet'] ? "style=color:red;" : '';?> ></i> |</a>
                            <?php else: ?>
                                <a href="javascript:;"  class="tweet-edit">Edit |</a>
                                <a href="javascript:;" class="tweet-delete">Delete |</a>
                            <?php endif; ?>
                    </article>
                <?php endforeach ?>
            </div>
        </section>
    </div>
</div>
</body>
</html>
<script src="http://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="js/main.js"></script>


