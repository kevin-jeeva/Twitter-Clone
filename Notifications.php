<?php
/*echo "this page will display a list of all recent likes of the current user's tweets<BR>";
echo "as well as a list of retweets of a current user's tweets<BR>";
echo "this will be similar to https://twitter.com/i/notifications";*/

?>

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
                        <h2>Likes</h2><BR>
                        <?php Tweet::GetRecentLikes($_SESSION["user_Id"])?>
                       
                        <h2>Retweet</h2><BR>
                        <?php Tweet::GetRecentReTweet($_SESSION["user_Id"])?>
                        
                        <h2>Replies</h2><BR>
                        <?php Tweet::GetRecentReplies($_SESSION["user_Id"])?>
                       
                    </div>
                    <div class="img-rounded">

                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="whoToTroll img-rounded">
                        <div class="bold">Who to Troll?<BR></div>
                        <!-- display people you may know here-->
                        <?php
                        $user = new User($_SESSION["user_Id"], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
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