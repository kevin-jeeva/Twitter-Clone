<?php
include_once("User.php");
session_start();
if(isset($_GET["message"]) && isset($_GET["to"]))
{
    $message = $_GET["message"];
    if($message != "")
    {
        $userName = $_GET["to"];
        echo $userName;
        $Mainuser = $_SESSION["user_Id"];
        $userId = User::GetUserByScreenName($userName);
        echo $userId;
        $result = User::AddMessages($Mainuser,$userId, $message);
        if($result == true)
        {
            $_SESSION["alert"] = "Message Sent...";
           header("location:DirectMessage.php");
           echo "Success";
        }
        else
        {
            $_SESSION["alert"] = "Message Not Sent!";
           header("location:DirectMessage.php");
            echo "failure";
        }
    }
    
}
else
{
    header("location:index.php");
}
?>

