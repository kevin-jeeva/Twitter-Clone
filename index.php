<?php
include("connect.php");
include_once("User.php");
include_once("Tweet.php");
?>
<?php
//this is the main page for our Bitter website, 
//it will display all tweets from those we are trolling
//as well as recommend people we should be trolling.
//you can also post a tweet from here
session_start();
$userId = $_SESSION["user_Id"];

if (isset($_SESSION["user_Id"])) {
    // header("location:index.php");
    //exit;
} else {
    // session_destroy();
    header("location:Login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="bitter index page">
        <meta name="author" content="Kevin Daniel">
        <link rel="icon" href="favicon.ico">

        <title>Bitter - Social Media for Trolls, Narcissists, Bullies and Presidents</title>

        <!-- Bootstrap core CSS -->
        <link href="includes/bootstrap.min.css" rel="stylesheet">
        <!--<link rel="stylesheet" type="text/css" href="includes/ajaxDemo.css" />-->
        <!-- Custom styles for this template -->
        <link href="includes/starter-template.css" rel="stylesheet">
        <!-- Bootstrap core JavaScript-->
       <!-- <script src="https://code.jquery.com/jquery-1.10.2.js" ></script>-->
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
            
            $(document).ready(function () {
              
                 console.log("refreshed");
                $("#button").hide();
                $("#tweet_form").submit(function () {

                    $("#button").hide();
                });
                $("#myTweet").click(function () {
                    this.attributes["rows"].nodeValue = 5;
                    $("#button").show();

                });//end of click event
                /* $("#retwt").click(function(){
                 alert("hello world");
                 });*/
                $("#myTweet").blur(function () {
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
        <?php include("includes/Header.php"); 
        $TwId=0;?>

        <BR><BR>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="mainprofile img-rounded">
                        <div class="bold">
                            <img class="bannericons" src="">
                            <a href="userpage.php?userId=<?=$_SESSION["user_Id"]?>"><?php User::DisplayPic($userId);?></a><BR></div>
                        <table>
                            <tr><td>
                                    tweets</td><td>following</td><td>followers</td></tr>
                            <tr><td><?php Tweet::DisplayNumTweets($userId)?></td><td><?php Tweet::DisplayNumFollowing($userId)?></td><td><?php Tweet::DisplayNumFollowers($userId)?></td>
                            </tr></table><BR><BR><BR><BR><BR>
                    </div><BR><BR>
                    <div class="trending img-rounded">
                        <div class="bold">Trending</div>
                    </div>

                </div>
                <div class="col-sm-6">
                    <div class="img-rounded">
                        <form method="post" id="tweet_form" action="tweet_proc.php">
                            <div class="form-group">
                                <textarea class="form-control" name="myTweet" id="myTweet" rows="1" placeholder="What are you bitter about today?"></textarea>
                                <input type="submit" name="button" id="button" value="Send" class="btn btn-primary btn-lg btn-block login-button"/>

                            </div>
                        </form>
                    </div>
                    <div class="img-rounded">


                        <!--display list of tweets here-->
                        <?php
                        $user = new User($_SESSION["user_Id"], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

                        //GET ALL THE TWEETS ACCORDING TO THE USER INFO
                        $result = Tweet::GetTweetIdByFollows($user);

                        //DISPLAY ALL THE TWEETS, RETEWEETS, REPLIES AND REPLIES TO REPLIES
                        Tweet::GetTweets($result);
                        ?>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="whoToTroll img-rounded">
                        <div class="bold">Who to Troll?<BR></div>
                        <!-- display people you may know here-->
                        <?php
//DISPLAY THE FOLLOWS
                        $result = User::GetFollws($user);
                        User::DisplayFollows($result);
                        ?>             

                    </div><BR>
                    
                    <!--don't need this div for now 
                    <div class="trending img-rounded">
                    © 2018 Bitter
                    </div>-->
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
   </div><!-- /.container -->

    
         
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <!--<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>-->
        
    

    </body>
</html>

<?php
if (isset($_SESSION["alert"]) && ($_SESSION["alert"] != "")) {
    $message = $_SESSION["alert"];
    echo "<script>alert('$message')</script>";
    $_SESSION["alert"] = "";
}
?>
 