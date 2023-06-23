<?php 

require_once "php/main_php.php";
require_once "php/modals.php";
function block_modal($userId,$username,$profileImage){
    return ' <div class="modal fade DeleteUser'.$userId.'" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content p-2">
          <div class="modal-header">
              <h5 class="modal-title">Block User</h5>
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
           </div>
          <div class="modal-body">
              <form action="'.$_SERVER["PHP_SELF"].'" method="POST" >
                  <label for="">Are You Sure You Want To Delete '.$username.'</label>
                  <div class="members-class">
                    <div class="user-files mt-2">
                        <div class="user-img">
                            <img src="'.$profileImage.'" class="user-image rounded-circle" alt="">
                        </div>
                        <div class="user-name mt-4">  '.$username.'</div>
            
                        </div>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-danger" name="deleteUser" value='.$userId.'>Block</button>

              </form>
          </div>
        
      </div>
    </div>
  </div>';
}

function new_sort($file,$userId){
    $arr = [];
    while($row = $file->fetch_assoc()){
        if($row["senderId"] == $userId){
            $arr[] = $row["recieverId"];
        } if($row["recieverId"] == $userId){
            $arr[] = $row["sender"];
        }
    }
    return array_values(array_unique($arr));

}

$blockModal = "";

$sql = "SELECT * FROM userMessage 
        WHERE lastMessage = '1' 
        ORDER BY sendAt DESC";

$notificationSort = new_sort(get_data($sql,$conn,false),$userId);

$sql = "SELECT users.username,users.userId,profile.profileImagesFile,
        setting.online,setting.gostMode,setting.lastSeen FROM users 
        left join profile on users.userId = profile.userId
        left join setting on users.userId = setting.userId
        WHERE users.userId <>".$userId.";";

$displayUsers = "";
$allUsers = get_data($sql,$conn,false);

$counter = 0;
while($row = $allUsers->fetch_assoc()){
    $newarr[$counter]["userId"] = $row["userId"];
    $newarr[$counter]["lastSeen"] = $row["lastSeen"];
    $newarr[$counter]["username"] = $row["username"];
    $newarr[$counter]["profileImagesFile"] = $row["profileImagesFile"];
    $newarr[$counter]["online"] = $row["online"];
    $newarr[$counter++]["gostMode"] = $row["gostMode"];
}

$file = 0;
$theLastOne = [];
$z = count($notificationSort);

while($z--){
    foreach ($newarr as $key => $value) {                  
            if($notificationSort[$file] == $value["userId"]){ 
                $theLastOne[$file]["userId"] = $value["userId"];
                $theLastOne[$file]["username"] = $value["username"];
                $theLastOne[$file]["lastSeen"] = $value["lastSeen"];
                $theLastOne[$file]["profileImagesFile"] = $value["profileImagesFile"];
                $theLastOne[$file]["online"] = $value["online"];
                $theLastOne[$file++]["gostMode"] = $value["gostMode"];
                if($file >= count($notificationSort)){
                    break;
                    }   
            }
    }
    if($file >= count($notificationSort)){
        break;
    }  
}

