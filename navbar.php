<?php
  session_start();
?>
<nav class="navbar navbar-inverse navbar-default navbar-custom">
  <div class="container-fluid">
    <div class="navbar-header" style="<?php if (isset($_SESSION["username"])) {}else{echo "float:right;margin-right:43%;margin-left:0%";   }  ?>">
      <a class="navbar-brand" href="#" style="color:white;<?php if (isset($_SESSION["username"])) {}else{echo "font-size: 30px;";   }  ?>">GeoConnect</a>
    </div>
    <div>
      <ul class="nav navbar-nav">
        <?php if (isset($_SESSION["username"])) { ?>
        <li id="home-button"><a href="index.php">My Waypoints</a></li>
              <li id="waypoint-button"><a href="new-waypoint.php">Create a Waypoint</a></li>
        <?php } ?>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li style="color: white; padding-top: 15px; padding-left: 20px;">
          <?php
            if (isset($_SESSION["username"])) {
              echo $_SESSION["username"];
            }
          ?>
        </li>
        <li>
        
        <?php
        
        if (isset($_SESSION["username"])) {
          echo '<a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a>';
        }
        ?>
        </li>
      </ul>
    </div>
  </div>
</nav>
