<?php
include_once("connect.php");

session_start();
$con = $GLOBALS["con"];

if(isset($_GET["tweetId"]))
{
    $tweetId = $_GET["tweetId"];
    $userId = $_SESSION["user_Id"];
    
    if($tweetId != null)
    {
        $result = Check($tweetId, $userId);
        if($result == true)
        {
            
            header("location:index.php");
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
}
else
{
    header("location:index.php");
}

function Check($tweetId, $userId)
{
    $con = $GLOBALS["con"];
    $sql = "Select * from likes where user_id = $userId AND tweet_id = $tweetId";
    $result = mysqli_query($con, $sql);
    
    if(mysqli_num_rows($result) > 0)
    {
        $result = DeleteLike($tweetId, $userId);
        return $result;
    }
    else
    {
        $result = InsertLike($tweetId, $userId);
        return $result;
    }
}

function InsertLike($tweetId, $userId)
{
    $con = $GLOBALS["con"];
    $sql = "Insert into likes(tweet_id, user_id) VALUES($tweetId, $userId)";
    mysqli_query($con, $sql);
    if(mysqli_affected_rows($con) == 1)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function DeleteLike($tweetId, $userId)
{
    $con = $GLOBALS["con"];
    $sql = "Delete from likes where tweet_id = $tweetId AND user_Id = $userId";
    mysqli_query($con, $sql);
    if(mysqli_affected_rows($con) == 1)
    {
        return true;
    }
    else
    {
        return false;
    }
}

