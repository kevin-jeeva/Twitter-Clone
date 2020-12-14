<?php
 //session variable - Chap17
 //internet is stateless - each request is completely seperate and knows nothing 
 //about any other request
 //default session timeout to twenty minutes

 session_start(); // use this every time you want to use the session variables
 
 $_SESSION["name"] = "Kevin";//this is similar to what you will put on login_proc
 
 echo session_id()." my sessioon id"."<BR>";
 echo session_encode()." all my session variables <BR>";//display all the session variables
 
 echo $_SESSION["name"]."<BR>"; 
        
 //loginout.php page
 session_unset(); //remove all session variables from memory
 session_destroy();//kills the session completely - this is one is fine
 //redirect to the login page with header location
 echo session_encode()."all my session variables";
 
 ?>