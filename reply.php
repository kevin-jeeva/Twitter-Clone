<?php 
include_once("connect.php");
include_once("User.php");
include_once("Tweet.php");
session_start();
if (isset($_SESSION["user_Id"])) 
{
    //header("location:index.php");
    //exit;
}
else
{
    header("location:Login.php");
}
?>
<!--<html>
    <head>
    <title>
        Reply Tweet
    </title>
     <script type="text/javascript" src="includes/jquery-3.3.1.min.js"></script>
     <link href="includes/bootstrap.min.css" rel="stylesheet">
      <link href="includes/starter-template.css" rel="stylesheet">
     <link rel="stylesheet" type="text/css" href="Includes/ajaxDemo.css" />
     <script type="text/javascript">
         function frm_reply()
         {
            
            if(Validate() === true)
            {
             jQuery.get("replyproc.php",$("#frmComment2").serializeArray(),
             function(data)
                    { 
                        console.log(data.msg);
                        if(data.msg == "true")
                        {
                           
                            //alert("you have succesfully replied");
                            
                        }
                        else
                        {
                            //alert("your reply is unsuccessful");
                            
                        }
                       
                    },"json");
                    
                    
             return true;
             }
             else
             {
                return false;
             }
         }
         function Validate()
         {
             var v = document.getElementById("txtComment2").value;
             v = v.trim();
             if(v == "")
             {
                 alert("Please fill the comment");
                 return false;
             }
             else
             {
                 return true;
             }
         }
         
     </script>
     </head>
     <body>
        
         <?php //include("includes/Header.php"); ?>
        
      
         <BR><BR>
         <div class ="container">
             <div class ="row">
                 <div class ="col-md-12">
                     <div class ="img-rounded">
                         <div class ="form-group">
                            <!-- <form id="replyform" onsubmit="return frm_reply()" action="index.php">-->
                                 <!--<?php
                                 /*$value=0;
                                 $tweetId=0;
                                 $orgTweetId=0;
                                 $repUserId=$_SESSION["user_Id"];
                                 if(isset($_GET["value"]))
                                 {
                                   $value = $_GET["value"];
                                  if(strpos($value, "|") == false)
                                  {    
                                    
                                      $tweetId = $value;
                                  }else{
                                      $value= explode("|",$value);
                                      $tweetId  = $value[0];
                                      $orgTweetId =$value[1];
                                      echo $orgTweetId;
                                  }
                                 
                               
                                 $result = Tweet::GetTweetById($tweetId);
                                 
                                 if($result = mysqli_fetch_array($result))
                                 {
                                     $singleUser = new User($result["user_id"],0,0,0,0,0,0,0,0,0,0,0,0,0,0);
                                     $getUserResult = User::GetUserDetailsById($singleUser);
                                     
                                     if($userVal = mysqli_fetch_array($getUserResult))
                                     {
                                         $singleUser->firstName = $userVal["first_name"];
                                         $singleUser->lastName = $userVal["last_name"];
                                         $singleUser->usertName = $userVal["screen_name"];
                                         
                                         $userTitle =  $singleUser->firstName." ". $singleUser->lastName." @".$singleUser->usertName;
                                         $mainComment = $result["tweet_text"];
                                         
                                        // echo $userTitle." ".$mainComment;
                                     }
                                 }
                                 else
                                 {
                                     echo "Cannot get the tweet and the user Id";
                                 }
                                 }
                                 else
                                 {
                                     $mainComment = "";
                                     $userTitle = "";
                                 }
                                 ?>-->
                                 <!--<BR><BR><BR><BR>
                                 <div class ="col-lg">
                                 <h3><a href ="#"><?=$userTitle?></a></h3><br/>   
                                 <div>
                                     <h2> Comment</h2>
                                     <div class = "card">
                                         <div class ="card-body">
                                             <p><?=$mainComment?></p></div></div></div><hr/>
                                <form id="frmComment2" method = "get" name ="frmComment2" onsubmit="return frm_reply();" action="index.php">
                                <div class ="col-lg-10"><h2>Write your Reply</h2>
                                 <textarea  name="txtComment2" id = "txtComment2" cols="40" rows="5"></textarea><br>
                                 <input type="submit" class ="btn btn-success btn-lg" value="Submit" name="submit2"/>
                                 <input type ="hidden" value ="<?=$tweetId?>" name ="tweetId">
                                 <input type ="hidden" value ="<?=$repUserId?>" name ="repUserId">
                                 <input type ="hidden" value ="<?=$orgTweetId?>" name ="OrgUserId">
                                 </div>
                                 </form>
                                 </div>
                             
                         </div>
                     </div>
                 </div>
             </div> 
         </div>
             </div>
             </div>
     </body>
</html>