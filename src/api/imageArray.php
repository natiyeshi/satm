<?php 

require_once "../php/db.php";
require_once "../php/functions.php";
if($_SERVER["REQUEST_METHOD"] == "POST" or 1){
    session_start();
    $userId = $_POST["otherUserId"] ?? $_SESSION["userId"];

    $sql = "SELECT * FROM profile WHERE userId = '$userId'";
    $profileFile = get_data($sql,$conn);

    $file = fopen("../usersProfile/".$profileFile["profileImagesFile"].".txt","r");
    $arr = [];
    while(!feof($file)){
        $arr[] = fgets($file);
    }
    echo json_encode($arr);
}
