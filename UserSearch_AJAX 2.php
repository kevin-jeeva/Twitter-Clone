<?php

include("includes/functions.php");
include("includes/user.php");
include("includes/tweet.php");
include("connect.php");

//$screenName = $_GET["to"]; //grab whatever they typed
GetUsers('M');

function GetUsers($screenName) {
//run a DB query to retrieve the users that match the given screenname
//$sql = "select * from users where screen_name like '%$screenName%'
//call the method in your users class!!!!
//loop through the results and build an array
//json_encode the array and return it
  
    if (true) {
        $User = new user($_SESSION["SESS_MEMBER_ID"], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        $userList[] = user::getUserFullInfoAJAX($User, $screenName, $con);
        $json_data = json_encode($userList);
        echo $json_data;
    } else {
        echo json_encode("NOT FOUND");
    }
}
?>