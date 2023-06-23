<?php

require_once "php/main_php.php";

$seeMessageId = $_SESSION["seeMessageId"];

$sql = "SELECT profile.bio,profile.profileImagesFile,users.username,
        setting.gostMode,setting.lastSeen,setting.online
        FROM profile
        left join setting on profile.userId = setting.userId
        left join users on profile.userId = users.userId
        WHERE profile.userId = '$seeMessageId'";
$aboutReciever = get_data($sql,$conn);

$recieverUsername = $aboutReciever["username"];
$online = false;
if($aboutReciever["gostMode"] == 0){
    if($aboutReciever["online"] == "on"){
        $online = true;
    }
}
$recieverProfile = get_profile($aboutReciever["profileImagesFile"]);

$sql = "SELECT * FROM userMessage
        WHERE ( recieverId= '$seeMessageId'  AND 
        senderId = '$userId') or 
        (recieverId = '$userId'  AND 
        senderId = '$seeMessageId')";
        
$result = get_data($sql,$conn,false);

$fileSend = "";
$counter = 0;
while($row = $result->fetch_assoc()){
    $counter++;
    if($row["sender"] == $userId){
        $fileSend .='<div class="sender-message  ">';
        if($row["img"] !== NULL AND $row["img"] !== ""){
            $fileSend .='<div class="text-image">
                            <img src="messageImages/'.$row["img"].'" width="100px" class="message-image" alt="" >
                        </div>';
            }
        if($row["message"] !== NULL AND $row["message"] !== ""){
             $fileSend .='<div class="text-message"> '.$row["message"].'<br> </div>';
        }
        $fileSend .= "<span class='me-3 w-100' style='color: #929292;'><small>".$row["sendAt"]."</small><span>";
        $fileSend .='</div>';
    } else {
        $fileSend .='<div class="reciever-message text-white "> ';
        if($row["img"] !== NULL AND $row["img"] !== ""){
             $fileSend .=' <div class="text-image">
                 <img src="messageImages/'.$row["img"].'" width="100px" class="message-image" alt="" />
             </div>';
        }
        if($row["message"] !== NULL AND $row["message"] !== ""){
            $fileSend .=' <div class="text-message">';
            $fileSend .= $row["message"] ;
            $fileSend .= '</div>';
        }
        $fileSend .= "<span class='me-3 w-100' style='color: #929292;'><br>".$row["sendAt"]."<span>";
        $fileSend .='</div>';

    }
}

