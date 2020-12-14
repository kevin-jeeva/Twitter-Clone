<?php
include("connect.php");
include("User.php");
include("Tweet.php");

session_start();
if (isset($_SESSION["user_Id"])) 
{
    header("location:index.php");
    //exit;
}
else
{
    header("location:Login.php");
}
$tweetId = $_GET["value"];
$tweet = new Tweet(0,0,0,$tweetId,0,0);
Tweet::ReTweet($tweet);

