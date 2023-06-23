<?php

require_once "../php/db.php";
require_once "../php/functions.php";

function isExists($sql,$file,$conn){
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$file);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows == 0 ? false : true;
}


session_start();
$userId = $_SESSION["userId"];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $groupMembers = explode(",",$_POST["file"]);
    $groupName = $_POST["groupName"];
    if(isExists("SELECT * FROM groups WHERE groupName = ?",$groupName,$conn) == true){
        echo "false";
    } else {
        $fileName = uniqid();
        $file = fopen("../groupMembers/".$fileName.".txt","w");
        fwrite($file,$userId);
        foreach($groupMembers as $i){
            fwrite($file,"\n".$i);
        }
        foreach($groupMembers as $i){
            $fname = getNotificationFile($i,$conn);
            addNotification("group||$userId\n",$fname);
        }
        
        fclose($file);
        $stmt = $conn->prepare("INSERT INTO groups (membersFile,adminId,groupName) 
                                VALUES  ('$fileName','$userId','$groupName')");
        $stmt->execute();    
        echo "true";
    }
}