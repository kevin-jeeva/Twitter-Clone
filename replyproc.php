<?php
include_once("connect.php");
include_once("Tweet.php");
session_start();

//$reply = $_GET['txtComment2'];
//$tweetId = $_GET['tweetId'];
//$repUserId = $_GET['repUserId'];
//$orgTweetId = $_GET['OrgUserId'];

    $reply = $_GET["txtCommentAjax"];
    $repUserId =$_GET["repUserId"];
    $tweetId = $_GET["tweetIdValue"];
    
$tweets = new Tweet(0,$reply,$repUserId,0,$tweetId,0);
$_SESSION["alert"] = $reply." ".$repUserId." ".$tweetId;
$ck = Tweet::InsertReply($tweets);

if($ck)
{
   $_SESSION["alert"] ="Your reply is successfull";
   $json_out = '{"msg":true}';
  
}
 else 
{
    $_SESSION["alert"] ="Your reply is not successfull";
    $json_out = '{"msg":false}';
}

echo $json_out;


?>
