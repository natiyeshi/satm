<?php 
require_once "php/main_php.php";
$seeUserProfile = $_SESSION["seeUserProfile"];

$sql = "SELECT users.username,profile.phone,profile.age,profile.bio,profile.profileImagesFile
        FROM users left join profile on users.userId = profile.userId
        WHERE users.userId = '$seeUserProfile'";
$userProfileStatus = get_data($sql,$conn);

if(isset($_POST["goToChat"])){
    $_SESSION["seeMessageId"] = $seeUserProfile;
    header("Location: userMessage.php");
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
         <script src="script/scripts.js" defer></script>
         <link rel="stylesheet" href="../asset/css/bootstrap.css">
         <script src="js/common.php" defer></script>
         <link rel="stylesheet" href="css/seeProfile.css">
<!-- toggler -->
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
                        <div class="username"><?php echo $username; ?></div>
                        <div class="username-info"><?php echo $bio; ?></div>
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

                                <li class="nav-item "><a class="nav-link text-white" href="index.php">Home</a></li>
                                <li class="nav-item "><a class="nav-link text-white" href="#!" data-bs-toggle="modal" data-bs-target="#exampleModal">Logout</a></li>
                                <li class="nav-item"><a class="nav-link text-white" type="button" data-toggle="modal" data-target=".bd-example-modal-lg">search</a></li>
                 
                              </ul>
                        </div>
                    </div>
                </nav>
              
        
                <!-- Page content-->
                <div class="container-fluid  p-0 profile-body bg-dark">
                    <!-- body1 -->
                   <div class="profile-body-sub text-center">

                        <div class="profile-body-sub-img">
                            <button id="id" onclick="showOtherUserProfile(-1)" value="<?php echo $seeUserProfile; ?>" class="next-btn btn btn-light btn-outline-light">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                                  </svg>
                            </button>
                            <img id="profileImage" src="<?php echo get_profile($userProfileStatus["profileImagesFile"]); ?>" style="max-height:450px;" class="image-profile " alt="">
                            <button onclick="showOtherUserProfile(1)" class="next-btn btn btn-light btn-outline-light">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                                  </svg>
                            </button>
                        </div>
                        <div class="profile-body-sub-text mt-3 text-primary">
                            <?php echo $userProfileStatus["username"]; ?>
                        </div>
                        
                   </div>
                   <!-- body2 -->
                   <div class="profile-body-sub2 p-3">
                        <div class="sub-head">
                            profile
                        </div>
                        <div class="sub-body text-light">
                            
                            <div class="sub-body-file">
                                <div class="question text-center">username</div>
                                <div class="answer text-center"><?php echo $userProfileStatus["username"] == null ? " - ": $userProfileStatus["username"]; ?></div>
                            </div>
                            
                            <div class="sub-body-file">
                                <div class="question text-center">age</div>
                                <div class="answer text-center"><?php echo $userProfileStatus["age"] == null ? " - ": $userProfileStatus["age"]; ?></div>
                            </div>
                            
                            <div class="sub-body-file">
                                <div class="question text-center">phone</div>
                                <div class="answer text-center"><?php echo $userProfileStatus["phone"] == null ? " - ": $userProfileStatus["phone"]; ?></div>
                            </div>
                            
                            <div class="sub-body-file">
                                <div class="question text-center">bio</div>
                                <div class="answer text-center"><?php echo $userProfileStatus["bio"] == null ? " - ": $userProfileStatus["bio"]; ?></div>
                            </div>
                            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
                                <button type="submit" name="goToChat" class="w-75 sub-body-file-last btn m-5 text-center btn-primary ">
                                    go to chat
                                </button>
                            </form>
                            
                            
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
  <!-- crete group end -->
 
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
    </body>
</html>
<script>
  IMAGES = []
  let profileId = document.getElementById("id").value
  function showOtherUserProfile(check){
        let profileImage = document.getElementById("profileImage")   
        let currentImage = getCurrentImage()
        let currentIndex = sendIndex(currentImage)
        if(check == 1 && currentIndex < IMAGES.length - 1  && currentIndex > -1){
            profileImage.src = "profileImages/"+IMAGES[parseInt(currentIndex) + 1]
        }
       if(check == -1 && currentIndex > 0  && currentIndex < IMAGES.length){
            profileImage.src = "profileImages/"+IMAGES[currentIndex - 1]
        }  
    
  }
  (function(){
    let xml = new XMLHttpRequest()
    xml.open("POST","api/imageArray.php")
    xml.setRequestHeader("Content-type","application/x-www-form-urlencoded")
    xml.onload = function(){
      if(this.status == 200){
        reciever(JSON.parse(this.responseText))
      }
    }
    xml.send("otherUserId="+profileId)
  })()

  function reciever(json){
        for(let i of json){
            let file = i.split("\n")
            IMAGES.push(file[0])
        }
        IMAGES[0] += ".jpg";
        console.log(IMAGES);
   }
   function getCurrentImage(){
        let profileImage = document.getElementById("profileImage").src   
        let allPath = profileImage.split("/")
        return allPath[allPath.length - 1]
    }
    function sendIndex(file){
        for(let a in IMAGES){
            if(IMAGES[a] == file)
                return a
        }
     }
</script>
