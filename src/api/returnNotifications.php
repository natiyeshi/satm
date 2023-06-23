<?php 

require_once "../php/db.php";
require_once "../php/functions.php";

error_reporting(0);
ini_set('display_errors',0);

session_start();
$userId = $_SESSION["userId"];

$fName = getNotificationFile($userId,$conn);
$allNotifications = returnNotifications($fName);

$senarios = ["joined","group","blocked","unblocked","profileUpdate"];

$sql = "SELECT username from users WHERE  userId = '$userId'";
$data = get_data($sql,$conn);
$username = $data["username"];

$send = [];

foreach ($allNotifications as $key) {
    $files = explode("||",$key);
    $message = $files[1];
    $senar = $files[0];
    if($senar == $senarios[0]){
        $send[] = '<div class="alert one-notifications alert-warning m-2 text-black">
                        <div class="col center text-success mb-2" style="font-size:large; font-weight:bold;">Welcome</div>
                        <div class="col center">Welcome To Our plateform '.$username.' ! Thanx For Joining Us</div>
                    </div>';
    }elseif($senar == $senarios[1]){
        $sql = "SELECT * FROM groups WHERE adminId = $message";
        $data1 = get_data($sql,$conn);
        // print_r($data1);
        $sql = "SELECT * FROM users WHERE userId = '".$data1["adminId"]."'";
        $data2 = get_data($sql,$conn);
        $send[] = '<div class="alert one-notifications alert-primary m-2 text-black">
                        <div class="col center text-primary mb-2" style="font-size:large; font-weight:bold;">New Group</div>
                        <div class="col center">'.$data2["username"].' added you in "'.$data1["groupName"].'" Group</div>
                    </div>';
    
    }elseif($senar == $senarios[2]){
        $sql = "SELECT * FROM users WHERE userId = '$message'";
        $data = get_data($sql,$conn);
        $send[] = '<div class="alert one-notifications alert-danger m-2 text-black">
                    <div class="col center text-danger mb-2" style="font-size:large; font-weight:bold;">Blocked</div>
                    <div class="col center">'.$data["username"].' blocked you </div>
                  </div>';
    }elseif($senar == $senarios[3]){
        $sql = "SELECT * FROM users WHERE userId = '$message'";
        $data = get_data($sql,$conn);
        $send[] = '<div class="alert one-notifications alert-danger m-2 text-black">
                        <div class="col center text-primary mb-2" style="font-size:large; font-weight:bold;">UnBlocked</div>
                        <div class="col center">'.$data["username"].' unblocked you now you can have inbox chat</div>
                    </div>';
       
    }elseif($senar == $senarios[4]){
        $sql = "SELECT * FROM users WHERE userId = '$message'";
        $data = get_data($sql,$conn);
        $send[] = '<div class="alert one-notifications alert-danger m-2 text-black">
                        <div class="col center text-primary mb-2" style="font-size:large; font-weight:bold;">UnBlocked</div>
                        <div class="col center">'.$data["username"].' unblocked you now you can have inbox chat</div>
                    </div>';
       
    }
}

echo json_encode($send);