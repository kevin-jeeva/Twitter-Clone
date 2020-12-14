<?php

     $user = $_POST["username"];
     echo $user;
     $userMain = AddSlahes($user);
     $db = mysqli_connect("localhost:3308", "root", "","bitter-kevin")
		or die(mysql_error());
     $userSql = "Select * from users Where screen_name = UPPER('$userMain')";
     echo $userSql;
     $result = mysqli_query($db, $userSql);
     //echo $result;
     echo mysqli_num_rows($result);
    if(mysqli_num_rows($result) > 0)
    {
        $json_out = '{"msg":""}';
       // return false;
    }
    else
    {
        echo $userSql;
        $json_out = '{"msg":"sorry username is already taken, please try again"}';
        //return true;
    }
    echo $json_out;    


function AddSlahes($value)
{
    $trim = trim($value);
    $result = addslashes($trim);
    $resultMain = strip_tags($result);
    echo $resultMain;
    return $resultMain;
    
}
?>