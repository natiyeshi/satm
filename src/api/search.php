<?php 
 require_once "../php/db.php";
 require_once "../php/functions.php";
sleep(1);
 function get_profile2($file){
    $numOfLines = count(file("../usersProfile/$file.txt"));
    $file = fopen("../usersProfile/$file.txt","r");
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

 session_start();
 $userId = $_SESSION["userId"];

 if(isset($_POST["username"])){
    $username = $_POST["username"];
    $sql = "SELECT users.username,users.userId,profile.profileImagesFile
                FROM users left join profile on profile.userId = users.userId
                WHERE users.username LIKE '$username%'  and  users.userId <> '$userId'";
    
    $searchedData = get_data($sql,$conn,false);
    $fetcedData = "";
    while($row = $searchedData->fetch_assoc()){
        // if(blocked_user($row["userId"],$blockUsers) == true)
        //     continue;
       $sql = "SELECT * FROM setting WHERE userId = '$userId'";
       $blocked = get_data($sql,$conn);
       if(blocked_user($row["userId"],$blocked["blockedUsers"]) == true)
          continue;
       $sql = "SELECT * FROM setting WHERE userId = '".$row["userId"]."'";
       $blocked = get_data($sql,$conn);
       if(blocked_user($userId,$blocked["blockedUsers"]) == true)
           continue;
       $fetcedData .='
       <div class="user-files mt-2"  >
             <div class="user-img">
                    <img src="'.get_profile2($row["profileImagesFile"]).'" id="addedImage" class="user-image rounded-circle p-1" alt="">
                </div>
                <div class="user-name mt-4"> '.$row["username"].' </div>
                <div class="add text-center mt-3">
                    <div class=""> 
                        <button type ="submit" value = '.$row["userId"].' class="border-0 btn btn-success"  name = "searchedData">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0z"/>
                            </svg> 
                        </button>
                       
                    </div>
                </div>
            </div>';
    }
    echo $fetcedData == "" ? "file not found" : $fetcedData;
} else {
    
}