if($theLastOne != null){
  foreach ($theLastOne as $key => $row) {
    if(blocked_user($row["userId"],$blockUsers) == true)
        continue;
    $sql = "SELECT blockedUsers from setting WHERE userId = '".$row['userId']."'";
    $result = get_data($sql,$conn);
    if(blocked_user($userId,$result["blockedUsers"])){
        continue;   
    }
    $sql = "SELECT * FROM usermessage WHERE 
        (senderId = '$userId' and recieverId = '".$row["userId"]."')
        OR (senderId = '".$row["userId"]."' and recieverId = '$userId') 
        ORDER BY sendAt DESC LIMIT 1";
    
    $lastMessage = get_data($sql,$conn,true);
    $message = ""; 
    $sql = "SELECT seen,UMId FROM usermessage WHERE 
        ((senderId = '$userId' and recieverId = '".$row["userId"]."')
        OR (senderId = '".$row["userId"]."' and recieverId = '$userId'))
        and sender = '".$row['userId']."' 
        ORDER BY sendAt DESC";
    
    $seenShow = get_data($sql,$conn,false);
    $seen = '';
    
    if($seenShow != NULL){
        if($seenShow == null or $seenShow == "")
            $seen = '';
        else{
            $val = 0;
            while($r = $seenShow->fetch_assoc()){
                $val += $r["seen"];
            }
            if($val > 0)
              $seen =  '<div class = "notification-show"><small>'.$val.'</small></div>';
        }
    } 

    if($lastMessage !== "" and $lastMessage !== NULL){
        $message = $lastMessage["senderId"] == $userId ? "<span class='senderYou'>  </span>" : "";
        $message .= $lastMessage["message"] == "" ? "photo" : $lastMessage["message"];
      } else {
        $message = "";
    }
    $blockModal .= block_modal($row["userId"],$row["username"],get_profile($row["profileImagesFile"]));
    
    $online = $row["online"] == "on" && $row["gostMode"] == 0 ? true:false;
    $online1 = $online2 = "";
    if($online == true){
        $online1 = '<div class="light" style="background-color:green;" ></div>';
        $online2 = ""; 
    } else {
        $online2 = '<small class="m-2" style="color:#C2C2C2; z-index:1;">'.$row["lastSeen"].'</small>';
        $online1 = ""; 
    }
    

    $displayUsers .= '<form class="bg-dark message" action='.$_SERVER["PHP_SELF"].' method = POST >
                        
                        <button class="message-image bg-dark border-0 allButtonIds" type=submit name=seeProfile value='.$row["userId"].'>
                            <div class="line">
                                <div class="sender-username">'.$row["username"].'</div>
                                '.$online1.'
                            </div>
                                <img style="z-index:1;" src="'.get_profile($row["profileImagesFile"]).'" alt="" class="message-main-image rounded-circle p-0">
                        </button>
                        <button class="message-main bg-dark " type=submit name=seeMessage value='.$row["userId"].'  style="cursor:pointer; border:none;">
                            <br>
                               '.$message.' sss
                        </button>
                        <div class="message-notification center"> <br>
                            '.$seen.'
                        </div>
                        <div class="message-delete center"> <br> 
                            <div class="bg- "> 
                            '.$online2.'
                            </div>
                            <div class="delete">
                                <button type=button  class="btn btn-danger border-0" data-toggle="modal" data-target=".DeleteUser'.$row["userId"].'" name="delete" value='.$row["userId"].'> 
                                <svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-trash3" viewBox="0 0 16 16">
                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                                </svg>
                                </button>
                            </div>
                        </div>
                        </form>';
    
    }   
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["deleteUser"])){
        $sql = "SELECT * FROM setting WHERE userId = '$userId'";
        $result = get_data($sql,$conn);
        $blockUserId = $result["blockedUsers"].$_POST["deleteUser"]."||";
        $stmt = $conn->prepare("UPDATE setting SET blockedUsers = '$blockUserId' WHERE userId = '$userId'");
        $stmt->execute();
        // $fName = getNotificationFile($blockUserId,$conn);
        // addNotification("blocked||$userId\n",$fName,false);
        header("Refresh: 0");
    }
    else if(isset($_POST["seeProfile"])){
        $_SESSION["seeUserProfile"] = $_POST["seeProfile"];
        header("Location: seeProfile.php");
    }else if(isset($_POST["addUser"])){
        $_SESSION["seeUserProfile"] = $_POST["addUser"];
        header("Location: seeProfile.php");
    }
    else if(isset($_POST["seeMessage"])){
        $_SESSION["seeMessageId"] = $_POST["seeMessage"];
        $stmt = $conn->prepare("UPDATE userMessage SET seen = 0 WHERE 
                        ((recieverId = '".$_POST['seeMessage']."' AND senderId = '$userId') or
                        (recieverId = '$userId' AND senderId = '".$_POST["seeMessage"]."')) AND
                        sender = '".$_POST['seeMessage']."' ");
        $stmt->execute();

        header("Location: userMessage.php");
    }
    else if(isset($_POST["searchedData"])){
        $searchedDataId = $_POST["searchedData"];
        $_SESSION["seeUserProfile"] = $searchedDataId;
        header("Location: seeProfile.php");
    }
}


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Message</title>
        <!-- Favicon-->
        <!-- <link rel="icon" type="image/x-icon" href="assets/favicon.ico" /> -->
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
         <script src="js/common.php" defer></script>
         <!-- Bootstrap core JS-->
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" defer></script>
         <!-- Core theme JS-->
         <script src="script/scripts.js" defer></script>
         <!-- <script src="js/index.php" defer></script> -->
         <link rel="stylesheet" href="../asset/css/bootstrap.css">
         <link rel="stylesheet" href="css/index.php">
         <!-- toggler -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script> 
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script> 
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>

    </head>
    <body class="scrollbar-hidden" >
        <div class="d-flex" id="wrapper" style="max-height: 100vh; overflow:hidden;">
            <!-- Sidebar-->
            <div class="border-end sub-side "  id="sidebar-wrapper" >
                <div class="sidebar-heading  main_color center">
                    <div class="col">
                        <img src="<?php echo htmlspecialchars($profileImage)?>" alt="..." 
                        class="profile-image text-center rounded-circle"/>
                    </div>
                    <div class="col">
                        <div class="username"><?php echo htmlspecialchars($username); ?></div>
                        <div class="username-info"><?php echo htmlspecialchars($bio); ?></div>
                    </div>
                </div>
                <div class="list-group list-group-flush fixed  ">
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 sub-side" href="myProfile.php">profile</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 sub-side" data-toggle="modal" data-target=".addUser">Add User</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 sub-side" data-toggle="modal" data-target=".createGroup">Create Group</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 sub-side" data-toggle="modal" data-target=".gostMode" >Gost</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 sub-side" href="setting.php">Setting</a>
                </div>
            </div>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper" style="background-color: rgb(0, 9, 22);" >
                <!-- Top navigation-->
                <nav class="navbar navbar-expand-lg main_color ">
                    <div class="container-fluid ">
                        <button class="btn" id="sidebarToggle">
                            
                            <img src="../asset/photo/Screenshot__91_-removebg-preview.png" width="100px" alt="">
                        </button>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="center satm">
                            Student Assignment And Test Maker   
                        </div>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">   
                                    <li class="nav-item"><a class="nav-link text-white" type="button" data-toggle="modal" data-target=".bd-example-modal-lg">search</a></li>
                                    <li class="nav-item "><a class="nav-link text-white" href="#!" data-bs-toggle="modal" data-bs-target="#exampleModal">Logout</a></li>
                                </ul>
                        </div>
                    </div>
                </nav>
                <nav>
                    <div class="alternatives">
                         <div class="user center">
                            Users
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                              </svg>
                        </div>
                       
                        <div class="group center" onclick="location.href = 'groupList.php'">
                            Groups
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                                <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                                <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                              </svg>
                        </div>
                        <div class="notification center" onclick="location.href = 'notification.php'">
                            notification
                            
                        </div>
                </nav>
                <!-- Page content-->
                <div class="container-fluid  p-0" style="background-color: rgb(0, 9, 22); height: 78vh; overflow-y: scroll;">
                    <!-- message -->
                    <?php echo $displayUsers; ?>
                      <!-- message -->
                      <br><br>
                </div>
            </div>
        </div>
       
    </body>
    <!-- modal -->
