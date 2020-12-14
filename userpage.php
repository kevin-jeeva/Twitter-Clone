<?php
//displays all the details for a particular Bitter user
include("connect.php");
include_once("User.php");
include_once("Tweet.php");
session_start();
if(isset($_GET["userId"]))
{
    $userId = $_GET["userId"];
    if($userId == null || $userId == "")
    {
         header("location:index.php");
    }
}
else
{
    header("location:index.php");
}
//echo $userId;
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Bitter - Social Media for Trolls, Narcissists, Bullies and Presidents</title>

    <!-- Bootstrap core CSS -->
    <link href="includes/bootstrap.min.css" rel="stylesheet">
     <script type="text/javascript" src="includes/jquery-3.3.1.min.js"></script>
      <script src="includes/bootstrap.min.js"></script>
    <!-- Custom styles for this template -->
    <link href="includes/starter-template.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<!-- Bootstrap core JavaScript-->
   
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
            
            $(document).ready(function () {
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

     <?php include_once("includes/Header.php");?>
	
	<BR><BR>
    <div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="mainprofile img-rounded">
				<div class="bold">
                                 <?php User::DisplayPic($userId);?>
				<BR></div>
				<table>
				<tr><td>
				tweets</td><td>following</td><td>followers</td></tr>
				<tr><td><?php Tweet::DisplayNumTweets($userId)?></td><td><?php Tweet::DisplayNumFollowing($userId)?></td><td><?php Tweet::DisplayNumFollowers($userId)?></td>
				</tr></table>
				<img class="icon" src="images/location_icon.jpg"><?php User::DisplayProvince($userId)?>
				<div class="bold">Member Since:</div>
				<div><?php User::DisplayDate($userId)?></div>
				</div><BR><BR>
				
				<div class="trending img-rounded">
				<div class="bold"><?php Tweet::DisplayNumFollowersKnow($userId)?> &nbsp;Followers you know<BR>
				<?php Tweet::DisplayFollowersKnow($userId)?>
				</div>
				</div>
				
			</div>
                        
			<div class="col-md-6">
				<div class="img-rounded">
				<?php
                                
                                   $user = new User($userId,0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                                   Tweet::DisplayUserInfo($user);
                                  ?>
                                  
				</div>
				
			</div>
			<div class="col-md-3">
				<div class="whoToTroll img-rounded">
				<div class="bold">Who to Troll?<BR></div>
				<?php
                                    $user = new User($_SESSION["user_Id"], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                                    $result = User::GetFollws($user);
                                    User::DisplayFollows($result);
                                 ?>				
				
				</div><BR>
				
			</div>
		</div> <!-- end row -->
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
                            <form id ="frmSubmitComment" method="get" name ="frmSubmitComment" onsubmit="return frm_reply();" action ="index.php" >
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
    </div><!-- /.container -->
 
  </body>
</html>
