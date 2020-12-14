<?php

include_once("User.php");
include_once("connect.php");
include_once("Tweet.php");
session_start();
if(isset($_POST["search"]))
{
    $search = $_POST["search"];
    $search = AddSlahes($search);
    if(!($search == true))
    {
        $_SESSION["alert"] = "Please fill out the search feild";
        header("location:index.php");
    }
    else
    {
        
    }
}
else
{
    header("location:index.php");
}
    
function AddSlahes($value)
{
    $trim = trim($value);
    if($trim == "")
    {
        return false;
    }
    $result = addslashes($trim);
    $resultMain = strip_tags($result);
    //echo $resultMain;
    return $resultMain;
    
}
?>
<html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Contact Us Page">
    <meta name="author" content="Kevin Daniel">
    <link rel="icon" href="favicon.ico">
    <title>Search</title>
    <!-- Bootstrap core CSS -->
    <link href="includes/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="includes/starter-template.css" rel="stylesheet">
	<!-- Bootstrap core JavaScript-->
        <script type="text/javascript" src="includes/jquery-3.3.1.min.js"></script>
        <script src="includes/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<script>
            
            function frm_reply()
           {
               
             
             jQuery.get("replyproc.php",$("#frmSubmitComment").serializeArray(),             
             function(data)
                    { 
                        
                        alert(data.msg);
                        console.log("here i come");
                        //console.log(data.msg);
                        if(data.msg == true)
                        {
                           console.log("heresss");
                           alert("you have succesfully replied");
                            
                        }
                        else
                        {
                            console.log("heresss");
                            alert("your reply is successfully posted");
                            
                        }
                       
                    },"json");
                    
                return true;
             }
            
        
    
        </script>
	<script>
	//just a little jquery to make the textbox appear/disappear like the real Twitter website does
	$(document).ready(function() {
		//hide the submit button on page load
		$("#button").hide();
		$("#tweet_form").submit(function() {
			
			$("#button").hide();
		});
		$("#myTweet").click( function() {			
			this.attributes["rows"].nodeValue = 5;
			$("#button").show();
			
		});//end of click event
		$("#myTweet").blur( function() {			
			this.attributes["rows"].nodeValue = 1;
                        //$("#button").hide();

		});//end of click event
                
                 $("#myModal").on('show.bs.modal', function (event) {
                     console.log("here finally");
                      var button = $(event.relatedTarget); // Button that triggered the modal
                      var Id = button.data('tweetid');
                       document.getElementById("tweetIdValue").value = Id;
                       
                     // alert(Id);
                      });
	});//end of ready event handler
    
	</script>

    </head>
    
    <body>
         <?php 
       
         include("includes/Header.php");?><BR><BR><BR><BR>
        <div class="container">
		<div class="row">
			<div class="col-md-12">
                            <div class="img-rounded">
                                <?php
                                User::SearchUser($search);
                                echo"<hr/>";
                                Tweet::DisplaySearchTweet($search);
                                ?>
                            </div>
                        </div>
                    <div class="modal" id="myModal">
                    <div class="modal-dialog">
                      <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h4 class="modal-title">Write your reply</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div>
                            <form id ="frmSubmitComment" method="get" name ="frmSubmitComment" onsubmit="return frm_reply();">
                        <div class="modal-body">
                       
                        <textarea  name="txtCommentAjax" id = "txtCommentAjax" cols="40" rows="5"></textarea><br>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                          <input type ="submit"  class ="btn btn-success btn-md" value="Comment" id="btnSubmitComment" name ="btnSubmitComment">
                          <input type ="hidden" value ="<?=$_SESSION["user_Id"]?>" id ="repUserId" name ="repUserId">
                          <input type ="hidden" id ="tweetIdValue" value="" name ="tweetIdValue">
                        </div>
                        </form>
                        </div><!--form div-->
                      </div>
                    </div>
                  </div>
                </div>
        </div> 
    </body>
</html>