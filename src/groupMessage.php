<?php 
function get_group_members($file){
   $file = fopen("groupMembers/".$file.".txt","r");
   $arr = [];
   while(!feof($file))
      $arr[] = fgets($file);
    return $arr;
}

require_once "php/main_php.php";

$groupChatId = $_SESSION["goToGroup"];

$sql = "SELECT * FROM groups where groupId = '$groupChatId'";
$aboutGroup = get_data($sql,$conn);
$groupCreator = get_data("SELECT * from profile where userId = '".$aboutGroup['adminId']."'",$conn);
$groupCreatorImage = get_profile($groupCreator["profileImagesFile"]);

$groupMembers = get_group_members($aboutGroup["membersFile"]);

$showMembers = "";

foreach($groupMembers as $m){
    $sql = "SELECT users.userId,users.username,profile.profileImagesFile,
             setting.gostMode,setting.lastSeen,setting.online
             FROM users 
             left join profile on users.userId = profile.userId
             left join setting on users.userId = setting.userID
             WHERE users.userId = '$m'";
    
    $row = get_data($sql,$conn);
    if($row == "" || $row["userId"] == $userId)
        continue;
    if($row["gostMode"] == 0){
        if($row["online"] == "on"){
            $online = "<div class='rounded-circle p-1 text-bg-success ms-5 mt-3' style='width:10px;'></div>";
        } else {
            $online = "<div class='rounded-circle p-1'>".$row["lastSeen"]."</div>";
        }
    } else {
        $online = "";
    }
    $profile = get_profile($row["profileImagesFile"]);
    $border = "btn-light";
    if($groupCreator["userId"] == $row["userId"]){
        $border = "btn-primary";
    }
    $showMembers .= '<button type = "submit" name = "seeProfileFromGroup" value = "'.$row["userId"].'" class="user-files mt-2 '.$border .'">
            <div class="user-img">
                <img src="'.$profile.'" class="user-image rounded-circle" alt="">
            </div>
            <div class="user-name mt-4">  '.$row["username"].'</div>
            <div class="add text-center mt-3">
             <div class=""> 
                '.$online.'
             <!--       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0z"/>
                    </svg> 
                    --></div>
            </div>
            </button>';
}   



$sql = "SELECT * FROM groupMessage WHERE groupId = '$groupChatId'";
$allGroupMessages = get_data($sql,$conn,false);

$sendMessages = "";
$counter = 0;
while($row = $allGroupMessages->fetch_assoc()){
    $counter++;
    if($row["senderId"] == $userId){
        $sendMessages .= '<div class="sender-message"><div class="text-image">';
        if($row["img"] != "" and $row["img"] != NULL){
            $sendMessages .= '<img src="groupMessageImages/'.$row["img"].'" class="message-image">';
        }
        $sendMessages .=' </div> <div class="text-message me-3"> ';
        if($row["message"] != "")
            $sendMessages .= $row["message"];
        $sendMessages .= "<br><span class='w-100' style='color: #929292;'><small>".$row["sendAt"]."</small><span>";
        $sendMessages .= '</div></div>';
    } else {
        $sendMessages .='<div class="reciever-message"><div class="reciever-message-main"><div class="text-image">';
        if($row["img"] != "" and $row["img"] != NULL){
            $sendMessages .= '<img src="groupMessageImages/'.$row["img"].'" class="message-image">';
        }
        $sendMessages .='</div><div class="text-message"> ';
        if($row["message"] != "")
            $sendMessages .=' hi how are you?';
        $sql = "SELECT * from profile WHERE userId = '".$row['senderId']."'";
        $result = get_data($sql,$conn);
        $senderProfile = get_profile($result["profileImagesFile"]);
        $sendMessages .='<br><span class="me-3 w-100" style="color: #929292;"><small>'.$row["sendAt"].'</small><span></div></div>
            <form method = "POST" action = "groupMessage.php" class="chat-img">
               <button type = "submit" value = "'.$row["senderId"].'" name = "seeProfileFromGroup" class = " border-0 rounded-circle overflow-hidden" style="height:60px; width:60px;" >
                <img src="'.$senderProfile.'" class="" height="60px" width="60px" alt="">
                </button>    
            </form>
            </div>
        ';
    }
}


