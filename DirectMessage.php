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
            $(document).ready(function() {
            //hide the submit button on page load
            $("#button").hide();
            $("#message_form").submit(function() {
            //alert("submit form");
            $("#button").hide();
            });
            $("#message").focus( function() {
            this.attributes["rows"].nodeValue = 5;
            $("#button").show();
            });//end of click event
            
             $("#to").keydown(//key down event for the user name textbox
                function(event) {
                    if (event.keyCode === 13) {
                        //don't do anything if the user types the enter key, it might try to submit the form
                        return false;
                    }
                }//end anonymous function
                );//end keydown event
            
            $("#to").keyup(//key up event for the user name textbox
                function() {
                console.log("here inside");
                jQuery.get(
                "UserSearch_AJAX.php",
                $("#message_form").serializeArray(),
                function(data) {//anonymous function
                //uncomment this alert for debugging the directMessage_proc.php page
                //alert(data.Name);
                   
                    $("#dlUsers").empty();
                    if (data.Name === false) {
                    $("#dlUsers").append("<option value='NO USERS FOUND' label='NO USERS FOUND'></option>");
                   
                    }
                    else
                    {
                        var options = '';
                        for(i = 0; i < data.length; i++)
                        {
                           $("#dlUsers").append("<option value='" + data[i]["screen"] + "' label='" + data[i]["Name"]+ "'></option>");                   
                        }
               }
                   
                },
                //change this to "html" for debugging the UserSearch_AJAX.php page
                "json "
                );
                //make sure the focus stays on the textbox so the user can keep typing
                $("#to").focus();
                return false;
                
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
                    <form method="GET" id="message_form" action="DirectMessage_proc.php">
                    <div class="form-group">
                    Send message to: <input type="text" id="to" name="to" list="dlUsers" autocomplete="off"><br>
                    <datalist id="dlUsers">
                    <!-- this datalist is empty initially but will hold the list of users to select as the user is typing -->
                    </datalist>
                    <input type="hidden" name="userId" value="<?=$userId?>">
                    <textarea class="form-control" name="message" id="message" rows="1" placeholder="Enter your message here"></textarea>
                    <input type="submit" name="button" id="button" value="Send" class="btn btn-primary btn-lg btn-block login-button"/>
                    </div>
                    </form>    
                    </div>
                   <?php
                   
                   $userId = $_SESSION["user_Id"];
                   User::GetAllMessages($userId)?>
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
            </div>
        </div>
    </body>
</html>

<?php
if (isset($_SESSION["alert"]) && ($_SESSION["alert"] != "")) {
    $message = $_SESSION["alert"];
    echo "<script>alert('$message')</script>";
    $_SESSION["alert"] = "";
}
?>


