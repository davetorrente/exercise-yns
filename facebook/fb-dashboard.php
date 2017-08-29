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
        $page1 = $page*25-25;
    }
}else{
    $page1 = 0;
}
$permissions = []; // optional
$helper = $fb->getRedirectLoginHelper();
$accessToken = $helper->getAccessToken();
$newArray = array();
if (isset($_SESSION['facebook_token'])) {

    if(empty($accessToken)){
        $accessToken = $_SESSION['facebook_token'];
    }
     //    $url = "https://graph.facebook.com/v2.10/me?fields=picture%2Cfeed.limit(100)%2Cfriends&access_token={$accessToken}";
    $url = "https://graph.facebook.com/v2.10/me?fields=picture%2Cfeed%2Ctaggable_friends.limit(1000)%2Ccover&access_token={$accessToken}";
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

    $url2 = "https://graph.facebook.com/v2.10/1798908286791397/taggable_friends?pretty=0&limit=1000&after=QWFLUmVkbUYwRTZAHNUJEWDlCRmFsbTFzZAWp0Mm9vOWIzV04zemVFY3BhVWV5YUJBaXVuYjYxOVRTYmowMjF1NkpxQUZATNV8yR0NZAbWd2Q3ZAuVzdndGtDNXgxb3kxSGZAfenRTZAVhlWkQwM0J0ZAlEZD&access_token={$accessToken}";
    $ch2 = curl_init();
    curl_setopt($ch2, CURLOPT_URL, $url2);
    curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch2, CURLOPT_COOKIEJAR,'cookie.txt');
    curl_setopt($ch2, CURLOPT_COOKIEFILE,'cookie.txt');
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch2, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
    curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
    $st=curl_exec($ch2);
    $friendsresults2 =json_decode($st,TRUE);

//    echo "<pre>";

    array_values($results['taggable_friends']['data']);
    array_values($friendsresults2['data']);
    $mergeArrays = array_merge($results['taggable_friends']['data'],$friendsresults2['data']);
    $arrayFriends = array();
    array_push($arrayFriends, $mergeArrays);

//   print_r(count($arrayFriends[0]));
//    die();

    $pages = count($results['feed']['data']) / 25;
    $b =  ceil($pages);

    if(isset($_GET['page']))
    {
        $page = $_GET['page'];
        if($page=='' || $page == 1)
        {
            $page1 = 0;
        }else{
            $page1 = $page*25-25;
        }
    }else{
        $page1 = 0;
    }

    $newArray = array_slice($results['feed']['data'], $page1, ($page1+25));
    $profilePic = $results['picture']['data']['url'];
    $displayFriends = array_slice($arrayFriends[0], 0, 8);
//    echo '<pre>';
//    print_r($displayFriends);

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
<div class="container">
    <div class="jumbotron">
        <p>asdfasdfasdfasdfasdfasd</p>
    </div>
</div>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">My Feed</h3>
                    </div>
                </div>
                <?php if(!empty($newArray)): ?>
                   <?php foreach($newArray as $item): ?>
                        <?php if(!empty($item['message']) || !empty($item['story'])): ?>
                    <div class="panel panel-default post">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-2">
                                    <a href="<?php echo !empty($profilePic) ? $profilePic : "#" ;?>" class="post-avatar thumbnail"><img src="<?php echo !empty($profilePic) ? $profilePic : "img/user.png" ;?>" alt=""><div class="text-center"><?php echo $_SESSION['name'];?></div></a>
                                </div>
                                <div class="col-sm-10">
                                    <div class="bubble">
                                        <div class="pointer">
                                            <?php if(isset($item['message'])): ?>
                                                <p><?php echo $item['message']; ?></p>
                                            <?php else: ?>
                                                <p><?php echo $item['story']; ?></p>)
                                            <?php endif; ?>


                                        </div>
                                        <div class="pointer-border"></div>
                                    </div>
                                        <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endforeach;?>
                <?php endif; ?>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col col-xs-4">Page <?php echo $page==0 ? 1 : $page; ?> of <?php echo !empty($b) ? $b : '' ; ?>
                        </div>
                        <div class="col col-xs-8">
                            <ul class="pagination pull-right">
                                <?php for($i=1; $i<=$b; $i++): ?>
                                    <li><a href="fb-dashboard.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                <?php endfor ?>
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
                            <?php foreach($displayFriends as $displayFriend): ?>
                                <li> <a href="<?php echo $displayFriend['picture']['data']['url'] ;?>" class="thumbnail showFriends"><img src="<?php echo $displayFriend['picture']['data']['url'] ;?>" alt=""><?php echo $displayFriend['name'] ;?></a></li>
                            <?php endforeach; ?>
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
