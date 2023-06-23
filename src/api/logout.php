<?php 

require_once "../php/db.php";

session_start();
$userId = $_SESSION["userId"];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $loged_out_time = date('H:i',time() + 3600);
    $stmt = $conn->prepare("UPDATE setting SET lastSeen = '$loged_out_time',
                             online = 'off' WHERE userId = '$userId'");
    $stmt->execute();
    session_start();
    session_destroy();
    session_unset();
    echo "success";
}