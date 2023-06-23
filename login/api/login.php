<?php 

require_once "../php/db.php";

function secure($data){
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    return $data;
}

function isExist($sql,$file,$conn){
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$file);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows == 0 ? false : true;
}

function isUser($username,$password,$conn){
    $pass = false;
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()){
        if(password_verify($password,$row["password"])){
            $pass = true;
        }
    }
    return $pass;
}

function getUserId($username,$conn){
    $stmt = $conn->prepare("SELECT userId FROM users WHERE username = ?");
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()){
       $userId = $row["userId"];
    }
    return $userId;
}


if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = secure($_POST["username"]);
    $password = secure($_POST["password"]);
    $bool = isExist("SELECT * FROM users WHERE username = ?",$username,$conn);
    $send = [];
    if($bool == true){
        if(isUser($username,$password,$conn) == true){
            $send["form"] = true;
            $userId = getUserId($username,$conn);
            $stmt = $conn->prepare("UPDATE setting SET online = 'on' WHERE userId = '$userId'");
            $stmt->execute();
            session_start();
            $_SESSION["userId"] = $userId;    
        } else {
            $send["form"] = false;
        }
    } else {
        $send["form"] = false;
    }
    echo json_encode($send);
}