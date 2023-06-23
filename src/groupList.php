<?php 
require_once "php/main_php.php";

function checkMember($fileName,$userId){
    $file = fopen("groupMembers/".$fileName.".txt","r");
    while(!feof($file)){
        if(fgets($file) == $userId){
            return true;
        }
    }
    return false;
}


$sql = "SELECT * from groups";
$result = get_data($sql,$conn,false);
$myGroups = [];

while($row = $result->fetch_assoc()){
    if(checkMember($row["membersFile"],$userId) or $row["adminId"] == $userId){
        $myGroups[] = $row["groupId"];
    }
}

$groupList = "";

foreach($myGroups as $id){
    $sql = "SELECT * FROM groupMessage WHERE groupId = '$id' ORDER BY sendAt DESC LIMIT 1";
    $lastMessage = get_data($sql,$conn,true);
    $sql = "SELECT * from groups WHERE groupId = '$id'";
    $result = get_data($sql,$conn);
    $sql = "SELECT profileImagesFile FROM profile WHERE userId = '".$result['adminId']."'";
    $adminProfile = get_data($sql,$conn);
    $adminProfileImage = get_profile($adminProfile["profileImagesFile"]);
    $lastChatMessage = "";
    if($lastMessage != NULL){
        $sql = "SELECT username FROM users WHERE userId = '".$lastMessage["senderId"]."'";
        $showUsername = get_data($sql,$conn);
        $lastChatMessage = $lastMessage["senderId"] == $userId ? "<span style='color:blue; margin:0 1em;'>you </span>" : "<span style=' margin:0 1em; color:red;'>{$showUsername['username']}</span>";
    }
    $lastChatMessage .= $lastMessage == null ? "": $lastMessage["message"]; 
    $groupList .= '  <button type=submit name = goToGroup value = '.$result["groupId"].' class="message bg-dark mb-0">
    <div class="message-image">
        <div class="line">
            <div class="sender-username ms-2 mb-2">'.$result["groupName"].'</div>
        </div>
        <img src="../asset/photo/Screenshot__91_-removebg-preview.png" class="message-main-image rounded-circle p-0">
    </div>
    <div class="message-main ">
        <br> '.$lastChatMessage.'
       
    </div>
    <div class="message-notification center"> <br>
        
    </div>
    <div class="message-delete center">
        <img src="'.$adminProfileImage.'" width="50px" height="50px" class="rounded-circle">;
    </div>
    </button>';
}

if(isset($_POST["goToGroup"])){
    $_SESSION["goToGroup"] = $_POST["goToGroup"];
    header("Location: groupMessage.php");
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
        <title>GroupList</title>
        <!-- Favicon-->
        <!-- <link rel="icon" type="image/x-icon" href="assets/favicon.ico" /> -->
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
         <!-- Bootstrap core JS-->
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" defer></script>
         <!-- Core theme JS-->
         <script src="script/scripts.js" defer></script>
         <script src="js/common.php" defer></script>
         <link rel="stylesheet" href="../asset/css/bootstrap.css">
         <link rel="stylesheet" href="css/groupList.php">
         <!-- toggler -->
         <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script> 
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script> 
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>

    </head>
    <body class=".scrollbar-hidden">
        <div class="d-flex" id="wrapper" style="max-height: 100vh; overflow:hidden;">
            <!-- Sidebar-->
            <div class="border-end sub-side "  id="sidebar-wrapper" >
                <div class="sidebar-heading  main_color center">
                    <div class="col" onclick="location.href = 'index.php'">
                        <img src="<?php echo $profileImage;?>" alt="..." 
                        class="profile-image text-center rounded-circle"/>
                    </div>
                    <div class="col">
                        <div class="username"><?php echo htmlspecialchars($username); ?></div>
                        <div class="username-info"><?php echo $bio; ?></div>
                    </div>
                </div>
                <div class="list-group list-group-flush fixed ">
                    <!-- <a     class="list-group-item list-group-item-action list-group-item-light p-3 sub-side" href="#!">Profile</a> -->
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 sub-side" href="myProfile.php">profile</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 sub-side" data-toggle="modal" data-target=".addUser">Add User</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 sub-side" data-toggle="modal" data-target=".createGroup">Create Group</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 sub-side" data-toggle="modal" data-target=".gostMode" >Gost</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 sub-side" href="setting.php">Setting</a>
           <!-- <a class="list-group-item list-group-item-action list-group-item-light p-3 sub-side" href="#!">Change Mode</a> -->
                </div>
            </div>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper" style="background-color: rgb(0, 9, 22);">
                <!-- Top navigation-->
                <nav class="navbar navbar-expand-lg main_color border-">
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
                        <div class="user center" onclick="location.href = 'index.php'">
                            Users
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                              </svg>
                        </div>
                        <div class="group center">
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
                    </div>
                </nav>
                <!-- Page content-->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="container-fluid p-0" style=" background-color: rgb(0, 9, 22); height: 78vh; overflow-y: scroll;">
                    <!-- message -->
                    <?php echo $groupList; ?>
                    
                </form>
                                
                
                </div>
            </div>
        </div>
       
    </body>
    
    <!-- modal -->
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

    <!-- crete group end -->
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
    <!-- modal -->
</html>
