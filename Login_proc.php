<?php 
include("connect.php"); 
include ("User.php");
?>
<?php 

//verify the user's login credentials. if they are valid redirect them to index.php/
//if they are invalid send them back to login.php
session_start();
$_SESSION["first_name"] ="";
$_SESSION["Last_name"] ="";
$_SESSION["user_Id"] ="";
$_SESSION["alert"] = "";
$_SESSION["retweet"]= "";
//$_SESSION["user_name"] = "";
function AddSlahes($value)
{
    $trim = trim($value);
    $result = addslashes($trim);
    $resultMain = strip_tags($result);
    //echo $resultMain;
    return $resultMain;
    
}

    if(isset($_POST["username"]) && isset($_POST["password"]))
    {
        //CONSTRUCTOR FOR USER
        $user = new User(0,AddSlahes($_POST["password"]),0,0,AddSlahes($_POST["username"]),0,0,0,0,0,0,0,0,0,0);
        User::LoginCheck($user);
      
    }
    
 
    

?>