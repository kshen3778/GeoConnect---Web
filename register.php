<?php
    session_start();
    
    $_SESSION["error"] = null;
    
    $user = $_POST["username"];
    $pass = $_POST["password"];
    $email = $_POST["email"];
    
    $servername = getenv('IP');
    $username = getenv('C9_USER');
    $password = "";
    $dbname = "c9";
    		
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    			
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //check if user inputted
    if(!empty($user) && !empty($email) && !empty($pass)){
        //check if username is taken
    	$check = $conn->prepare("SELECT * FROM accounts WHERE username=:user");
    	$check->bindParam(':user',$user);
    	$check->execute();
        $result = $check->fetch(PDO::FETCH_ASSOC);
        
        //check if username is taken
    	$check2 = $conn->prepare("SELECT * FROM accounts WHERE email=:email");
    	$check2->bindParam(':email',$email);
    	$check2->execute();
    	$result2 = $check2->fetch(PDO::FETCH_ASSOC);
    	
    	var_dump($result);
    	var_dump($result2);
        
        if(!empty($result) || !empty($result2)){
            
            $_SESSION["error"] = "This email or username is already taken.";
            header("Location: /");
            exit;
        }
        
        $query = $conn->prepare("INSERT INTO accounts (username, password, email) VALUES (:user,:hash,:email) ");
        $query->bindParam(':user',$user);
        $query->bindParam(':hash',$hash);
        $query->bindParam(':email',$email);
        $query->execute();
        
        $_SESSION['username'] = $user;
    
    } else {
        $_SESSION["error"] = "Please enter a username and email";
    }
    
    header("Location: /");
?>
