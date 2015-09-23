<?php
  session_start();
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
  <style type="text/css">
      html, body { height: 100%; margin: 0; padding: 0; }
    </style>
    <script>
      $( document ).ready(function(){
        $(".glyphicon-edit").on("click",function(event){
          var title = $(event.target).closest(".tablerow").children(".waypoint-title").html();
          var address = $(event.target).closest(".tablerow").children(".waypoint-address").html();
          var info = $(event.target).closest(".tablerow").children(".waypoint-info").html();
          var radius = $(event.target).closest(".tablerow").children(".waypoint-radius").html();
          
          $("#hid-edit-title").val(title);
          $("#hid-edit-address").val(address);
          $("#hid-edit-info").val(info);
          $("#hid-edit-radius").val(radius);
          $("#hid-edit-submit").click();
        });
        $(".glyphicon-trash").on("click",function(){
          var confirmdelete = confirm("Do you want to delete your Waypoint?");
    if (confirmdelete == true) {
          
          var title = $(event.target).closest(".tablerow").children(".waypoint-title").html();
          var address = $(event.target).closest(".tablerow").children(".waypoint-address").html();
          
          $("#hid-delete-title").val(title);
          $("#hid-delete-address").val(address);
          $("#hid-delete-submit").click();
          
    }
        });
      });
    </script>
</head>
<body style="width: 100%; height: 100%; <?php if (empty($_SESSION["username"])) {?>  background-image:url(hackthenorth.JPG); background-repeat:no-repeat; background-size:cover;<?php } ?>">
  
  <form  method="POST" action="update-waypoint.php" id="hidden-edit" style="display:none;">
        <input id="hid-edit-title" type="text" name="title">
        <input id="hid-edit-address" type="text" name="address">
        <input id="hid-edit-info" type="text" name="info">
        <input id="hid-edit-radius" type="text" name="radius">
        <input id="hid-edit-submit" type="submit">
  </form>
  
  
  
  <form  method="POST" action="remove-waypoint.php" id="hidden-remove" style="display:none;">
        <input id="hid-delete-title" type="text" name="title">
        <input id="hid-delete-address" type="text" name="address">
        <input id="hid-delete-submit" type="submit">
  </form>
  
  
  
  
  
  <div class="container-fluid">
    
    <?php include "navbar.php" ?>
    
    <div class="row-fluid">
      <?php if (empty($_SESSION["username"])) { ?>
      <form class="col-sm-offset-8 col-sm-3" method="POST" action="login.php" id="login-field">
        <div id="login-title" class="col-sm-offset-5">Login</div>
        <input class="col-sm-offset-1 col-sm-10" type="text" id="login-username" name="username" placeholder="username">
        <input class="col-sm-offset-1 col-sm-10" type="password" id="login-password" name="password" placeholder="password">
        <input class="col-sm-offset-1 col-sm-10" type="submit" id="login-submit">
        <hr class="col-sm-offset-1 col-sm-9" id="login-hr">
      </form>

      </div>
      <?php 
        
        if(isset($_SESSION["error"])){
          echo $_SESSION["error"]; 
          $_SESSION["error"] = null;
        }
      ?>
      <div class="row-fluid">
      <form class="col-sm-offset-8 col-sm-3" method="POST" action="register.php" id="register-field">
        <div id="register-title" class="col-sm-offset-3">Create Account</div>
        <input class="col-sm-offset-1 col-sm-10" id="reg-username" type="text" name="username" placeholder="username">
        <input class="col-sm-offset-1 col-sm-10" id="reg-password" type="password" name="password" placeholder="password">
        <input class="col-sm-offset-1 col-sm-10" id="reg-email" type="text" name="email" placeholder="email">
        <input class="col-sm-offset-1 col-sm-10" id="reg-submit" type="submit" value="Register Account">
      </form></div>
      <!--<div class="row-fluid">
        <h2 id="video-title" class="col-sm-offset-3 col-sm-3">What it is</h2>
        
      </div>-->
      
      
      
      <div class="row-fluid">
      
    <?php
      } else {
        $servername = getenv('IP');
        $username = getenv('C9_USER');
        $password = "";
        $dbname = "c9";
    
        $con = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $user = $_SESSION["username"];
        $query = $con->prepare("SELECT * FROM waypoints WHERE owner = :user");
        $query->bindParam(':user', $user);
        $query->execute();

        $waypoints = $query->fetchAll(PDO::FETCH_ASSOC);
    ?>
      <table class='table'>
        <thead>
          <tr>
            <td class='col-sm-3'><h4>Title</h4></td>
            <td class='col-sm-3'><h4>Address</h4></td>
            <td class='col-sm-3'><h4>Info</h4></td>
            <td class='col-sm-3'><h4>Radius</h4></td>
          </tr>
        </thead>
        <tbody>
        <?php
            foreach ($waypoints as $waypoint) {
              echo("<tr class='tablerow'><td class='col-sm-3 waypoint-title'>".$waypoint["title"]."</td><td class='col-sm-3 waypoint-address'>".$waypoint["address"]."</td><td class='col-sm-3 waypoint-info'>".$waypoint["info"]."</td><td class='col-sm-2 waypoint-radius'>".$waypoint["radius"] . " meters</td>" . "<td class='col-sm-3'>   <span class='glyphicon glyphicon-edit' style='cursor:pointer;'></span> <span class='glyphicon glyphicon-trash' style='cursor:pointer;'></span> </td></tr>");
            }
        ?>
        </tbody>
      </table>
    <?php } ?>
    </div>
  </div>
  
</body>

</html>
