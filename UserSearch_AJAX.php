<?php
include_once("User.php");
session_start();

if(isset($_GET["to"]))
{
 $userName = $_GET["to"];
//$userName = 'N';
$mainUser = $_SESSION["user_Id"];
 $userResult = User::SearchUsersAjax($userName,$mainUser);
 
    if($userResult != null)
    {
        $myArray = $userResult;    
       // print_r($myArray);
      // $myArray = array("users" =>$myArray);
       //$json_out = $myArray;
      // $json_out = '{"Name":"Success"}';     
        $json_out = json_encode($myArray);
    }
    else
    {
        $json_out = '{"Name":false}';
    }
    echo $json_out;
}

