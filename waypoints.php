<?php
    $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "";
    $database = "c9";
    $dbport = 3306;

    $con = new mysqli($servername, $username, $password, $database, $dbport) or die("Error " . mysqli_error($con));
    
    $sql = "SELECT * FROM waypoints";
    $result = mysqli_query($con, $sql) or die("Error " . mysqli_error($con));

    $arr = array();
    while ($row = mysqli_fetch_object($result)) {
        $arr[] = $row;
    }
    
    echo(json_encode($arr));

    mysqli_close($con);
?>
