<?php 
require_once "php/main_php.php";

$blockUsersArray = explode("||",$blockUsers);
$sendBlockAccounts = "";
foreach($blockUsersArray as $b){
    if($b == "")
        continue;
    $sql = "SELECT users.userId,users.username,profile.profileImagesFile
            FROM users LEFT JOIN profile ON users.userId = profile.userId
            WHERE users.userId = '$b'";
    $row = get_data($sql,$conn);
    $sendBlockAccounts.= '<div class="user-files mt-2" ">
                <div class="user-img">
                    <img src="'.get_profile($row["profileImagesFile"]).'" class="user-image rounded-circle" alt="">
                </div>
                <div class="user-name mt-4">  '.$row["username"].'</div>
                <div class="add text-center mt-3">
                    <div class=""> 
                        <button  class="border-0 btn btn-danger" onclick="Unblock(this)" value = "'.$row["userId"].'">
                          Unblock
                        </button>
                    
                    </div>
                </div>
            </div>';
}
$error = "";
if(isset($_POST["searchedData"])){
    $searchedDataId = $_POST["searchedData"];
    $_SESSION["seeUserProfile"] = $searchedDataId;
    header("Location: seeProfile.php");
} else if(isset($_POST["updateProfile"])){
    $error = "";
    $imageName = $_FILES["image"]["name"];
    $imagePath = $_FILES["image"]["tmp_name"];
    $imgExts = explode(".",$imageName);
    $imgExt = end($imgExts);
    $extensions = ["jpg","jpeg","png"];
    if(empty($imageName)){
        $error = "Choose Photo";
    } else {
        if(!in_array(strtolower($imgExt),$extensions)){
            $error = "invalid format";        
        } else {
            $newImageName = uniqid();
            if(move_uploaded_file($imagePath,"profileImages/".$newImageName.".$imgExt")){
                $file = fopen("usersProfile/$profileFile.txt","a");
                fwrite($file,"\n$newImageName.$imgExt");
                fclose($file);
                header("Refresh: 0");
            } else {
                $error = "sorry , something goes wrong";
            }
        }
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
        <title>userMessage</title>
         <script src="js/common.php" defer></script>
        <!-- Favicon-->
        <!-- <link rel="icon" type="image/x-icon" href="assets/favicon.ico" /> -->
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
         <!-- Bootstrap core JS-->
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" defer></script>
         <!-- Core theme JS-->
         <script src="script/scripts.js" defer></script>
         <script src="js/changeImage.js" defer></script>
         <link rel="stylesheet" href="../asset/css/bootstrap.css">
         <link rel="stylesheet" href="css/setting.php">

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>

    
    </head>
    <body class=".scrollbar-hidden">
        <div class="d-flex" id="wrapper">
            <!-- Sidebar-->
            <div class="border-end sub-side "  id="sidebar-wrapper" >
                <div class="sidebar-heading border-bottom main_color profile center">
                    <div class="col" onclick="location.href = 'index.php'">
                        <img src="<?php echo $profileImage; ?>" alt="..." 
                        class="profile-image text-center rounded-circle"/>
                    </div>
                    <div class="col">
                        <div class="username"><?php echo $username;?></div>
                        <div class="username-info"><?php echo $bio; ?></div>
                    </div>
                </div>
                <div class="list-group list-group-flush fixed ">
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 sub-side" href="myProfile.php">profile</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 sub-side" data-toggle="modal" data-target=".addUser">Add User</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 sub-side" data-toggle="modal" data-target=".createGroup">Create Group</a>
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
                        <div class="center satm">
                             Student Assignment And Test Maker   
                        </div>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">

                                <li class="nav-item "><a class="nav-link text-white" href="index.php" >Home</a></li>
                                <li class="nav-item "><a class="nav-link text-white" href="#!" data-bs-toggle="modal" data-bs-target="#exampleModal">Logout</a></li>
                                <li class="nav-item"><a class="nav-link text-white" type="button" data-toggle="modal" data-target=".bd-example-modal-lg">search</a></li>
                            
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
              
        
                <!-- Page content-->
                <div class="container-fluid  p-0 profile-body text-light">
                    <!-- body1 -->
                   <div class="profile-body-sub text-center  bg-dark">

                        <div class="profile-body-sub-img  bg-dark">
                            <button onclick="showImage(-1)" class="next-btn btn btn-light btn-outline-light">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                                  </svg>
                            </button>
                            <img id="profileImage" src="<?php echo $profileImage; ?>" class="image-profile" style="max-height: 350px;" alt="">
                            <button onclick="showImage(1)" class="next-btn btn btn-light btn-outline-light">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                                  </svg>
                            </button>
                        </div>
                        <div class="profile-body-sub-text mt-2 text-primary  bg-dark" >
                            update photo
                            <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST" enctype="multipart/form-data">
                                
                                <lable class="btn btn-light w-75 overflow-hidden">
                                    <input type="file" name="image">
                                </lable><br>
                                <input type="submit" class="m-3 btn btn-light" value="Update" name="updateProfile">
                                <a class="m-3 btn btn-danger" data-toggle="modal" data-target=".DeleteProfileImage" onclick="tryToDelete()">Delete</a><br>
                                <p class="text-danger"><?php echo $error; ?></p>
                            </form>

                        </div>
                        
                   </div>
                   <!-- body2 -->
                   <div class="profile-body-sub2 p-3  bg-dark">
                        <div class="sub-head text-light">
                            Setting
                        </div>
                        <div class="sub-body">
                            
                            <div class="sub-body-file">
                                <div class="form-check form-switch mt-3">
                                    <label class="question" style="margin-left: -2em;">Gost Mode</label>
                                    <input class="form-check-input float-end answer" type="checkbox" id="gostMode" value="<?php echo $userId?>">
                                </div>
                            </div>
                            
                            <div class="sub-body-file">
                                <div class="question ">Log Out</div>
                                <div class="answer btn w-25 btn-danger text-white ms-5" onclick="logout()">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0v2z"/>
                                        <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                                      </svg>
                                </div>
                            </div>
                            
                            <div class="sub-body-file">
                                <div class="question ">Delete My Account</div>
                                <div class="answer btn w-25 btn-danger text-white ms-5" onclick="deleteMyAccount()">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-x-fill" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm6.146-2.854a.5.5 0 0 1 .708 0L14 6.293l1.146-1.147a.5.5 0 0 1 .708.708L14.707 7l1.147 1.146a.5.5 0 0 1-.708.708L14 7.707l-1.146 1.147a.5.5 0 0 1-.708-.708L13.293 7l-1.147-1.146a.5.5 0 0 1 0-.708z"/>
                                      </svg>
                                </div>
                            </div>
                            
                            <div class="sub-body-file"> 
                            <div class="question ">Blocked Accountes</div>
                                <div class="answer btn w-25 btn-danger text-white ms-5" data-toggle="modal" data-target=".blockedAccounts">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-octagon-fill" viewBox="0 0 16 16">
                                        <path d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353L11.46.146zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
                                      </svg>
                                </div>
                            </div>
                            
                            <!-- <button class="sub-body-file-last btn m-5 text-center text-bg-light ">
                                show chat
                            </button> -->
                            
                        </div>

                  </div>

                </div>
            </div>
        </div>
       
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
<!-- wait -->

<div class="modal fade" id="wait" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Log Out</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          wait
        </div>
        <div class="modal-footer">
         
        </div>
      </div>
    </div>
  </div>
<!-- end wait -->
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
 <!-- Deleteimage -->

<div class="modal fade DeleteProfileImage" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content p-2">
          <div class="modal-header">
              <h5 class="modal-title">Delete Image</h5>
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
           </div>
          <div class="modal-body" style="display: flex;">
              
              <div class="imagePart">
              <img id="deletePicture" src="<?php echo $profileImage; ?>" class="center" style="width: 200px;" alt="">
                  <p>are you sure you want to delete this profile</p>
                  <button class="btn btn-danger w-100" onclick="DeleteProfileImage()">Delete</button>

                </div>    
          </div>

      </div>
    </div>
  </div>
 <!-- Delete image end -->
<!-- blocked accounts -->
<div class="modal fade blockedAccounts" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content p-2">
          <div class="modal-header">
              <h5 class="modal-title">Blocked Accounts</h5>
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" onclick="clearAddedMembers()"></button>
           </div>
          <div class="modal-body">
              
                  <span class="addedMembersProfile" style="max-width:100px; width: 100px; overflow-x: hidden;">
                    
                  </span><br>
                  <div class="members-class">
                    <?php if($sendBlockAccounts == ""){
                        echo "No Blocked Accounts";
                    } else {
                        echo $sendBlockAccounts;
                    } ?>
                      
                  </div>
          </div>

      </div>
    </div>
  </div>

    </body>
</html>
<script>
    function Unblock(file){
        let xml =  new XMLHttpRequest()
        xml.open("GET","api/unBlock.php?id="+file.value);
        xml.onload = function(){
            if(this.response){
                if(this.responseText == "true"){
                    location.reload();
                } else {
                    alert("something goes Wrong")
                }
            }
        }
        xml.send()
    }
    function deleteMyAccount(){
        alert("This Future Is Not Available Yet")
    }
    function DeleteProfileImage(){
        let currentImage = getCurrentImage();
        if(currentImage == IMAGES[0]){
            alert("sorry this image is root\n you cant delete this")
            return
        }

        let xml = new XMLHttpRequest()
        xml.open("POST","api/DeleteProfileImage.php")
        xml.setRequestHeader("Content-type","application/x-www-form-urlencoded")
        xml.onload = function(){
            if(this.status == 200){
                location.reload()
            }
        }
        xml.addEventListener("loadstart",loadstart)
        xml.send("deletedImage="+currentImage)
    }
    function tryToDelete(){
        let currentImage = getCurrentImage();
        deletePicture.src = "profileImages/"+currentImage;
    }
    function loadstart(){

    }
        
</script>