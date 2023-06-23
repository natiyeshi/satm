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

function get_data($sql,$conn,$bool = true){
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    if($bool == true)
        return $result->fetch_assoc();
    return $result; 
}

function addNotification($not,$fileName){
    $file = fopen("../../src/notificationFiles/$fileName.txt","a");
    fwrite($file,$not);
    fclose($file);
}

function send($username,$password,$image,$conn){
    $hash = password_hash($password,PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users(username,password) VALUES(?,?)");
    $stmt->bind_param("ss",$username,$hash);
    $stmt->execute();
    $stmt->close();
    $profile_file = uniqid();
    $file = fopen("../../src/usersProfile/{$profile_file}.txt","a");
    fwrite($file,$image);
    fclose($file);
    $stmt = $conn->prepare("SELECT userId FROM users WHERE username = ?");
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $result = $stmt->get_result();
    $userId = "";
    while($row = $result->fetch_assoc()){
        $userId = $row["userId"];
    }
    $stmt->close();
    $stmt = $conn->prepare("INSERT INTO profile(userId,profileImagesFile) VALUES('$userId','$profile_file')");
    $stmt->execute(); 
    $stmt->close();
    $stmt = $conn->prepare("INSERT INTO setting(userId,online) VALUES('$userId','on')");
    $stmt->execute();
    $fileName = uniqid();
    addNotification("joined||$userId\n",$fileName);
    $stmt = $conn->prepare("UPDATE profile set notifications = '$fileName' WHERE userId = '$userId'");
    $stmt->execute();
    return $userId;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = secure($_POST["username"]);
    $password = secure($_POST["password"]);
    $image = secure($_POST["image"]);
    $bool = isExist("SELECT * FROM  users WHERE username = ?",$username,$conn);
    $send = array();
    if($bool == false){
        $userId = send($username,$password,$image,$conn);
        $send["form"] = true;
        session_start();
        $_SESSION["userId"] = $userId;

    } else{
        $send["form"] = false;
    }
    echo json_encode($send);
}
