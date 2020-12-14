<?php 
include ("connect.php");
include("User.php");
include("Tweet.php");
session_start();

//insert a tweet into the database
$tweet;

if(isset($_POST["myTweet"]))
{
    $tweet = AddSlahes($_POST["myTweet"]);
    if( $tweet != "")
    {
        //$user = $_SESSION["user_Id"];
        $user = new User($_SESSION["user_Id"],0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        $tweet = new Tweet(0,$tweet,$user->userId,0,0,0);
        
        Tweet::InsertTweet($tweet);
    }
    else
    {
        header("location:index.php");
    }
        
}
else
{
    header("location:index.php");    
}

function AddSlahes($value)
{
    $trim = trim($value);
    $result = addslashes($trim);
    $resultMain = strip_tags($result);   
    return $resultMain;
    
}
?>