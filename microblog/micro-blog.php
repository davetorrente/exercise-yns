<?php
require_once "Database.php";
require_once "modals/delete-modal.php";
require_once "modals/edit-modal.php";
require_once "modals/retweet-modal.php";
session_start();
$database = new Database();

if (empty($_SESSION['microUser'])){
    header("Location: micro-login.php");
}else{
     $userAuth = $_SESSION['microUser'];
    $database->query("SELECT * FROM users WHERE username = '$userAuth'");
    $user = $database->resultset();
}
$database->query("SELECT users.username, users.upload, tweets.id, tweets.user_id, tweets.tweet, tweets.created, tweets.modified, tweets.isRetweet FROM tweets INNER JOIN users ON tweets.user_id = users.id  ORDER BY tweets.created DESC");
$userTweets = $database->resultset();

if(!empty($_GET['logout']) == 1) {
    session_destroy();
    header("Location: micro-login.php");
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
    <script src="http://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="js/main.js" type="text/javascript"></script>
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
        <a class="navbar-brand" href="micro-blog.php">Micro Blog</a>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="active"><a href="micro-blog.php">Home</a></li>
                <li><a href="micro-profile.php?username=<?php echo $user[0]['username'];?>"><img src="<?php echo $user[0]['upload'];?>" class="nav-profile img-circle"> Profile</a></li>
                <li><a href="?logout=1">Logout</a></li>
            </ul>
            <form class="hidden-xs-down navbar-form pull-right search-menu form-inline">
                <div role="group" class="input-group">
                    <input type="text" class="form-control" name="search" id="search" placeholder="Username.." aria-label="Username" aria-describedby="basic-addon1">
                    <div class="input-group">
                        <li class="nav-item dropdown show" style="list-style-type:none;">
                            <div role="menu" class="dropdown-menu dropdown-menu-right" id="menuItem" style="display:none">
                                <h6 tabindex="-1" class="dropdown-header active">no results found</h6>
                            </div>
                        </li>
                    </div>
                </div>
            </form>
        </div>
    </div>
</nav>
<div class="container" id="mainDiv">
    <section class="row sectionUser">
        <div class="col-md-6 col-md-offset-3">
            <div class="alert" id="alertMessage" style="display: none;"></div>
            <!-- Say Hi to the User by User Authentication -->
            <h3>Hi <?php echo htmlspecialchars($user[0]['username']); ?>.
            </h3>
            <form id="createTweet" method="post">
                <div class="form-group">
                    <textarea class="form-control" name="tweet" id="tweet" rows="3" placeholder="Your Tweet.."></textarea>
                    <!--                <p style="display: inline-block">Total number of characters: </p><span style="display: inline-block" id="tweetCount">140</span>-->
                </div>
                <div class="form-group">
                    <input class="form-control" type="hidden" name="hidden_id" value="<?php echo htmlspecialchars($user[0]['id']);?>">
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
                                <a href="micro-profile.php?username=<?php echo htmlspecialchars($userTweet['username']); ?>"><img src="<?php echo htmlspecialchars($userTweet['upload']);?>" alt="sample profile pic" class="postImage"></a>
                            </div>
                            <div class="col-md-6 userName">
                                <h4 ><?php echo htmlspecialchars($userTweet["username"]); ?></h4>
                                <p>Posted on <?php echo htmlspecialchars($userTweet['modified']); ?></p>
                            </div>
                        </div>
                    </div>
                    <p class="contentPost"><?php echo $userTweet['tweet']; ?></p>
                    <div class="clearfix"></div>
                    <div class="interaction tweet-interact" user_id="<?php echo htmlspecialchars($userTweet['user_id']); ?>" tweet_id="<?php echo htmlspecialchars($userTweet['id']); ?>">
                        <?php if($user[0]['id'] != $userTweet['user_id']): ?>
                            <a href="javascript:;" class="retweet"><i class="fa fa-retweet" id="iconRetweet" aria-hidden="true" <?php echo $userTweet['isRetweet'] == true ? "style=color:green;" : '';?> ></i> |</a>
                        <?php else: ?>
                                <a href="javascript:;"  class="tweet-edit">Edit |</a>
                                <a href="javascript:;" class="tweet-delete">Delete |</a>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach ?>
        </div>
    </section>
</div>
</body>
</html>