if(isset($_POST["send"])){
    $text = secure($_POST["text"]);
    $image = $_FILES["image"]["tmp_name"];
    if($text == "" and $image == ""){
        echo "<script>alert('empty')</script>";
    } else{
        $imageName = uniqid();
        if($image == ""){
            $stmt = $conn->prepare("INSERT INTO groupMessage
                    (groupId,message,senderId) VALUES
                    ('$groupChatId','$text','$userId')");
            $stmt->execute();
            header("Refresh: 0");
        } else if(move_uploaded_file($image,"groupMessageImages/$imageName")){
            $stmt = $conn->prepare("INSERT INTO groupMessage
                    (groupId,message,img,senderId) VALUES
                    ('$groupChatId','$text','$imageName','$userId')");
            $stmt->execute();
            header("Refresh: 0");
        }
    }
}

if(isset($_POST["seeProfileFromGroup"])){
    $_SESSION["seeUserProfile"] = $_POST["seeProfileFromGroup"];
    echo "<script>location.href='seeProfile.php'</script>";
}
else if(isset($_POST["searchedData"])){
    $searchedDataId = $_POST["searchedData"];
    $_SESSION["seeUserProfile"] = $searchedDataId;
    header("Location: seeProfile.php");
}



?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>groupMessage</title>
        <!-- Favicon-->
        <!-- <link rel="icon" type="image/x-icon" href="assets/favicon.ico" /> -->
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
         <!-- Bootstrap core JS-->
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" defer></script>
         <!-- Core theme JS-->
         <script src="script/scripts.js" defer></script>
         <link rel="stylesheet" href="../asset/css/bootstrap.css">
         <link rel="stylesheet" href="css/groupMessage.css">
         <script src="js/common.php" defer></script>

         <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script> 
         <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script> 
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>

    </head>
    <body class=".scrollbar-hidden bg-dark">
        <div class="d-flex" id="wrapper"  style="max-height:110vh; overflow:hidden;">
            <!-- Sidebar-->
            <div class="border-end sub-side" id="sidebar-wrapper" >
                <div class="sidebar-heading border-bottom main_color profile center">
                    <div class="col" onclick="location.href = 'index.php'">
                        <img src="<?php echo $profileImage; ?>" alt="..." 
                        class="profile-image text-center rounded-circle"/>
                    </div>
                    <div class="col">
                        <div class="username"><?php echo $username ?></div>
                        <div class="username-info"><?php $bio?></div>
                    </div>
                </div>
                <div class="list-group list-group-flush fixed ">
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 sub-side" href="myProfile.php">profile</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 sub-side" data-toggle="modal" data-target=".createGroup">Create Group</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 sub-side" data-toggle="modal" data-target=".gostMode" >Gost</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 sub-side" href="setting.php">Setting</a>
                </div>
            </div>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper">
                <!-- Top navigation-->
                <nav class="navbar navbar-expand-lg main_color border-bottom">
                    <div class="container-fluid ">
                        <button class="btn" id="sidebarToggle">
                            
                            <img src="../asset/photo/Screenshot__91_-removebg-preview.png" width="100px" alt="">
                        </button>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="btn ms-1 btn-light" onclick="location.href='groupList.php'">
                            Back
                        </div>
                        <div class="center satm">
                            Student Assignment And Test Maker   
                        </div>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                                <li class="nav-item"><a class="nav-link text-white" type="button" href="index.php">users</a></li>
                                <li class="nav-item"><a class="nav-link text-white" type="button" href="groupList.php">groups</a></li>
                                <li class="nav-item "><a class="nav-link text-white" href="#!" data-bs-toggle="modal" data-bs-target="#exampleModal">Logout</a></li>
                                <li class="nav-item"><a class="nav-link text-white" type="button" data-toggle="modal" data-target=".bd-example-modal-lg">search</a></li>
                            
                            </ul>
                        </div>
                    </div>
                </nav>
                <nav>
                    <div class="sticky-top btn btn-dark sender-pro text-bg-dark p-2" data-toggle="modal" data-target=".groupModal" style="z-index: 0;">
                        <div class="chat-img">
                            <img src="../asset/photo/Screenshot__91_-removebg-preview.png" width="60px" class="rounded-circle" alt="" srcset="">
                        </div>
                        <div class="chat-username text-primary mt-2 " style="font-weight:bold;">
                             <?php echo $aboutGroup["groupName"] ?> 
                         </div>
                         <div class="chat-username  text-center">
                            Creater <img src="<?php echo $groupCreatorImage; ?>" height="50px" width="50px" class="ms-2 rounded-circle" style="border:4px solid white;" alt="">      
                        </div> 
                    </div>

                     </nav>
        
                <!-- Page content-->
                <div class="container-fluid  p-0 message-background" style="max-height: 78vh;">
                                     
                    <?php 
                    if($counter < 5){
                        echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
                    }
                    echo $sendMessages;
                    
                    ?>

                        <a id="gos" href="#go"></a>
                        <div id="go"></div>
                        <script>
                            document.getElementById("gos").click();
                        </script>
                    <!-- send -->
                    <div class="send sticky-bottom">
                        <form action="groupMessage.php" method="POST" class="send-form d-flex" enctype="multipart/form-data">
                            <input class="send-input m-2"  placeholder="send txt" name="text">
                            <input class="m-2 custom-file-input" style="width: fit-content;" name="image" type="file" >
                            <button class="btn btn-outline-light m-2 w-25" type="submit" name="send"> 
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                                    <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                                  </svg>
                            </button>
                        
                        </form>
                    </div>

                </div>
            </div>
        </div>
       
    </body>

    <!-- modals -->
    <!-- group -->
<!-- <button type="button" class="btn btn-primary" >Large modal</button> -->

<div class="modal fade groupModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="overflow-x: scroll;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content p-2">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><?php echo $aboutGroup["groupName"]; ?></h5>
            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <div class="modal-body-right">
                <div class="modal-right-topic text-center"> Members</div>
                <form action="groupMessage.php" method="POST" class="members">
                    <!-- members -->
                   
                    <?php echo $showMembers; ?>

                    <!-- end members -->

                </form>
            </div>

        </div>
        <div class="modal-footer">
          
        </div>
      </div>
    </div>
  </div>
    <!-- group end -->
 <!-- search -->

  <!-- create group -->

  <div class="modal fade createGroup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content p-2">
          <div class="modal-header">
              <h5 class="modal-title">Create Group</h5>
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" onclick="clearAddedMembers()"></button>
           </div>
          <div class="modal-body">
              
                  <label for="">Group Name<input type="text" id="groupName" class="m-2"></label> 
                  <span class="addedMembersProfile" style="max-width:100px; width: 100px; overflow-x: hidden;">
                    
                  </span><br>
                  <label for="">Add Members </label>
                  <div class="members-class">
                    <?php echo $userForGroup; ?>
                      
                  </div>
          </div>
          <div class="modal-footer">
              <button type="submit" id="createGroup" class="btn btn-success">Create</button>
            </div>
            

      </div>
    </div>
  </div>
    <!-- crete group end -->
        <!-- Gost -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".gostMode">Small modal</button> -->
<div class="modal fade gostMode" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm">
  <div class="modal-content">
    <div class="modal-body text-center">
      <div class="modal-header">
          <h5 class="modal-title">Gost Mode</h5>
      </div>
      <div class="form-check form-switch mt-3">
          <label class="form-check-label float-start" for="flexSwitchCheckChecked">Hide Your Identity</label>
          <input class="form-check-input float-end" type="checkbox" id="gostMode" value="<?php echo $userId?>">
      </div>

    </div>
  </div>
</div>
</div>
 
  <!-- Gost end -->
  <!-- logout -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Log Out</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are You Sure You Want To Log Out ?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <a type="button" class="btn btn-danger" onclick="logout()" >Log Out</a>
        </div>
      </div>
    </div>
  </div>

<!-- end logout -->
<!-- search -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Large modal</button> -->

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lm">
      <div class="modal-content p-2">
          <div class="modal-body text-center">
              username <input type="text" id="searchInputField" onkeyup="searchData(this.value)" class="w-50">
               <!-- <button type="button" class="btn btn-success" data-dismiss="modal">Search</button> -->

          </div>
          <form class="modal-footer searchData" method="POST" action="<?php echo $_SERVER["PHP_SELF"] ?>"> 
            

        </form>
      </div>
    </div>
  </div>
  <!-- end search -->
  <!-- modals end -->

</html>
<script>
    let Gid = '<?php echo $groupChatId ?>';
    let CHECKUPDATE
    (function(){
        let xml = new XMLHttpRequest()
        xml.open("POST","api/groupMessageUpdate.php")
        xml.setRequestHeader("Content-type","application/x-www-form-urlencoded")
        xml.onload = function(){
            if(this.status == 200){
                CHECKUPDATE = this.responseText
            }
        }
        xml.send("groupId="+Gid)
    })()

    function checker(){
          let xml = new XMLHttpRequest()
        xml.open("POST","api/groupMessageUpdate.php")
        xml.setRequestHeader("Content-type","application/x-www-form-urlencoded")
        xml.onload = function(){
            if(this.status == 200){
                if(CHECKUPDATE != this.responseText){
                    location.reload()
                } 
            }
        }
        xml.send("groupId="+Gid)
    }
    setInterval(checker,1000)
   
    </script>