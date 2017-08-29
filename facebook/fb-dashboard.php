<?php
ob_start();
session_start();
require_once __DIR__ . '/Facebook/autoload.php';

$fb = new \Facebook\Facebook([
    'app_id' => '1965745767041050',
    'app_secret' => 'cd791ff5bf0a591beb27269d5fa5ab64',
    'default_graph_version' => 'v2.10',
]);
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
$permissions = []; // optional
$helper = $fb->getRedirectLoginHelper();
$accessToken = $helper->getAccessToken();

if (isset($_SESSION['facebook_token'])) {

    if(empty($accessToken)){
        $accessToken = $_SESSION['facebook_token'];
    }
    $url = "https://graph.facebook.com/v2.10/me/feed?limit=1000&access_token={$accessToken}";

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_COOKIEJAR,'cookie.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE,'cookie.txt');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $st=curl_exec($ch);
    $results=json_decode($st,TRUE);


}

if(isset($_GET['logout']) == 1) {
    session_destroy();
    header("Location: fb-login.php");
    exit;
}
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Facebook API</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-default" id="navBar">
    <div class="container">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigatipon</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="micro-blog.php">Facebook API</a>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="active"><a href="micro-blog.php">Home</a></li>
                <li><a href="?logout=1">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">My Feed</h3>
                    </div>
                </div>
                <?php if(!empty($results)): ?>
                    <?php foreach($results['data'] as $result): ?>
                    <div class="panel panel-default post">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-2">
                                    <a href="profile.html" class="post-avatar thumbnail"><img src="img/user.png" alt=""><div class="text-center">DevUser1</div></a>
                                </div>
                                <div class="col-sm-10">
                                    <div class="bubble">
                                        <div class="pointer">
                                            <p>Hey I was wondering if you wanted to go check out the football game later. I heard they are supposed to be really good!</p>
                                        </div>
                                        <div class="pointer-border"></div>
                                    </div>
                                        <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                <?php endif; ?>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col col-xs-4">Page 1 of 11
                        </div>
                        <div class="col col-xs-8">
                            <ul class="pagination hidden-xs pull-right">
                                <li><a href="#">1</a></li>
                            </ul>
                            <ul class="pagination visible-xs pull-right">
                                <li><a href="#">«</a></li>
                                <li><a href="#">»</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-default friends">
                    <div class="panel-heading">
                        <h3 class="panel-title">My Friends</h3>
                    </div>
                    <div class="panel-body">
                        <ul>
                            <li><a href="profile.html" class="thumbnail"><img src="img/user.png" alt=""></a></li>
                            <li><a href="profile.html" class="thumbnail"><img src="img/user.png" alt=""></a></li>
                            <li><a href="profile.html" class="thumbnail"><img src="img/user.png" alt=""></a></li>
                            <li><a href="profile.html" class="thumbnail"><img src="img/user.png" alt=""></a></li>
                            <li><a href="profile.html" class="thumbnail"><img src="img/user.png" alt=""></a></li>
                            <li><a href="profile.html" class="thumbnail"><img src="img/user.png" alt=""></a></li>
                            <li><a href="profile.html" class="thumbnail"><img src="img/user.png" alt=""></a></li>
                            <li><a href="profile.html" class="thumbnail"><img src="img/user.png" alt=""></a></li>
                            <li><a href="profile.html" class="thumbnail"><img src="img/user.png" alt=""></a></li>
                        </ul>
                        <div class="clearfix"></div>
                        <a class="btn btn-primary" href="#">View All Friends</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--<footer>-->
<!--<div class="container">-->
<!--<p></p>-->
<!--</div>-->
<!--</footer>-->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>
