<?php
//chapter 15 processing page
if(isset($_POST["submit"]))//user can't here directly
{ //attempt to upload the file
    if(empty($_FILES['pic']['name']))
    {
        echo "Error you must select a file";
        exit;
    }
    echo "file size is ".$_FILES['pic']['size']."<BR>";
    echo "File name is ".$_FILES['pic']['tmp_name'];
    print_r($_FILES['pic']);
    
   $MAX_FILE_SIZE = 10* 1024*1024; // 10MB
   if($_FILES['pic']['size'] > $MAX_FILE_SIZE)
   {
      unlink($_FILES['pic']['tmp_name']); // deletes the temp file dont store
      echo "File must be less than 10MB";   
   }
   else 
   {
       $destFile = "../Images/profilepics".$_FILES['pic']['name'];
       if(move_uploaded_file($_FILES['pic']['tmp_name'], "../Images/profilepics"))
       {
             echo "successfull";
       }
  else {
         echo "Error <BR>";    
         unlink($_FILES['pic']['tmp_name']); // deletes the temp file dont store
       }
         
   }
   
}
?>