<?php 
    echo $blockModal;
    // echo $allModals;
?>
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
      <button type="button" class="btn btn-danger" onclick="logout()" >Log Out</button>
    </div>
  </div>
</div>
</div>
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
    <!-- Adduser -->

<div class="modal fade addUser" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content p-2">
          <div class="modal-header">
              <h5 class="modal-title">See Users</h5>
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
           </div>
          <div class="modal-body">
              
                  <label for="">Add Members </label>
                  <form action="index.php" method="post" class="members-class">
                    <?php echo $newUsers; ?>
                      
                  </form>
          </div>

      </div>
    </div>
  </div>
 <!-- adduser end -->

 <!-- search -->
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
    <!-- modal -->
   
</html>
<script>
    let buttons = document.querySelectorAll(".allButtonIds");
    AllChatIds = []
    
    buttons.forEach(element => {
        AllChatIds.push(element.value)
    });

    (function(){
        let xmlNew = new XMLHttpRequest()
        xmlNew.open("POST","api/checkNewNotification.php")
        xmlNew.setRequestHeader("Content-type","application/x-www-form-urlencoded")
        xmlNew.onload = function(){
        if(this.status == 200){
                oldValues = (JSON.parse(this.responseText));
                checkMessage(oldValues)
            }
        }
        xmlNew.send("file="+AllChatIds)
    })()

    function checkMessage(values){
        setInterval(()=>{
            let xmlCheck = new XMLHttpRequest()
            xmlCheck.open("POST","api/checkNewNotification.php")
            xmlCheck.setRequestHeader("Content-type","application/x-www-form-urlencoded")
            xmlCheck.onload = function(){
                if(this.status == 200){
                    if(this.responseText == false){
                        location.reload()
                    }
                }
            }
            xmlCheck.send("holdValues="+values+"&chatIds="+AllChatIds)
        },1000)
    }










     </script>