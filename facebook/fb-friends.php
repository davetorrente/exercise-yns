<?php
ob_start();
session_start();
require_once __DIR__ . '/Facebook/autoload.php';

$fb = new \Facebook\Facebook([
    'app_id' => '1965745767041050',
    'app_secret' => 'cd791ff5bf0a591beb27269d5fa5ab64',
    'default_graph_version' => 'v2.10',
]);

$permissions = []; // optional
$helper = $fb->getRedirectLoginHelper();
$accessToken = $helper->getAccessToken();
$newArray = array();
if (isset($_SESSION['facebook_token'])) {

    if(empty($accessToken)){
        $accessToken = $_SESSION['facebook_token'];
    }
    $url = "https://graph.facebook.com/v2.10/me/?fields=picture%2Cfeed.limit(275)%2Ctaggable_friends.limit(1000)%2Ccover&&access_token={$accessToken}";
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


    array_values($results['taggable_friends']['data']);
    array_values($friendsresults2['data']);
    $mergeArrays = array_merge($results['taggable_friends']['data'],$friendsresults2['data']);
    $arrayFriends = array();
    array_push($arrayFriends, $mergeArrays);

    $displayFriends = array_slice($arrayFriends[0], 0, 8);
    $imageCover = $results['cover']['source'];




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
                <li><a href="fb-dashboard.php">Home</a></li>
                <li class="active"><a href="fb-friends.php">Friends</a></li>
                <li><a href="?logout=1">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="thumbnails">
            <?php foreach($arrayFriends[0] as $arrayFriend): ?>
            <div class="col-md-2">
                <div class="thumbnail">
                    <img src="<?php echo $arrayFriend['picture']['data']['url']; ?>" alt="ALT NAME">
                    <div class="caption">
                        <p><?php echo $arrayFriend['name']; ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
</div>
<footer>
    <div class="container">
        <div class="navbar-text pull-left">
            <p>copyright Sample Exercise Facebook Graph API</p>
        </div>
    </div>
</footer>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/main.js"></script>
</body>
</html>
