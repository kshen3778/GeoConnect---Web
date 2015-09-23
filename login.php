<?php
    session_start();
    $_SESSION["error"] = null;
    
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $servername = getenv('IP');
    $conusername = getenv('C9_USER');
    $conpassword = "";
    $database = "c9";
    
    $con = new PDO("mysql:host=$servername;dbname=$database", $conusername, $conpassword);
    
    if(!empty($username) && !empty($password)){
        $query = $con->prepare("SELECT * FROM accounts WHERE username = :user");
        $query->bindParam(':user',$username);
        $query->execute();
        
        $data = $query->fetch(PDO::FETCH_ASSOC);
        
        $hashedpass = $data["password"];
        if (password_verify($password, $hashedpass)) {
            $_SESSION["username"] = $username;
        } else {
            $_SESSION["error"] = "Incorrect login credentials";
        }
    } else {
        $_SESSION["error"] = "Please enter your username and password";
    }
    
    header("Location: /");
?>
