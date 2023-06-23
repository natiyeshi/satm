<?php 

require_once "../php/db.php";
require_once "../php/functions.php";

session_start();
$userId = $_SESSION["userId"];
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["file"])){
        $value = $_POST["file"];
        $values = explode(",",$value);
        $fullArray = [];
        foreach($values as $row){
            $sql = "SELECT COUNT(message) from usermessage
                where (senderId = '$userId' and recieverId = '$row')
                or (senderId = '$row' and recieverId = '$userId'); ";
            $count = get_data($sql,$conn);
            $fullArray[] = $count["COUNT(message)"];
        }
        echo json_encode($fullArray);

    } elseif(isset($_POST["holdValues"])){
       $holdValues = ($_POST["holdValues"]);
       $chatIds = $_POST["chatIds"];
       $holdValues = explode(",",$holdValues);
       $chatIds = explode(",",$chatIds);
        $newArray = [];
       foreach($chatIds as $row){
            $sql = "SELECT COUNT(message) from usermessage
                where (senderId = '$userId' and recieverId = '$row')
                or (senderId = '$row' and recieverId = '$userId'); ";
            $count = get_data($sql,$conn);
            $newArray[] = $count["COUNT(message)"];
        }
        $index = 0;
        $return = true;
        foreach($newArray as $f){
            if($f != $holdValues[$index++]){
                $return = false;
            }
        }
        echo $return;
    }
    

}