<?php
require_once "../php/functions.php";
require_once "../php/db.php";

session_start();
$userId = $_SESSION["userId"];

function num($sql,$conn){
     
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
        $reciver = $_POST["recieverId"];
        
        $sql = "SELECT COUNT(message) FROM userMessage
                WHERE (senderId = '$userId' and recieverId = '$reciver')
                or (senderId = '$reciver' and recieverId = '$userId')";
        $num = get_data($sql,$conn);
        $len = $num["COUNT(message)"];
        
        echo $len;
}