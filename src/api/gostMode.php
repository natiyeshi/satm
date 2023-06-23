<?php 

require_once "../php/db.php";

function get_data($sql,$conn,$bool = true){
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    if($bool == true)
        return $result->fetch_assoc();
    return $result; 
}


session_start();
$userID = $_SESSION["userId"];

if($_SERVER["REQUEST_METHOD"] == "POST"){

   $state = get_data("SELECT * FROM setting WHERE userId = '$userID'",$conn);
   $changedState = $state["gostMode"] == 0 ? 1 : 0;
   
   $stmt = $conn->prepare("UPDATE setting SET gostMode = '$changedState' WHERE userId = '$userID'");
   $stmt->execute();
}
else if($_SERVER["REQUEST_METHOD"] == "GET"){

    $state = get_data("SELECT * FROM setting WHERE userId = '$userID'",$conn);
    $changedState = $state["gostMode"] == 0 ? 0 : 1;
    echo $changedState;
}