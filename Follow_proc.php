<?php include ("connect.php");?>
<?php
session_start();
$_SESSION["reload"] = "";
    if(isset($_POST["FollowVal"]))
{
    $user = $_POST["FollowVal"];
    
    $from_id = $_SESSION["user_Id"];
    $sql = "Insert into follows (from_id, to_id) values ($from_id, $user)";
    
    mysqli_query($con, $sql);
    
    if(mysqli_affected_rows($con) == 1)
    {
        $follow = $_POST["Following"];
        $_SESSION["alert"] = "You are following"." ".$follow;        
        header("location:index.php?");
    }
 else {
         $_SESSION["alert"] = "Not Following";
         header("location:index.php");
       }
    
}
  


?>