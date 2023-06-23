<?php 
require_once "../php/db.php";
require_once "../php/functions.php";
session_start();
$userId = $_SESSION["userId"];
if($_SERVER["REQUEST_METHOD"] == "POST"){
   
    $imgName = $_POST["deletedImage"];
    $sql = "SELECT * FROM profile WHERE userId = '$userId'";
    $profileFile = get_data($sql,$conn);
    $file = fopen("../usersProfile/".$profileFile["profileImagesFile"].".txt","r");
    $newfile = [];
    while(!feof($file)){
        $line = fgets($file);
        if($line != $imgName && $line != $imgName."\n"){
            $newfile[] = $line;
        } 
    }
    fclose($file);
    $file = fopen("../usersProfile/".$profileFile["profileImagesFile"].".txt","w");
    $counter = 0;
    foreach($newfile as $nn){
        $ww = explode("\n",$nn);
        $ff = ($ww[0]);
        fwrite($file,"$ff");
        if(++$counter != count($newfile)){
            fwrite($file,"\n");
        }
    }
    if(unlink("../profileImages/$imgName")){
        echo "yep";
    }
    fclose($file);
}