function order_notification($userId,$recieverId,$conn){
    $sql = "SELECT notificationSort FROM profile WHERE userId = '$recieverId'";
    $notSort2 = get_data($sql,$conn);
    $sort = explode("||",$notSort2["notificationSort"]);
    $newSort = $userId."||";
    foreach ($sort as $s){
        if($s == "" || $s == $userId)
            continue;
        $newSort .= $s."||";
    }
    $stmt = $conn->prepare("UPDATE profile SET 
                            notificationSort = '$newSort'
                            WHERE userId = '$recieverId'");
    $stmt->execute(); 
}


if(isset($_POST["submit"])){
    $text = secure($_POST["text"]);
    $image = $_FILES["image"]["tmp_name"];
    $imageName = uniqid();
    if(trim($text) != "" or $image != ""){
      if(move_uploaded_file($image,"messageImages/$imageName") or $image == ""){
           
            $stmt = $conn->prepare("UPDATE userMessage 
                                    set lastMessage = '0' WHERE
                                    (senderId = '$userId' and recieverId = '$seeMessageId') or
                                    (senderId = '$seeMessageId' and recieverId = '$userId')
                                    ");
            $stmt->execute();
            $stmt = $conn->prepare("INSERT INTO userMessage
                    (message,img,senderId,recieverId,sender) VALUES
                    ('$text','$imageName','$userId','$seeMessageId',$userId);");
            $stmt->execute();
            header("Refresh: 0");
        } else {
            echo "<script>alert('something goes wrong')</script>";
        }
    }
}

if(isset($_POST["seeDetailProfile"])){
    $_SESSION["seeUserProfile"] = $seeMessageId;
    header("Location: seeProfile.php");
} else if(isset($_POST["searchedData"])){
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
        <title>userMessage</title>
        <!-- Favicon-->
        <!-- <link rel="icon" type="image/x-icon" href="assets/favicon.ico" /> -->
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
         <!-- Bootstrap core JS-->
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" defer></script>
         <!-- Core theme JS-->
         <script src="js/common.php" defer></script>
         <script src="script/scripts.js" defer></script>
         <!-- <script src="js/index.js" defer></script> -->
         <link rel="stylesheet" href="../asset/css/bootstrap.css">
         <link rel="stylesheet" href="css/userMessage.php">

         <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script> 
         <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script> 
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>

         
    </head>
    <body class="scrollbar-hidden bg-dark">
        <div class="d-flex" id="wrapper" style="max-height: 103 vh; overflow:hidden;" >
            <!-- Sidebar-->
            <div class="border-end sub-side"  id="sidebar-wrapper">
                <div class="sidebar-heading  main_color profile center">
                    <div class="col" onclick="location.href = 'index.php'">
                        <img src="<?php echo $profileImage ?>" alt="..." 
                        class="profile-image text-center rounded-circle"/>
                    </div>
                    <div class="col">
                        <div class="username"><?php echo $username ?></div>

                        <a href="#go" style="display: none;" class="text-success" id="gonow"></a>

                    <div class="username-info"><?php echo $bio?></div>
                    </div>
                </div>
                <div class="list-group list-group-flush fixed ">
                     <a class="list-group-item list-group-item-action list-group-item-light p-3 sub-side" href="myProfile.php">profile</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 sub-side" data-toggle="modal" data-target=".addUser">Add User</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 sub-side" data-toggle="modal" data-target=".createGroup">Create Group</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 sub-side" data-toggle="modal" data-target=".gostMode" >Gost</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 sub-side" href="setting.php">Setting</a>
                </div>
                
            </div>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper" >
                <!-- Top navigation-->
                <!-- <nav class="navbar navbar-expand-lg main_color " >
                    <div class="container-fluid ">
                        <button class="btn" id="sidebarToggle">
                            
                            <img src="../asset/photo/Screenshot__91_-removebg-preview.png" width="100px" alt="">
                        </button>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="btn btn-light ms-2" onclick="location.href='index.php'">back</div>
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
                </nav> -->
                <nav class="userNav">
                    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="sticky-top sender-pro text-bg-dark" style="z-index: 0;">
                        <a href="./index.php">
                            back
                        </a>
                        <button type="submit" name="seeDetailProfile" class="chat-img bg-dark border-0">
                            <img src="<?php echo $recieverProfile ?>" width="60px" height="60px" class="rounded-circle" alt="" srcset="">
                        </button>
                        
                        <button type="submit" name="seeDetailProfile" class="chat-username bg-dark border-0 text-primary" >
                             <?php echo $recieverUsername?>  
                         </button>
                        <?php 
                        if($online == true)
                             echo '<div class="light" style="background-color: green;"></div>'; 
                         
                        ?>
                    </form>

                     </nav>
        
                <!-- Page content-->
                <div class="container-fluid   p-0 message-background" >
                    
                  <?php
                        if($counter < 5){
                            echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
                        }
                        echo $fileSend;                        
                   
                  ?>
                  <div id="go" value="3">
                        <script>
                            
                        </script>
                  </div>

                    <div class="send sticky-bottom ">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post" enctype="multipart/form-data" class="send-form d-flex">
                            <input class="send-input m-2"  placeholder="send txt" name="text">
                            <input class="m-2 custom-file-input" style="width: fit-content;" name="image" type="file" >
                            <button class="btn btn-outline-light m-2 w-25" name="submit" value="submit">
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
   <!-- search -->
  
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
  <!-- Gost -->
  <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-sm">Small modal</button> -->
  
<div class="modal fade gostMode" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm">
  <div class="modal-content">
    <div class="modal-body text-center">
      <div class="modal-header">
          <h5 class="modal-title" id="">Gost Mode</h5>
      </div>
      <div class="form-check form-switch mt-3">
          <label class="form-check-label float-start" for="flexSwitchCheckChecked">Hide Your Identity</label>
          <input class="form-check-input float-end" type="checkbox" id="gostMode" value="$userId">
      </div>

    </div>
  </div>
</div>
</div>
  <!-- Gost end -->
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
</html>
<script>
    document.getElementById("gonow").click();
    let CHECKUPDATE
    let recieverId = '<?php echo $seeMessageId; ?>';
    (function(){
        let xml = new XMLHttpRequest()
        xml.open("POST","api/userMessageUpdate.php")
        xml.setRequestHeader("Content-type","application/x-www-form-urlencoded")
        xml.onload = function(){
            if(this.status == 200){
                CHECKUPDATE = this.responseText
            }
        }
        xml.send("recieverId="+recieverId)
    })()

    function checker(){
          let xml = new XMLHttpRequest()
        xml.open("POST","api/userMessageUpdate.php")
        xml.setRequestHeader("Content-type","application/x-www-form-urlencoded")
        xml.onload = function(){
            if(this.status == 200){
                if(CHECKUPDATE != this.responseText){
                    location.reload()
                }
            }
        }
        xml.send("recieverId="+recieverId)
    }
    setInterval(checker,1000)
</script>