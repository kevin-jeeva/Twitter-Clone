<?php
//this is the main page for our Bitter website, 
//it will display all tweets from those we are trolling
//as well as recommend people we should be trolling.
//you can also post a tweet from here
include("includes/functions.php");
include("includes/user.php");
include("includes/tweet.php");
include("connect.php");

//functions from includes/functions.php
redirect("login.php");
sendMessage("messageFollow");
sendMessage("ImageSuccess");
sendMessage("Error");

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Welcome to Bitter - The Social Media for Trolls, Narcissists, Bullies and Presidents">
    <meta name="author" content="Eduardo Graça, eduardogb6@gmail.com">
    <link rel="icon" href="favicon.ico">

    <title>Bitter - Social Media for Trolls, Narcissists, Bullies and Presidents</title>

    <!-- Bootstrap core CSS -->
    <link href="includes/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="includes/starter-template.css" rel="stylesheet">
    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.3.1.js" ></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <script>
    $(document).ready(function() {
            //hide the submit button on page load
            $("#button").hide();
            $("#message_form").submit(function() {
                //alert("submit form");
                $("#button").hide();
            });
            $("#message").focus(function() {
                this.attributes["rows"].nodeValue = 5;
                $("#button").show();
            }); //end of click event

            $("#to").keyup( //key up event for the user name textbox
                function(e) {

                    if (e.keyCode === 13) {
                        //don't do anything if the user types the enter key, it might try to submit the form
                        return false;
                    }
                    jQuery.get(
                        "UserSearch_AJAX.php",
                        $("#message_form").serializeArray(),
                        function(data) { //anonymous function
                            //uncomment this alert for debugging the directMessage_proc.php page
                            //alert(data);
                            //clear the users datalist
                            $("#dlUsers").empty();
                                    if (typeof (data.users) === "undefined") {
                                        $("#dlUsers").append("<option value='NO USERS FOUND' label='NO USERS FOUND '></option>");
                                    }

                                    $.each(data.users, function (index, element) {
                                        //this will loop through the JSON array of users and add them to the select box
                                        $("#dlUsers").append("<option value='" + element.name + "' label='" + element.name + "'></option>");
                                        //alert(element.id + " " + element.name);
                                    });

                                },
                                        //change this to "html" for debugging the UserSearch_AJAX.php page
                                        "json"
                                        );
                                //make sure the focus stays on the textbox so the user can keep typing
                                $("#to").focus();
                                return false;
                            }
                            );
                        }); //end of ready event handler

    </script>
  </head>

  <body>

    <?php include("Includes/header.php"); ?>
	
    <BR><BR>
    <div class="container">
		<div class="row">
			<div class="col-md-3">
				<div class="mainprofile img-rounded">
					
					<div class="bold">
						<!-- This is a important step: Gathering all user Pictures and Names -->
						<img class="bannericons" src="<?php 
							$User = new user($_SESSION["SESS_MEMBER_ID"], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                                                        $picture = user::getUserPicture($User, $con);
                                                        echo $picture;
						?>">
						<a href="userpage.php?user_id=<?php echo $_SESSION["SESS_MEMBER_ID"];?>">
							<?php echo $_SESSION["SESS_FIRST_NAME"] . " " . $_SESSION["SESS_LAST_NAME"] ?>		
						</a><BR>
					</div>
					
					<table>
					<tr>
						<td>tweets</td>
						<td>following</td>
						<td>followers</td>
					</tr>
					<tr>
						<td><?php
                                                        $User = new user($_SESSION["SESS_MEMBER_ID"], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                                                        user::TotalTweets($User, $con);
						?></td>
						<td><?php 
							$User = new user($_SESSION["SESS_MEMBER_ID"], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                                                        user::TotalFollowing($User, $con);
						?></td>
						<td><?php 
							$User = new user($_SESSION["SESS_MEMBER_ID"], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                                                        user::TotalFollowers($User, $con);
						?></td>
					</tr>
					</table>
                                    <img class="icon" src="images/location_icon.jpg">
                                    <?php
                                    $User = new user($_SESSION["SESS_MEMBER_ID"], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                                    $userinfo = user::getUserFullInfo($User, $con);
                                    echo $userinfo["province"];
                                    ?>
                                    <div class="bold">Member Since:</div>
                                    <div>
                                        <?php
                                        $User = new user($_SESSION["SESS_MEMBER_ID"], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                                        $userinfo = user::getUserFullInfo($User, $con);
                                        $date = date_create($userinfo["date_created"]);
                                        echo date_format($date, "F n, Y");
                                        ?>
                                    </div>
				</div><BR><BR>
				<div class="trending img-rounded">
					<div class="bold">Trending</div>
				</div>
				
			</div>
			<div class="col-md-6">
				<div class="TweetFeed img-rounded">
                                    
                                    <form method="post" id="message_form" action="DirectMessage_proc.php">
                                        <div class="form-group">
                                            Send message to: <input type="text" id="to" name="to" list="dlUsers" autocomplete="on"><br><br>
                                            <datalist id="dlUsers">
                                                <!-- this datalist is empty initially but will hold the list of users to select as the user is typing -->
                                            </datalist>
                                            <input type="hidden" name="userId" value="<?=$_SESSION["SESS_MEMBER_ID"]?>">
                                            <textarea class="form-control" name="message" id="message" rows="1" placeholder="Enter your message here"></textarea>
                                            <input type="submit" name="btnMessage" id="button" value="Send" class="btn btn-primary btn-lg btn-block login-button"/>
                                        </div>
                                    </form>
                                    <hr>
                                    
                                    <h2>Your Messages</h2>
                                    <hr>
                                    <!--display list of messages here - V6.2 -->
                                    <?php
                                        //constructor($userId, $UserName, $Email, $FirstName, $LastName, $Password, $Address, $Province, $postalCode, $ContactNo, $DateAdded, $profImage, $Location, $description, $url)
                                        $User = new user($_SESSION["SESS_MEMBER_ID"], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                                        user::GetAllMessages($User, $con);
                                    ?>	
				</div>
			</div>
			
			<div class="col-md-3">
				<div class="whoToTroll img-rounded">
				<div class="bold">Who to Troll?<BR></div>
				<!-- display people you may know here-->
                                <?php
                                    //constructor($userId, $UserName, $Email, $FirstName, $LastName, $Password, $Address, $Province, $postalCode, $ContactNo, $DateAdded, $profImage, $Location, $description, $url)
                                    $User = new user($_SESSION["SESS_MEMBER_ID"], 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                                    user::DisplayWhotoTroll($User, $con);    
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
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="includes/bootstrap.min.js"></script>

  </body>
</html>  