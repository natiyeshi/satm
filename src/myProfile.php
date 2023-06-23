<?php 

require_once "php/main_php.php";


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
         <script src="js/changeImage.js" defer></script>
         <link rel="stylesheet" href="../asset/css/bootstrap.css">
         <link rel="stylesheet" href="css/myProfile.php">
         <script src="js/common.php" defer></script>
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
                        <div class="username-info"><?php echo $bio;?></div>
                    </div>
                </div>
                <div class="list-group list-group-flush fixed ">
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
                           
                            </ul>
                        </div>
                    </div>
                </nav>
              
        
                <!-- Page content-->
                <div class="container-fluid pb-5  p-0 profile-body bg-dark text-light">
                    <!-- body1 -->
                   <div class="profile-body-sub text-center">

                        <div class="profile-body-sub-img">
                            <button onclick="showImage(-1)" class="next-btn btn btn-light btn-outline-light">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-arrow-left-circle" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5-.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                                  </svg>
                            </button>
                            <img id="profileImage" src="<?php echo $profileImage; ?>" class="image-profile " style="max-height:250px ;" alt="">
                            <button onclick="showImage(1)" class="next-btn btn btn-light btn-outline-light">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                                  </svg>
                            </button>
                        </div>
                        <div class="profile-body-sub-text mt-5 text-success" style="font-size: larger;">
                           <?php  echo $username;?>
                        </div>
                        <div class="profile-body-sub-file">
                            
                                <div class="profile-body-sub-file-name">
                                        <div class="question"> name </div>
                                        <div class="answer text-success">
                                            <?php  echo $profile["name"] == NULL ?  " - " : $profile["name"]; ?>
                                        </div>
                                </div>

                                <div class="profile-body-sub-file-name">
                                        <div class="question">age</div>
                                        <div class="answer text-success">
                                            <?php  echo $profile["age"] == NULL ?  " - " : $profile["age"]; ?>
                                        </div>
                                </div>
                                <div class="profile-body-sub-file-name">
                                    <div class="question"> bio </div>
                                    <div class="answer text-success">
                                         <?php  echo $profile["bio"] == NULL ?  " - " : $profile["bio"]; ?>
                                    </div>
                                </div>

                                <div class="profile-body-sub-file-name">
                                        <div class="question">username</div>
                                        <div class="answer text-success"><?php echo $username; ?></div>
                                </div>

                            
                        </div>

                   </div>
                   <!-- body2 -->
                   <div class="profile-body-sub2">
                        <div class="sub-head text-light">
                            profile
                        </div>
                        <div class="sub-body">
                            <div class="sub-update">
                                <div class="sub-update-name text-light">name</div>
                                <div class="sub-update-file ">
                                    <input class="border-0 bg-dark  text-light" id="name" type="text" placeholder="insert your name" value="<?php  echo $profile["name"] == NULL ?  "" : $profile["name"]; ?>">
                                </div>
                                <button class="sub-update-button btn btn-success" value="name" onclick=(update(this))>update</button>
                               
                            </div>
                        </div>

                        <div class="sub-body">
                            <div class="sub-update">
                                <div class="sub-update-name  text-light">Age</div>
                                <div class="sub-update-file ">
                                    <input class="border-0 bg-dark text-light" type="number" id="age" placeholder="insert your age" value="<?php  echo $profile["age"] == NULL ?  "" : $profile["age"]; ?>">
                                    
                                </div>
                                <button class="sub-update-button btn btn-success" value="age" onclick=(update(this))>update</button>
                                
                            </div>
                        </div>

                        <div class="sub-body">
                            <div class="sub-update">
                                <div class="sub-update-name text-light">Bio</div>
                                <div class="sub-update-file ">
                                  <input class="border-0 bg-dark text-light" type="text" id="bio" placeholder="insert your bio" value="<?php  echo $profile["bio"] == NULL ?  "" : $profile["bio"]; ?>">
                                </div>
                                <button class="sub-update-button btn btn-success" value="bio" onclick=(update(this))>update</button>
                                
                            </div>
                        </div>

                        <div class="sub-body">
                            <div class="sub-update">
                                <div class="sub-update-name text-light">phone</div>
                                <div class="sub-update-file ">
                                    <input class="border-0 bg-dark text-light" id="phone" type="number" placeholder="insert your phone" value="<?php  echo $profile["phone"] == NULL ?  "" : $profile["phone"]; ?>">      
                                </div>
                                <button class="sub-update-button btn btn-success" value="phone" onclick=(update(this))>update</button>
                                
                            </div>
                        </div>

                        <div class="sub-body">
                            <div class="sub-update">
                                <div class="sub-update-name text-light">username</div>
                                <div class="sub-update-file">
                                    <input class="border-0 bg-dark text-light" id="username" type="text" class="border-0" placeholder="insert your username" value="<?php  echo $username == NULL ?  "" : $username; ?>">
                                </div>
                                <button class="sub-update-button btn btn-success" value="username" onclick=(update(this))>update</button>
                                
                            </div>
                        </div>

                        

                  </div>

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

 <!-- search -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Large modal</button> -->

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content p-2">
          <div class="modal-body text-center">
              Search
          </div>
          <div class="modal-footer">
              <input type="text" class="w-50">
              <button type="button" class="btn btn-success" data-dismiss="modal">Search</button>
            </div>
      </div>
    </div>
  </div>
  <!-- end search -->
    <!-- modal -->
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
    function empty(){

    }
    function update(file){
        var name = file.value;
        var inputName = document.querySelector("#"+name);
        if(file.value == "username" && inputName.value.trim() == ""){
                alert("you cant submit empty username")
                return
        } 
        if(file.value == "username"){
            if(inputName.value.length < 4 || inputName.value.length > 10){
                alert("username length should be greater than 4 and less than 11");
            }
        }
         var xml = new XMLHttpRequest()
         xml.onload = function(){
             if(this.status == 200){
                   if(this.responseText == "true"){
                     window.location.reload();
                   } else {
                     alert("username exist");
                   }
                   
                }
          }
         xml.open("POST","api/update.php");
         xml.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
         xml.send("name="+name+"&value="+inputName.value)
        
    }
    
</script>