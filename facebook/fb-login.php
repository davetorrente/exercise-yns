<?php
session_start();
require_once __DIR__ . '/Facebook/autoload.php';
if(isset($_SESSION['facebook_token'])){
    header("Location: fb-dashboard.php");
    exit;
}
$fb = new \Facebook\Facebook([
    'app_id' => '1965745767041050',
    'app_secret' => 'cd791ff5bf0a591beb27269d5fa5ab64',
    'default_graph_version' => 'v2.10',
]);
$permissions = []; // optional
$helper = $fb->getRedirectLoginHelper();
$accessToken = $helper->getAccessToken();

if (isset($accessToken)) {

    $url = "https://graph.facebook.com/v2.10/me?fields=first_name%2Clast_name&access_token={$accessToken}";
    $headers = array("Content-type: application/json");
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_COOKIEJAR,'cookie.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE,'cookie.txt');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $st=curl_exec($ch);
    $result=json_decode($st,TRUE);
    $_SESSION['facebook_token'] = (string) $accessToken;
    $fb->setDefaultAccessToken($_SESSION['facebook_token']);
    $_SESSION['name'] = $result['first_name'] . ' ' . $result['last_name'];
    header("Location: fb-dashboard.php");
    exit;
}

else {
    // replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www version or www version of your website then you must add the same here
    $loginUrl = $helper->getLoginUrl('http://local.exercise.com/facebook/fb-login.php', $permissions);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>fb-login</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/fb-login.css" rel="stylesheet">
</head>
<body>
<div class="container mainDiv">
    <div class="row">
        <div class="col-md-offset-6 col-md-3">
            <div class="form-login">
                <h2>Welcome back.</h2>
                <div class="wrapper">
            <span class="group-btn">
                <a class="btn btn-primary btn-md" href="<?php echo isset($loginUrl) ? $loginUrl : 'javascript:;';?>">Log in with Facebook! <i class="fa fa-sign-in"></i></a>
            </span>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
