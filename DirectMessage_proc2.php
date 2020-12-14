<?php

include("includes/functions.php");
include("includes/user.php");
include("includes/tweet.php");
include("connect.php");

$userId = htmlentities(htmlspecialchars($_POST["userId"]));
$text = htmlentities(htmlspecialchars($_POST["message"]));
$text = strip_tags(addslashes($text));

//insert a message into the database
if (isset($_POST['btnMessage'])) {
    $User = new user($_SESSION["SESS_MEMBER_ID"], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
    user::AddMessage($User, $userId, $text, $con); 
}