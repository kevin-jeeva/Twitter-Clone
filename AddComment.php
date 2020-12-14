<?php
session_start();
$uId = $_SESSION["user_Id"];
//$tweetId = $_GET["value"];
//echo $_SESSION["user_Id"];
?>

<textarea type="text" class="text-field form-control" id="new_content"   placeholder="content"></textarea>
 <input type ="hidden" value ="<?=$uId?>" Id = "userId" name ="userId">