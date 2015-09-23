<?php
    $title = $_POST["title"];
    $address = $_POST["address"];
    
    session_start();
    $owner = $_SESSION["username"];
    
    $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "";
    $dbname = "c9";

    $con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $query = $con->prepare("DELETE FROM waypoints WHERE title = :title AND address = :address AND owner = :owner");
	$query->bindParam(':title',$title);
	$query->bindParam(':address',$address);
	$query->bindParam(':owner',$owner);
	$query->execute();
	
    header("Location: /");
?>
