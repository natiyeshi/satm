<?php 

require_once "db.php";
require_once "functions.php";


session_start();
$userId = $_SESSION["userId"];
if(!isset($_SESSION["userId"]) || $_SESSION["userId"] == ""){
    header("Location: ../login/login.html");
}
$user  = get_data("SELECT * FROM users WHERE userId = '$userId'",$conn,true);
$profile = get_data("SELECT * FROM profile WHERE userId = '$userId'",$conn,true);
$setting = get_data("SELECT * FROM setting WHERE userId = '$userId'",$conn,true);

if($profile["bio"] == NULL or $profile["bio"] == "")
    $bio = "no bio";
else 
    $bio = $profile["bio"];
    

$profileFile = $profile["profileImagesFile"];
$profileImage = get_profile($profileFile);
$username = $user["username"];
$gostMode = $setting["gostMode"];
$blockUsers = $setting["blockedUsers"];

$userForGroup = "";

$sql = "SELECT users.userId,users.username,
        profile.profileImagesFile FROM users
        left join profile on
        users.userId = profile.userId 
        WHERE users.userId <>'$userId'";

$result = get_data($sql,$conn,false);
$newUsers = "";
while($row = $result->fetch_assoc()){
    if(blocked_user($row["userId"],$blockUsers) == true)
        continue;
    $userForGroup .= '  <div class="user-files mt-2" id="parent'.$row["userId"].'">
                <div class="user-img">
                    <img src="'.get_profile($row["profileImagesFile"]).'" id="addedImage'.$row["userId"].'" class="user-image rounded-circle" alt="">
                </div>
                <div class="user-name mt-4">  '.$row["username"].'</div>
                <div class="add text-center mt-3">
                    <div class=""> 
                        <button  class="border-0 btn btn-success" onclick="addMember(this)" value = "'.$row["userId"].'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0z"/>
                            </svg> 
                        </button>
                       
                    </div>
                </div>
            </div>';

    $sql = "SELECT lastMessage FROM usermessage WHERE 
        (senderId = '$userId' and recieverId = '".$row["userId"]."')
        OR (senderId = '".$row["userId"]."' and recieverId = '$userId') ";
    $is_there = get_data($sql,$conn,false);
    $is_there_bool = 0;
    while($r = $is_there->fetch_assoc()){
        if($r["lastMessage"] == 1 || $r["lastMessage"] == "1"){
            $is_there_bool = 1;
            break;      
        }        
    }
    if($is_there_bool == 0){
        $newUsers .= '  <div class="user-files mt-2" id="parent'.$row["userId"].'">
                <div class="user-img">
                    <img src="'.get_profile($row["profileImagesFile"]).'" id="addedImage'.$row["userId"].'" class="user-image rounded-circle" alt="">
                </div>
                <div class="user-name mt-4">  '.$row["username"].'</div>
                <div class="add text-center mt-3">
                    <div class=""> 
                        <button  class="border-0 btn btn-success" type = submit name = addUser value = "'.$row["userId"].'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0z"/>
                            </svg> 
                        </button>
                       
                    </div>
                </div>
            </div>';
    }
    
}
