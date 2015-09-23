<?php
    if (!empty($_POST)) {
        $title = $_POST["title"];
        $address = $_POST["address"];
        $info = $_POST["info"];
        $radius = $_POST["radius"];
        
        session_start();
        $owner = $_SESSION["username"];
        
        $servername = getenv('IP');
        $username = getenv('C9_USER');
        $password = "";
        $dbname = "c9";
    
        $con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    
        $query = $con->prepare("INSERT INTO waypoints (title, address, info, owner, radius) VALUES (:title, :address, :info, :owner, :radius) ");
    	$query->bindParam(':title',$title);
    	$query->bindParam(':address',$address);
    	$query->bindParam(':info',$info);
    	$query->bindParam(':owner',$owner);
    	$query->bindParam(':radius', $radius);
    	$query->execute();
    	
        header("Location: /");
    } else {
?>
<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
      <link rel="stylesheet" type="text/css" href="stylesheet.css"/>
    </head>
    <body style="width: 100%; height: 100%; background-image:url(pens.JPG); background-repeat:no-repeat; background-size:cover;">
        
        <script>
            $( document ).ready(function(){
              $("#import-fake-facebook-event").on("click",function(){
                 $("#import-facebook-event").click(); 
              });
            });
        </script>
        
        
        
        <div class="container-fluid">
            <?php include "navbar.php" ?>
        </div>
        
        <form method="POST" action="facebook.php" style="display: none;">
            <input type="submit" id="import-facebook-event" value="Import Facebook Event">
        </form>
        <form action="new-waypoint.php" method="POST" id="create-waypoint" class="col-sm-offset-3 col-sm-6">
            <input class="col-sm-offset-1 col-sm-10" id="create-waypoint-title" type="text" placeholder="title" name="title"/>
            <input class="col-sm-offset-1 col-sm-10" id="create-waypoint-address" type="text" placeholder="address" name="address"/>
            <input class="col-sm-offset-1 col-sm-10" id="create-waypoint-info" type="text" placeholder="info - talk about your activity" name="info"/>
            <input class="col-sm-offset-1 col-sm-10" id="create-waypoint-radius" type="text" placeholder="radius - how far away will you get a notification (Meters)" type="number" max="500" name="radius"/>
            <input class="col-sm-offset-1 col-sm-10" type="button" id="import-fake-facebook-event" value="Import Facebook Events"/>
            <input class="col-sm-offset-1 col-sm-10" id="create-waypoint-submit" type="submit" value="Submit"/>
        </form>
    </body>
</html>
<?php
    }
?>
