<?php
session_start();
$events = $_POST['events'];

$servername = getenv('IP');
$username = getenv('C9_USER');
$password = "";
$dbname = "c9";
//$event_edge = $_SESSION["event_edge"];
  if(empty($events)) 
  {
    echo "You didn't select any events";
  } 
  else
  {
    $N = count($events);
    echo("You selected $N event(s): ");
    for($i=0; $i < $N; $i++)
    {
      
      $event = $events[$i]; //event name/value
      $data = explode("*", $event);
      //var_dump($data[0]);
      //var_dump($data[1]);
      //var_dump($data[2]);
      $radius = 250;
      $con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
      $query = $con->prepare("INSERT INTO waypoints (title, address, info, owner, radius) VALUES (:title, :address, :info, :owner, :radius) ");
      $query->bindParam(':title',$data[0]);
      $query->bindParam(':address',$data[2]);
  	  $query->bindParam(':info',$data[1]);
      $query->bindParam(':owner',$_SESSION["username"]);
      $query->bindParam(':radius', $radius);
      $query->execute();
    }
    header("Location: /");
  
  }
?>