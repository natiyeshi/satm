<?php 
require_once "../php/db.php";

session_start();
$userId = $_SESSION["userId"];

function isExist($sql,$file,$conn){
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$file);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows == 0 ? false : true;
}


function secure($data){
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    return $data;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = secure($_POST["name"]);
    $value = secure($_POST["value"]);
    if($name == "username"){
        if(isExist("SELECT * FROM users WHERE username = ?",$value,$conn) == FALSE){
            $stmt = $conn->prepare("UPDATE users SET username = '$value' WHERE userId = '$userId'");
            $stmt->execute();
            echo "true";
        } else {
            echo "false";
        }
    } else {
        $stmt = $conn->prepare("UPDATE profile SET $name = '$value' WHERE userId = '$userId'");
        $stmt->execute();
        echo "true";
    }
}