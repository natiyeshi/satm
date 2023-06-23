<?php 

require_once "../php/db.php";
require_once "../php/functions.php";

session_start();
$userId = $_SESSION["userId"];

if($_SERVER["REQUEST_METHOD"] == "GET"){
    $unBlockedId = $_GET["id"];
    $sql = "SELECT * FROM setting WHERE userId = '$userId'";
    $result = get_data($sql,$conn);
    $blockedUsers = explode("||",$result["blockedUsers"]);
    $uploadedFile = "";
    foreach($blockedUsers as $b){
        if($b == $unBlockedId or $b == "")
            continue;
        $uploadedFile .= $b."||";
    }
    $stmt = $conn->prepare("UPDATE setting SET blockedUsers = '$uploadedFile' WHERE userId = '$userId'");
    $stmt->execute();
    $fName = getNotificationFile($unBlockedId,$conn);
    addNotification("unblocked||$userId\n",$fName);
    echo "true";
}