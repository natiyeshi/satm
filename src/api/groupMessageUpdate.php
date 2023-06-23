<?php
require_once "../php/functions.php";
require_once "../php/db.php";

session_start();
$userId = $_SESSION["userId"];

if($_SERVER["REQUEST_METHOD"] == "POST"){
        $groupId = $_POST["groupId"];
        
        $sql = "SELECT COUNT(message) FROM groupMessage
                WHERE groupId = '$groupId'";
        $num = get_data($sql,$conn);
        $len = $num["COUNT(message)"];
        
        echo $len;
}