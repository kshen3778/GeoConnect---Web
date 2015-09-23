<?php
session_start();
//define('facebook-php-sdk-v4-4.0-dev', '/facebook-php-sdk-v4-4.0-dev/src/Facebook/');
//require __DIR__ . '/facebook-php-sdk-v4-4.0-dev/autoload.php';
require_once __DIR__ . '/facebook-sdk-v5/src/Facebook/autoload.php';

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;

/*
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;*/

/*FacebookSession::setDefaultApplication('526192924206057', 'e5bca4df80048a8d5e4e1f2141e7eda1');

$helper = new FacebookRedirectLoginHelper('https://geoconnect-kshen3778.c9.io/fbprofile.php');
try {
  $session = $helper->getSessionFromRedirect();
} catch(FacebookRequestException $ex) {
  // When Facebook returns an error
} catch(\Exception $ex) {
  // When validation fails or other local issues
}
if ($session) {
    try {
        
       /* $user_profile = (new FacebookRequest(
          $session, 'GET', '/me'
        ))->execute()->getGraphObject(GraphUser::className());
        echo "Name: " . $user_profile->getName(); 
        
            $request = new FacebookRequest(
                  $session,
                  'GET',
                  '/me/events'
            );
            $response = $request->execute();
            $graphObject = $response->getGraphObject();
            //echo "Events : " . $graphObject->getPropertyNames();
            
        } catch(FacebookRequestException $e) {
            echo "Exception occured, code: " . $e->getCode();
            echo " with message: " . $e->getMessage();
        } 

}*/

$servername = getenv('IP');
$username = getenv('C9_USER');
$password = "";
$dbname = "c9";

$fb = new Facebook\Facebook([
  'app_id' => '526192924206057',
  'app_secret' => 'e5bca4df80048a8d5e4e1f2141e7eda1',
  'default_graph_version' => 'v2.4',
  ]);
  
  $helper = $fb->getRedirectLoginHelper();
try {
  $accessToken = $helper->getAccessToken();
  //echo $accessToken;
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (isset($accessToken)) {
  // Logged in!
  $_SESSION['facebook_access_token'] = (string) $accessToken;
    
  $fb->setDefaultAccessToken($accessToken);
  
  $response = $fb->get('/me/events');
  $eventEdge = $response->getGraphEdge();
  $_SESSION["event_edge"] = $event_edge;
  echo '<form action="loadfbevent.php" method="POST">';
  echo "<p style='padding-left: 15px; font-size: 20px;'>Check the events that you want to import!</p>";
  foreach($eventEdge as $eventNode){
      $event_data = $eventNode->asArray();
      //var_dump($event_data);

      $title = $event_data["name"];
      

      
      $location = "";
      if(!empty($event_data["place"]["name"])){
        $location = $event_data["place"]["name"];
      }
      
      /*
      $city = "";
      if($event_data["location"]["city"] != null){
          $city = $event_data["location"]["city"];
      }
      
      $country = "";
      if($event_data["location"]["country"] != null){
          $country = $event_data["location"]["country"];
      }*/
      
      $info = "";
      if(!empty($event_data["description"])){
          $info = $event_data["description"];
      }
      
      $owner = $_SESSION["username"];
      $radius = 250;
      //$address = $street . " " . $city . " " . $country;
      
      
      
      //echo '<h4>' . $title . '</h4>';
      echo '<input style="padding-left:15px; width:20px; height: 20px; border: 1px solid black; background-color: #42A7FF;" type="checkbox" name="events[]" value="' .$title . '*' . $info . '*' . $location  .'"/>';
      echo '<h4 style="display:inline;padding-left:15px;position: relative;top:-5px;">' . $title . '</h4><br><br>';
      /*
      $con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
      $query = $con->prepare("INSERT INTO waypoints (title, address, info, owner, radius) VALUES (:title, :address, :info, :owner, :radius) ");
      $query->bindParam(':title',$title);
      $query->bindParam(':address',$location);
  	  $query->bindParam(':info',$info);
      $query->bindParam(':owner',$owner);
      $query->bindParam(':radius', $radius);
      $query->execute(); */
      
      //echo $event_data['name'];
      //var_dump($eventNode->asArray());
  }
  echo '<div style="background-color: white;margin-left: 15px; padding:15px; width:200px; border-radius:5px;"><input type="submit" name="formSubmit" value="Submit" style="padding:5px;border:1px solid black;background-color:#00A32C; width: 200px;color: white; cursor: pointer;"/></div>';
  echo '</forms>';
  //header("Location: /");
  
  // Now you can redirect to another page and use the
  // access token from $_SESSION['facebook_access_token']
}
?>