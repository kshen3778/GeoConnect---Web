<?php
    if (!empty($_POST) && $_POST["action"] == "update") {
        $title = $_POST["title"];
        $address = $_POST["address"];
        $info = $_POST["info"];
        $radius = $_POST["radius"];
        
        session_start();
        $id = $_SESSION["eventid"];
        unset($_SESSION["eventid"]);
        $owner = $_SESSION["username"];
        
        $servername = getenv('IP');
        $username = getenv('C9_USER');
        $password = "";
        $dbname = "c9";
    
        $con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    
        $query = $con->prepare("UPDATE waypoints SET title = :title, address = :address, info = :info, radius = :radius WHERE id = :id AND owner = :owner");
    	$query->bindParam(':title', $title);
    	$query->bindParam(':address', $address);
    	$query->bindParam(':info', $info);
    	$query->bindParam(':radius', $radius);
    	$query->bindParam(':id', $id);
    	$query->bindParam(':owner', $owner);
    	$query->execute();
        header("Location: /");
    } else if (!empty($_POST)) {
        session_start();
        
        $title = $_POST["title"];
        $address = $_POST["address"];
        $info = $_POST["info"];
        $radius = $_POST["radius"];
        $radius = substr($radius,0,strlen($radius)-7);
        
        $servername = getenv('IP');
        $username = getenv('C9_USER');
        $password = "";
        $dbname = "c9";
    
        $con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $query = $con->prepare("SELECT * FROM waypoints WHERE title = :title AND address = :address AND info = :info AND radius = :radius AND owner = :owner");
    	$query->bindParam(':title',$title);
    	$query->bindParam(':address',$address);
    	$query->bindParam(':info',$info);
    	$query->bindParam(':radius', $radius);
    	$query->bindParam(':owner', $_SESSION["username"]);
    	$query->execute();
    	$_SESSION["eventid"] = $query->fetch(PDO::FETCH_ASSOC)["id"];
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
        <div class="container-fluid">
            <?php include "navbar.php" ?>
        </div>
        <form action="update-waypoint.php" method="POST" id="create-waypoint" class="col-sm-offset-3 col-sm-6">
            <input class="col-sm-offset-1 col-sm-10" id="create-waypoint-title" type="text" placeholder="title" name="title" <?php echo("value=\"".$title."\""); ?> >
            <input class="col-sm-offset-1 col-sm-10" id="create-waypoint-address" type="text" placeholder="address" name="address" <?php echo("value=\"".$address."\""); ?> >
            <input class="col-sm-offset-1 col-sm-10" id="create-waypoint-info" type="text" placeholder="info - talk about your activity" name="info" <?php echo("value=\"".$info."\""); ?> >
            <input class="col-sm-offset-1 col-sm-10" id="create-waypoint-radius" type="text" placeholder="radius - how far away will you get a notification (Meters)" name="radius" <?php echo("value=\"".$radius."\""); ?> >
            <input style="display: none;" type="input" name="action" value="update">
            <input class="col-sm-offset-1 col-sm-10" id="create-waypoint-submit" type="submit" value="Submit"/>
        </form>
    </body>
</html>
<?php
    } else {
        header("Location: /");
    }
?>
