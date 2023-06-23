<?php 

require_once "php/main_php.php";
require_once "php/modals.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
  
    if(isset($_POST["addUser"])){
        $_SESSION["seeUserProfile"] = $_POST["addUser"];
        header("Location: seeProfile.php");
    } else if(isset($_POST["searchedData"])){
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
         <link rel="stylesheet" href="css/notification.php">
         <!-- toggler -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script> 
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script> 
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script>

    </head>
    <body class=".scrollbar-hidden" >
        <div class="d-flex" id="wrapper" style="max-height: 100vh; overflow:hidden;">
            <!-- Sidebar-->
            <div class="border-end sub-side "  id="sidebar-wrapper" >
                <div class="sidebar-heading  main_color center">
                    <div class="col">
                        <img onclick="location.href = 'index.php'" src="<?php echo htmlspecialchars($profileImage)?>" alt="..." 
                        class="profile-image text-center rounded-circle"/>
                    </div>
                    <div class="col">
                        <div class="username"><?php echo htmlspecialchars($username); ?></div>
                        <div class="username-info"><?php echo htmlspecialchars($bio); ?></div>
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
                     <div class="user center" onclick="location.href = 'index.php'">
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
                        <div class="notification center" >
                            notification
                            
                        </div>
                    </div>
                </nav>
                <!-- Page content-->
                <div class="container-fluid p-0" id="displayNotification" style="background-color: rgb(0, 9, 22); padding-bottom:8em; height: 78vh; overflow-y: scroll;">
                    <!-- message -->
                   
                      <!-- message -->
                      <br><br>
                </div>
            </div>
        </div>
       
    </body>
    <!-- modal -->
<?php 
    
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
let displayNotification = document.getElementById("displayNotification");
(function(){
  let xmlRecieve = new XMLHttpRequest()
  xmlRecieve.open("GET","api/returnNotifications.php")
  xmlRecieve.onload = function(){
    if(this.status == 200){
      let response = JSON.parse(this.responseText);
      let file = "";
      response.forEach(element => {
        file += element;
      });
      displayNotification.innerHTML = file; 

    }
  }
  xmlRecieve.send();
})()
setInterval(() => {
  let xmlRecieve = new XMLHttpRequest()
  xmlRecieve.open("GET","api/returnNotifications.php")
  xmlRecieve.onload = function(){
    if(this.status == 200){
      let response = JSON.parse(this.responseText);
      let file = "";
      response.forEach(element => {
        file += element;
      });
      displayNotification.innerHTML = file; 

    }
  }
  xmlRecieve.send();
}, 5000);
</script>