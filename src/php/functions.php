<?php
function get_data($sql,$conn,$bool = true){
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    if($bool == true)
        return $result->fetch_assoc();
    return $result; 
}

function isExist($sql,$file,$conn){
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$file);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows == 0 ? false : true;
}

function get_profile($file){
    $numOfLines = count(file("usersProfile/$file.txt"));
    $file = fopen("usersProfile/$file.txt","r");
    while(!feof($file)){
        $profileImage = fgets($file);
    }
    fclose($file);
    if($numOfLines == 1)
        $profileImage = "profileImages/$profileImage.jpg";
    else 
        $profileImage = "profileImages/$profileImage";
    return $profileImage;    
}

function blocked_user($username,$blocked){
    $bUsers = explode("||",$blocked);
    return in_array($username,$bUsers) == true ? true : false;
}

function secure($data){
    $data = htmlspecialchars($data);
    $data = stripslashes($data);
    return $data;
}

function returnNotifications($name,$bool = true){
    $path = $bool == true ? "../notificationFiles/$name.txt" : "notificationFiles/$name.txt"; 
    $file = fopen($path,"r");
    $allFile = [];
    while(!feof($file)){
        $allFile[] = fgets($file);
    }
    return $allFile;
}

function getNotificationFile($id,$conn){
    $sql = "SELECT notifications FROM profile WHERE userId = '$id'";
    $fileName = get_data($sql,$conn);
    return $fileName["notifications"];
}

function addNotification($not,$fileName,$bool = true){
    $path = $bool == true ? "../notificationFiles/$fileName.txt" : "notificationFiles/$fileName.txt"; 
    $file = fopen($path,"a");
    fwrite($file,$not);
    fclose($file);
}

function deleteNotification($not,$fileName){
    $file = fopen("../notificationFiles/$fileName.txt","a");
    $newFile = [];
    while(!feof($file)){
        $line = fgets($file);
        if($not != $line){
            $newFile[] = $line;
        }
    }
    fclose($file);
    $file = fopen("../notificationFiles/$fileName.txt","w");
    foreach($newFile as $f){
        fwrite($file,$f);
    }
    fclose($file);
}
