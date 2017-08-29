<?php
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
    $sessionUserID = $user[0]['id'];
}
if(isset($_GET['username'])){
    $userProfile= $_GET['username'];
    $database->query("SELECT * FROM users where username='$userProfile'");
    $userInfos = $database->resultset();

    $getUserID = $userInfos[0]['id'];
    $database->query("SELECT users.username FROM follows INNER JOIN users ON follows.follow_id = users.id WHERE user_id='$getUserID' AND isFollow=true GROUP BY users.username ");
    $followUsers = $database->resultset();

    $database->query("SELECT users.username FROM follows INNER JOIN users ON follows.user_id = users.id WHERE follow_id='$getUserID' AND isFollow=true GROUP BY users.username ");
    $userFollows = $database->resultset();

    $database->query("SELECT isFollow FROM follows WHERE user_id='$sessionUserID' AND follow_id='$getUserID'");
    $followName = $database->resultset();


    $database->query("SELECT users.username, users.upload, tweets.id, tweets.user_id, tweets.tweet, tweets.created, tweets.modified, tweets.isRetweet FROM tweets INNER JOIN users ON tweets.user_id = users.id WHERE users.username='$userProfile' ORDER BY tweets.created DESC");
    $profileTweets = $database->resultset();

    $database->query("SELECT RU.username, TU.username as tweetUser, RU.upload, R.id, R.user_id, R.tweet, R.created FROM retweets R INNER JOIN users RU ON R.user_id = RU.id INNER JOIN tweets TS ON R.tweet_id = TS.id LEFT JOIN users TU ON TS.user_id = TU.id WHERE RU.username='$userProfile' ORDER BY R.created DESC");
    $profileRetweets = $database->resultset();

    function cmp($a, $b){
        $ad = strtotime($a['created']);
        $bd = strtotime($b['created']);
        return ($bd-$ad);
    }
    $mergeTweets = array_merge($profileTweets, $profileRetweets);
    usort($mergeTweets, 'cmp');

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
    <link rel="stylesheet" href="css/profile.css">
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
        <a class="navbar-brand" href="micro-blog.php">Micro Blog</a>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="micro-blog.php">Home</a></li>
                <li class="active"><a href="micro-profile.php?username=<?php echo htmlspecialchars($user[0]['username']);?>"><img src="<?php echo htmlspecialchars($user[0]['upload']);?>" class="nav-profile img-circle"> Profile</a></li>
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
<div class="container-fluid">
    <div class="row profile-div">
        <div class="col-md-3" id="userFollows">
            <div class="profile-pic">
                <img src="<?php echo htmlspecialchars($userInfos[0]['upload']);?>" alt="sample profile pic" class="img-thumbnail img-profile">
            </div>
            <p>
                <?php echo htmlspecialchars($userInfos[0]['description']); ?>
            </p>
            <?php if(!empty($followUsers)): ?>
             <p ><b>Following</b><span class="badge following-class"><?php echo htmlspecialchars(count($followUsers)); ?></span></p>
            <p ><b>You are following</b><br/>
                <?php foreach($followUsers as $followUser): ?>
                    <a href="micro-profile.php?username=<?php echo htmlspecialchars($followUser['username']);?>"><?php echo htmlspecialchars($followUser['username']) . ", "; ?></a>
                <?php endforeach; ?>
            </p>
            <?php endif; ?>
            <?php if(!empty($userFollows)): ?>
            <p><b>Number of Followers</b><span class="badge following-class"><?php echo htmlspecialchars(count($userFollows)); ?></span></p>
            <?php if(count($userFollows) > 1): ?>
            <p><b>Your Followers</b><br/>
            <?php else: ?>
                    <p><b>Your Follower</b><br/>
            <?php endif; ?>
                <?php foreach($userFollows as $userFollow): ?>
                    <a href="micro-profile.php?username=<?php echo htmlspecialchars($userFollow['username']);?>"><?php echo htmlspecialchars($userFollow['username']) . ", "; ?></a>
                <?php endforeach; ?>
            </p>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-8 col-md-offset-4">
                    <?php if($_SESSION['microUser'] !=  $userInfos[0]['username'] ): ?>
                    <!-- For other user profile not involved the authenticated user will have a Follow Button -->
                        <form action="" method="post" id="followForm">
                            <input class="form-control hiddenFollow" type="hidden" name="hidden_id" value="<?php echo htmlspecialchars($userInfos[0]['id']);?>">
                            <!--$followName variable to displayed wether a user is being followed or not-->
                            <button type="submit" class="btn btn-info addFollow" id="addFollow"><?php echo !empty($followName[0]['isFollow']) ? "Unfollow" : "Follow";?> </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <h1 class="samplePosts">
                <!-- If it is the logged in user, it will display "Your Profile" -->
                <?php if($userInfos[0]['username'] == $_SESSION['microUser']): ?>
                    Your Profile
                    <!-- If it is not the logged in user, it will display username's Profile -->
                <?php else: ?>
                    <?php echo htmlspecialchars($userInfos['0']['username']). "'s" . " Profile"; ?>
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
                                <input class="form-control" type="hidden" name="hidden_id" value="<?php echo htmlspecialchars($userInfos[0]['id'] );?>">
                            </div>
                            <button type="button" class="btn btn-info" name="btnAdd" id="btnAdd">Create Tweet</button>
                        </form>
                    <?php endif; ?>
                </div>
            </section>
            <section class="row section2">
                <div class="col-md-8 col-md-offset-2" id="showdata">
                    <div class="alert" id="alertMessage" style="display: none;"></div>
                        <?php foreach($mergeTweets as $mergeTweet): ?>
                            <?php if(isset($mergeTweet['isRetweet'])): ?>
                                <article class="post">
                                    <div class="alert alert-edit" id="alertMessage" style="display: none;"></div>
                                    <div class="info postByUser">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <a href="micro-profile.php?username=<?php echo htmlspecialchars($mergeTweet['username']); ?>"><img src="<?php echo htmlspecialchars($mergeTweet['upload']);?>" alt="sample profile pic" class="postImage"></a>
                                            </div>
                                            <div class="col-md-6 userName">
                                                <h4 ><?php echo htmlspecialchars($mergeTweet["username"]); ?></h4>
                                                <p>Posted on <?php echo htmlspecialchars($mergeTweet['created']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="contentPost"><?php echo $mergeTweet['tweet']; ?></p>
                                    <div class="clearfix"></div>
                                    <div class="interaction tweet-interact" user_id="<?php echo htmlspecialchars($mergeTweet['user_id']); ?>" tweet_id="<?php echo htmlspecialchars($mergeTweet['id']); ?>">
                                        <?php if($user[0]['id'] != $mergeTweet['user_id']): ?>
                                            <a href="javascript:;" class="retweet"><i class="fa fa-retweet" id="iconRetweet" aria-hidden="true" <?php echo $mergeTweet['isRetweet'] == true ? "style=color:green;" : '';?> ></i> |</a>
                                        <?php else: ?>
                                            <a href="javascript:;"  class="tweet-edit">Edit |</a>
                                            <a href="javascript:;" class="tweet-delete" id="delete-item" >Delete |</a>
                                        <?php endif; ?>
                                    </div>
                                </article>
                            <?php else: ?>
                                <article class="post">
                                    <div class="alert alert-edit" id="alertMessage" style="display: none;"></div>
                                    <div class="info postByUser">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <a href="micro-profile.php?username=<?php echo htmlspecialchars($mergeTweet['username']); ?>"><img src="<?php echo htmlspecialchars($mergeTweet['upload']);?>" alt="sample profile pic" class="postImage"></a>
                                            </div>
                                            <div class="col-md-6 userName">
                                                <h4 ><?php echo htmlspecialchars($mergeTweet["username"]); ?></h4>
                                                <p>Retweeted from <a href="micro-profile.php?username=<?php echo htmlspecialchars($mergeTweet['tweetUser']); ?>"><?php echo htmlspecialchars($mergeTweet['tweetUser']); ?> </a> on <?php echo htmlspecialchars($mergeTweet['created']); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="contentPost"><?php echo $mergeTweet['tweet']; ?></p>
                                    <div class="clearfix"></div>
                                    <div class="interaction tweet-interact" user_id="<?php echo htmlspecialchars($mergeTweet['user_id']); ?>" tweet_id="<?php echo htmlspecialchars($mergeTweet['id']); ?>">
                                        <?php if($user[0]['id'] != $mergeTweet['user_id']): ?>
                                            <a href="javascript:;" class="retweet"><i class="fa fa-retweet" id="iconRetweet" aria-hidden="true" <?php echo $mergeTweet['isRetweet'] == true ? "style=color:green;" : '';?> ></i> |</a>
                                        <?php else: ?>
                                            <a href="javascript:;" class="retweet-delete" id="delete-item">Delete |</a>
                                        <?php endif; ?>
                                    </div>
                                </article>
                            <?php endif; ?>
                        <?php endforeach ?>
                </div>
            </section>
        </div>
    </div>
</div>
</body>
</html>
<script src="http://code.jquery.com/jquery-3.2.1.min.js"
        integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="js/main.js" type="text/javascript"></script>


