<?php

session_start();
// Make sure to load the Facebook SDK for PHP via composer or manually
//define('facebook-php-sdk-v4-5.0-dev', '/facebook-php-sdk-v4-4.0-dev/src/Facebook/');
//require __DIR__ . '/facebook-php-sdk-v4-4.0-dev/autoload.php';
require_once __DIR__ . '/facebook-sdk-v5/src/Facebook/autoload.php';

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;

//FacebookSession::setDefaultApplication('526192924206057', 'e5bca4df80048a8d5e4e1f2141e7eda1');

$fb = new Facebook\Facebook([
  'app_id' => '526192924206057',
  'app_secret' => 'e5bca4df80048a8d5e4e1f2141e7eda1',
  'default_graph_version' => 'v2.4',
  ]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['user_events']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://geoconnect-kshen3778.c9.io/fbprofile.php', $permissions);






//$helper = new FacebookRedirectLoginHelper('https://geoconnect-kshen3778.c9.io/fbprofile.php', $appId = '526192924206057', $appSecret = 'e5bca4df80048a8d5e4e1f2141e7eda1');
//echo '<a id="facebooklink" href="' . $loginUrl . '">Login with Facebook</a><script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script><script>$( document ).ready(function(){$("#facebooklink").click();});</script>';
header('Location: ' . $loginUrl);
?>