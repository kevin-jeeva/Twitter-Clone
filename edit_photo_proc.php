<?php 
include("connect.php");
include("User.php");
session_start();
$picName;
$allowedType = array(IMAGETYPE_PNG,IMAGETYPE_JPEG, IMAGETYPE_ICO, IMAGETYPE_GIF, IMAGETYPE_BMP);
if(isset($_POST["submit"]))
{
 
    if(empty($_FILES['pic']['name']))
    {
        $_SESSION["alert"] = "Error you must select a file";
        header("location:edit_photo.php");
        exit;
        
    }
    else
    {
        $detectedType = exif_imagetype($_FILES['pic']['tmp_name']);
        $error = in_array($detectedType,$allowedType );
        echo $error;
          if($error)
          {
               
          
            $MAX_FILE_SIZE = 10*1024*1024;
            if($_FILES['pic']['size'] > $MAX_FILE_SIZE)
            {
                unlink($_FILES['pic']['tmp_name']);
                $_SESSION["alert"] = "Files should be less than 10MB";
                header("location:edit_photo.php");
                exit;
            }
            else
            {
                $user = new User($_SESSION["user_Id"],0,0,0,0,0,0,0,0,0,0,0,0,0,0);
               // $user = $_SESSION["user_Id"];
                $sql = "select profile_pic from users where user_id = $user->userId";
                if($result = mysqli_query($con, $sql))
                {
                    if($values = mysqli_fetch_array($result))
                    {
                        $user->profileImage = $_SESSION["user_Id"].time().".png";                      
                        //$newfile = $picName;
                        $_FILES['pic']['name'] = $user->profileImage;//$newfile;
                         if($values["profile_pic"] == null)
                         {

                            $newPic = "update users set profile_pic = '$user->profileImage' where user_id = $user->userId";
                           
                           if(mysqli_query($con, $newPic))
                           {
                                if(move_uploaded_file($_FILES['pic']['tmp_name'], 'Images/profilepics/'.$_FILES['pic']['name']))
                                {
                                        $_SESSION["alert"] = "Your photo have uploaded successfully";
                                        header("location:index.php");
                                        clearstatcache();
                                } 
                                else
                                {
                                       $_SESSION["alert"] = "Your photo have not uploaded successfully";
                                       header("location:edit_photo.php");
                                        unlink($_FILES['pic']['tmp_name']);
                                 }

                           }
                           else
                           {           $_SESSION["alert"] = "database error";
                                        header("location:edit_photo.php");
                                        unlink($_FILES['pic']['tmp_name']);
                           }
                           
                         }
                         else
                         {
                           // $picName = $_SESSION["user_Id"].".jpg";
                            $newPic = "update users set profile_pic = '$user->profileImage' where user_id = $user->userId";
                            
                            if(mysqli_query($con, $newPic))
                            {
                                if(move_uploaded_file($_FILES['pic']['tmp_name'], 'Images/profilepics/'.$_FILES['pic']['name']))
                                {
                                        $_SESSION["alert"] = "Your photo have updated successfully";
                                        header("location:index.php");
                                        clearstatcache();
                                } 
                                else
                                {
                                        $_SESSION["alert"] = "Your photo have not uploaded successfully";
                                        header("location:edit_photo.php");
                                        unlink($_FILES['pic']['tmp_name']);
                                 }
                                 
                             }
                             else
                             {          $_SESSION["alert"] = "database error";
                                        header("location:edit_photo.php");
                                        unlink($_FILES['pic']['tmp_name']);
                             }

                         }
                    }
                }


            }
         

    }
    else
    { 
        $_SESSION["alert"] = "Please select a valid image format";
       // echo $_SESSION["alert"];
        header("location:edit_photo.php");
        unlink($_FILES['pic']['tmp_name']);
    }
    
    }
}
 else 
 {
        $_SESSION["alert"] = "You have to select a file";
       header("location:edit_photo.php");
        exit;
 }
    
 
?>