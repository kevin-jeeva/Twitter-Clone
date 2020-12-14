<?php
class User {
  // Properties
  private $userId;
  private $UserName;
  private $Email;
  private $FirstName;
  private $LastName;
  private $Password;
  private $Address;
  private $Province;
  private $postalCode;
  private $ContactNo;
  private $DateAdded;
  private $profImage;
  private $Location;
  private $description;
  private $url;
  
  //constructor
  function __construct($userId, $UserName, $Email, $FirstName, $LastName, $Password, $Address, $Province, $postalCode, $ContactNo, $DateAdded, $profImage, $Location, $description, $url) {
    $this->userId = $userId;
    $this->UserName = $UserName;
    $this->Email = $Email;
    $this->FirstName = $FirstName;
    $this->LastName = $LastName;
    $this->Password = $Password;
    $this->Address = $Address;
    $this->Province = $Province;
    $this->postalCode = $postalCode;
    $this->ContactNo = $ContactNo;
    $this->DateAdded = $DateAdded;
    $this->profImage = $profImage;
    $this->Location = $Location;
    $this->description = $description;
    $this->url = $url;
  }
  
  //destructor
  function __destruct() {
  }

  // Methods
  public function __get($UserName) {
    return $this->$UserName;
  }

  public function __set($UserName, $value) {
    $this->property = $value;
  }
  
  public static function SignupUser($user, $connection) {
      $sql = "INSERT INTO users(first_name,last_name,screen_name,password,address,province,postal_code,contact_number,email,url,description,location) "
                . "VALUES('$user->FirstName','$user->LastName','$user->UserName','$user->Password','$user->Address','$user->Province','$user->postalCode','$user->ContactNo','$user->Email','$user->url','$user->description','$user->Location')";
        mysqli_query($connection, $sql);
        if (mysqli_affected_rows($connection) == 1) {
            $msg = "NEW TROLL USER ACCEPTED AND INSERTED!";
        } else {
            $msg = "Error to insert a user. What a shame!";
        }
      return $msg;
  }
  
  public static function LoginUser($user, $connection){
        $db_user_id = "";
        $db_first_name = "";
        $db_last_name = "";
        $db_screen_name = "";
        $db_password = "";

        $sql = "SELECT user_id, first_name, last_name, screen_name, password FROM users WHERE screen_name = '$user->UserName'";
        if ($result = mysqli_query($connection, $sql)) {
            while ($row = mysqli_fetch_array($result)) {
                //Associative Array: Array that indexes with a string instead of a number.
                $db_user_id = $row["user_id"];
                $db_first_name = $row["first_name"];
                $db_last_name = $row["last_name"];
                $db_screen_name = $row["screen_name"];
                $db_password = $row["password"];
            }
        }

        // check the username
        if ($user->UserName == $db_screen_name) {
            //V3.2 - Checking the password
            if (password_verify($user->Password, $db_password)) {
                $_SESSION["SESS_FIRST_NAME"] = $db_first_name;
                $_SESSION["SESS_LAST_NAME"] = $db_last_name;
                $_SESSION["SESS_MEMBER_ID"] = $db_user_id;
                return $db_user_id;
            } else {
                return -1;
            }
        } else {
                return -2;
        }
    }
    
    public static function getUserPicture($user, $connection){
        $db_profile_pic = "";
        $sql = "SELECT profile_pic FROM users WHERE user_id = '$user->userId'";
        if ($result = mysqli_query($connection, $sql)) {
            while ($row = mysqli_fetch_array($result)) {
                //Associative Array: Array that indexes with a string instead of a number.
                $db_profile_pic = $row["profile_pic"];
            }
        }
        return $db_profile_pic;
    }
    
    public static function getUserFullInfo($user, $connection){
        $db_userinfo = array();
        $sql = "SELECT first_name, last_name, province, date_created, profile_pic FROM users WHERE user_id = '$user->userId'";
        if ($result = mysqli_query($connection, $sql)) {
            while ($row = mysqli_fetch_array($result)) {
                //Associative Array: Array that indexes with a string instead of a number.
                $db_userinfo["full_name"] = $row["first_name"] . ' ' . $row["last_name"];
                $db_userinfo["province"] = $row["province"];
                $db_userinfo["date_created"] = $row["date_created"];
                $db_userinfo["profile_pic"] = $row["profile_pic"];
            }
        }
        return $db_userinfo;
    }
    
    public static function getUserFullInfoAJAX($user, $screenName, $connection){
        $db_userinfo = array();
        $strSQL = "SELECT * FROM users WHERE screen_name LIKE '%".$screenName."%' AND user_id IN (SELECT to_id FROM follows WHERE from_id = " . $user->userId . ")";
        if ($result = mysqli_query($connection, $sql)) {
            while ($row = mysqli_fetch_array($result)) {
                //Associative Array: Array that indexes with a string instead of a number.
                 $db_userinfo[] = array('name' => $row["first_name"].' '.$row["last_name"]);
            }
        }
        return $db_userinfo;
    }
    
    public static function DisplayWhotoTroll($user, $connection){
        $member_id = $user->userId;
        $strSQL = "SELECT user_id, first_name, last_name, screen_name, profile_pic FROM users WHERE user_id <> " . $user->userId . " AND user_id NOT IN (SELECT to_id FROM follows WHERE from_id = " . $user->userId . ") ORDER BY RAND() LIMIT 3";
        $rsUsers = mysqli_query($connection, $strSQL) or die('Could not connect: ' . mysql_error());

        while ($rowUsers = mysqli_fetch_array($rsUsers)) {
            $member_id = $rowUsers["user_id"];
            if ($rowUsers["profile_pic"] == "") {
                $img = "images/profilepics/default.jfif";
            } else {
                $img = $rowUsers["profile_pic"];
            }
            echo '<div class="bold"><img class="bannericons" src="' . $img . '">'
            . '<a href="userpage.php?user_id=' . $rowUsers["user_id"] . '">'
            . $rowUsers["first_name"] . ' ' . $rowUsers["last_name"] . ' @' . $rowUsers["screen_name"]
            . '</a><BR></div>'
            . '<form method="get" id="follow_form" action="follow_proc.php"><div class="form-group">'
            . '<input name="user" type="hidden" value="' . $member_id . '"/>'
            . '<input type="submit" name="follow" value="Follow" class="btn btn-dark"/></div></form>'
            . '<hr>';
        }
    }
    
    public static function TotalSameFollowers($user, $connection, $otherid) {
        $strSQL = "SELECT COUNT(user_id) as total FROM users WHERE user_id NOT IN('$user->userId', '$otherid') AND user_id IN(SELECT to_id FROM follows WHERE from_id = '$user->userId' AND to_id IN(SELECT to_id FROM follows WHERE from_id = '$otherid'))";
        $rsResults = mysqli_query($connection, $strSQL) or die('Could not connect: ' . mysql_error());
        $data = mysqli_fetch_array($rsResults);
        echo $data['total'];
    }

    public static function DisplayFollowersYouKnow($user, $connection, $otherid){
        $member_id = $user->userId;
        $strSQL = "SELECT first_name, last_name, screen_name, profile_pic, user_id FROM users WHERE user_id NOT IN('$user->userId', '$otherid') AND user_id IN(SELECT to_id FROM follows WHERE from_id = '$user->userId' AND to_id IN(SELECT to_id FROM follows WHERE from_id = '$otherid')) ORDER BY RAND() LIMIT 3;";
        $rsUsers = mysqli_query($connection, $strSQL) or die('Could not connect: ' . mysql_error());

        while ($rowUsers = mysqli_fetch_array($rsUsers)) {
            $member_id = $rowUsers["user_id"];
            if ($rowUsers["profile_pic"] == "") {
                $img = "images/profilepics/default.jfif";
            } else {
                $img = $rowUsers["profile_pic"];
            }
            echo '<div class="bold"><img class="bannericons" src="' . $img . '">'
            . '<a href="userpage.php?user_id=' . $rowUsers["user_id"] . '">'
            . $rowUsers["first_name"] . ' ' . $rowUsers["last_name"] . ' @' . $rowUsers["screen_name"]
            . '</a><BR></div>'
            . '<hr>';
        }
    }
    
    public static function FollowUser($user, $connection, $id){
        $sql = "";
        $msg = "";
        if ($id != $user->userId) {
            //insert statement
            $sql = "INSERT INTO follows(from_id, to_id) VALUES('$user->userId','$id')";
            
            mysqli_query($connection, $sql);
            if (mysqli_affected_rows($connection) == 1) {
                //select statement
                $sql = "select screen_name from users where user_id = '$id'";
                if ($result = mysqli_query($connection, $sql)) {
                    while ($row = mysqli_fetch_array($result)) {
                        //Associative Array: Array that indexes with a string instead of a number.
                        $screen_name = $row["screen_name"];
                    }
                }
                $msg = "You are NOW FOLLOWING @" . $screen_name . "!";
                return $msg;
            } else {
                $msg = "Error in following an user. What a shame!";
                return $msg;
            }
        }
    }
    
    public static function DisplayTweetFeed($user, $connection){
        $strSQL = "SELECT tweets.tweet_id, tweets.tweet_text, tweets.date_created, tweets.original_tweet_id, tweets.reply_to_tweet_id, users.user_id, users.first_name, users.last_name, users.screen_name FROM tweets INNER JOIN users ON tweets.user_id = users.user_id WHERE users.user_id = " . $user->userId . " AND tweets.reply_to_tweet_id = 0 OR users.user_id IN (SELECT to_id FROM follows WHERE from_id = " . $user->userId . ") ORDER BY tweets.date_created DESC LIMIT 10";
        $rsTweets = mysqli_query($connection, $strSQL) or die('Could not connect: ' . mysql_error());
        $html_result = "";
        while ($rowUsers = mysqli_fetch_array($rsTweets)) {  
            if (!$rowUsers["original_tweet_id"] == 0){
                $strSQL2 = "SELECT tweets.user_id, users.user_id, users.first_name, users.last_name FROM tweets INNER JOIN users ON tweets.user_id = users.user_id WHERE tweets.tweet_id = " . $rowUsers["original_tweet_id"];
                $rsRetweets = mysqli_query($connection, $strSQL2) or die('Could not connect: ' . mysql_error());
                
                while ($rowRetUser = mysqli_fetch_array($rsRetweets)) {
                    $html_result = '<div class="t-header">'
                    . '<a href="userpage.php?user_id=' . $rowUsers["user_id"] . '">'
                    . $rowUsers["first_name"] . ' ' . $rowUsers["last_name"] . ' @' . $rowUsers["screen_name"]
                    . '</a>' . ' ' . getTweetTime($rowUsers["date_created"]) . ' <b> retweeted from ' . $rowRetUser["first_name"] . ' ' . $rowRetUser["last_name"] . '</b></div>' . '<BR>';
                }
            
            }else{
                $html_result = '<div class="t-header">'
                . '<a href="userpage.php?user_id=' . $rowUsers["user_id"] . '">'
                . $rowUsers["first_name"] . ' ' . $rowUsers["last_name"] . ' @' . $rowUsers["screen_name"]
                . '</a>' . ' ' . getTweetTime($rowUsers["date_created"]) . '</div>' . '<BR>';
            }
            
            $html_result .= '<div class="t-text">'
            . $rowUsers["tweet_text"] . '<BR><BR></div>'
            . '<div class="t-icons">'
            . '<form method="post" action="likeTweet.php">'
            . '<input name="origTweetId" type="hidden" value="' . $rowUsers["tweet_id"] . '"/>'
            . '<input name="origUserId" type="hidden" value="' . $rowUsers["user_id"] . '"/>'
            . '<input class="input_image_like" type="submit" name="likeClick" value="like" />'
            . '</form>'
            . '<form method="post" action="retweet.php">'
            . '<input name="origTweetText" type="hidden" value="' . $rowUsers["tweet_text"] . '"/>'
            . '<input name="origTweetId" type="hidden" value="' . $rowUsers["tweet_id"] . '"/>'
            . '<input class="input_image_ret" type="submit" name="retweetClick" value="Retweet" />'
            . '</form>'
            . '<form method="post" action="reply.php">'
            . '<input name="origTweetText" type="hidden" value="' . $rowUsers["tweet_text"] . '"/>'
            . '<input name="origTweetId" type="hidden" value="' . $rowUsers["tweet_id"] . '"/>'
            . '<input class="input_image_rep" type="submit" name="replyClick" value="Reply" />'
            . '</form>'
            . '</div>'
            . '<hr>';
            
            $strSQL3 = "SELECT tweets.tweet_id, tweets.tweet_text, tweets.date_created, users.user_id, users.first_name, users.last_name, users.screen_name FROM tweets INNER JOIN users ON tweets.user_id = users.user_id WHERE tweets.reply_to_tweet_id = " . $rowUsers["tweet_id"];
            $rsReplies = mysqli_query($connection, $strSQL3) or die('Could not connect: ' . mysql_error());

            while ($rowRepUser = mysqli_fetch_array($rsReplies)) {
                $html_result .= '<div class="r-block"><div class="r-header">'
                        . '<b> replied from </b><a href="userpage.php?user_id=' . $rowRepUser["user_id"] . '">'
                        . $rowRepUser["first_name"] . ' ' . $rowRepUser["last_name"] . ' @' . $rowRepUser["screen_name"]
                        . '</a></b>' . ' ' . getTweetTime($rowRepUser["date_created"]) . '</div>' . '<BR>'
                        . '<div class="r-text">'
                        . $rowRepUser["tweet_text"] . '<BR><BR></div>'
                        . '<div class="t-icons">'
                        . '<form method="post" action="likeTweet.php">'
                        . '<input name="origTweetId" type="hidden" value="' . $rowRepUser["tweet_id"] . '"/>'
                        . '<input name="origUserId" type="hidden" value="' . $rowRepUser["user_id"] . '"/>'
                        . '<input class="input_image_like" type="submit" name="likeClick" value="like" />'
                        . '</form>'
                        . '<form method="post" action="retweet.php">'
                        . '<input name="origTweetText" type="hidden" value="' . $rowRepUser["tweet_text"] . '"/>'
                        . '<input name="origTweetId" type="hidden" value="' . $rowRepUser["tweet_id"] . '"/>'
                        . '<input class="input_image_ret" type="submit" name="retweetClick" value="Retweet" />'
                        . '</form>'
                        . '<form method="post" action="reply.php">'
                        . '<input name="origTweetText" type="hidden" value="' . $rowRepUser["tweet_text"] . '"/>'
                        . '<input name="origTweetId" type="hidden" value="' . $rowRepUser["tweet_id"] . '"/>'
                        . '<input class="input_image_rep" type="submit" name="replyClick" value="Reply" />'
                        . '</form>'
                        . '</div></div>'
                        . '<hr>';
            }

            echo $html_result;
        }
    }
    
    public static function DisplayUserTweetFeed($user, $connection) {
        $strSQL = "SELECT tweets.tweet_id, tweets.tweet_text, tweets.date_created, tweets.original_tweet_id, users.user_id, users.first_name, users.last_name, users.screen_name FROM tweets INNER JOIN users ON tweets.user_id = users.user_id WHERE users.user_id = " . $user->userId . " ORDER BY tweets.date_created DESC LIMIT 10";
        $rsTweets = mysqli_query($connection, $strSQL) or die('Could not connect: ' . mysql_error());
        $html_result = "";
        while ($rowUsers = mysqli_fetch_array($rsTweets)) {
            if (!$rowUsers["original_tweet_id"] == 0) {
                $strSQL2 = "SELECT tweets.user_id, users.user_id, users.first_name, users.last_name FROM tweets INNER JOIN users ON tweets.user_id = users.user_id WHERE tweets.tweet_id = " . $rowUsers["original_tweet_id"];
                $rsRetweets = mysqli_query($connection, $strSQL2) or die('Could not connect: ' . mysql_error());

                while ($rowRetUser = mysqli_fetch_array($rsRetweets)) {
                    $html_result = '<div class="t-header">'
                            . '<a href="userpage.php?user_id=' . $rowUsers["user_id"] . '">'
                            . $rowUsers["first_name"] . ' ' . $rowUsers["last_name"] . ' @' . $rowUsers["screen_name"]
                            . '</a>' . ' ' . getTweetTime($rowUsers["date_created"]) . ' <b> retweeted from ' . $rowRetUser["first_name"] . ' ' . $rowRetUser["last_name"] . '</b></div>' . '<BR>';
                }
            } else {
                $html_result = '<div class="t-header">'
                        . '<a href="userpage.php?user_id=' . $rowUsers["user_id"] . '">'
                        . $rowUsers["first_name"] . ' ' . $rowUsers["last_name"] . ' @' . $rowUsers["screen_name"]
                        . '</a>' . ' ' . getTweetTime($rowUsers["date_created"]) . '</div>' . '<BR>';
            }

            $html_result .= '<div class="t-text">'
                    . $rowUsers["tweet_text"] . '<BR><BR></div>'
                    . '<div class="t-icons">'
                    . '<form method="post" action="likeTweet.php">'
                    . '<input name="origTweetId" type="hidden" value="' . $rowUsers["tweet_id"] . '"/>'
                    . '<input name="origUserId" type="hidden" value="' . $rowUsers["user_id"] . '"/>'
                    . '<input class="input_image_like" type="submit" name="likeClick" value="like" />'
                    . '</form>'
                    . '<form method="post" action="retweet.php">'
                    . '<input name="origTweetText" type="hidden" value="' . $rowUsers["tweet_text"] . '"/>'
                    . '<input name="origTweetId" type="hidden" value="' . $rowUsers["tweet_id"] . '"/>'
                    . '<input class="input_image_ret" type="submit" name="retweetClick" value="Retweet" />'
                    . '</form>'
                    . '<form method="post" action="reply.php">'
                    . '<input name="origTweetText" type="hidden" value="' . $rowUsers["tweet_text"] . '"/>'
                    . '<input name="origTweetId" type="hidden" value="' . $rowUsers["tweet_id"] . '"/>'
                    . '<input class="input_image_rep" type="submit" name="replyClick" value="Reply" />'
                    . '</form>'
                    . '</div>'
                    . '<hr>';

            /*$strSQL3 = "SELECT tweets.tweet_id, tweets.tweet_text, tweets.date_created, users.user_id, users.first_name, users.last_name, users.screen_name FROM tweets INNER JOIN users ON tweets.user_id = users.user_id WHERE tweets.reply_to_tweet_id = " . $rowUsers["tweet_id"];
            $rsReplies = mysqli_query($connection, $strSQL3) or die('Could not connect: ' . mysql_error());

            while ($rowRepUser = mysqli_fetch_array($rsReplies)) {
                $html_result .= '<div class="r-block"><div class="r-header">'
                        . '<b> replied from </b><a href="userpage.php?user_id=' . $rowRepUser["user_id"] . '">'
                        . $rowRepUser["first_name"] . ' ' . $rowRepUser["last_name"] . ' @' . $rowRepUser["screen_name"]
                        . '</a></b>' . ' ' . getTweetTime($rowRepUser["date_created"]) . '</div>' . '<BR>'
                        . '<div class="r-text">'
                        . $rowRepUser["tweet_text"] . '<BR><BR></div>'
                        . '<div class="t-icons">'
                        . '<form method="post" action="like.php">'
                        . '<input type="image" src="images/like.ico" alt="Submit" width="40" height="40">'
                        . '</form>'
                        . '<form method="post" action="retweet.php">'
                        . '<input name="origTweetText" type="hidden" value="' . $rowRepUser["tweet_text"] . '"/>'
                        . '<input name="origTweetId" type="hidden" value="' . $rowRepUser["tweet_id"] . '"/>'
                        . '<input class="input_image_ret" type="submit" name="retweetClick" value="Retweet" />'
                        . '</form>'
                        . '<form method="post" action="reply.php">'
                        . '<input name="origTweetText" type="hidden" value="' . $rowRepUser["tweet_text"] . '"/>'
                        . '<input name="origTweetId" type="hidden" value="' . $rowRepUser["tweet_id"] . '"/>'
                        . '<input class="input_image_rep" type="submit" name="replyClick" value="Reply" />'
                        . '</form>'
                        . '</div></div>'
                        . '<hr>';
            }*/

            echo $html_result;
        }
    }

    public static function TotalTweets($user, $connection){
        $strSQL = "SELECT COUNT(tweet_id) as total FROM tweets WHERE user_id = '$user->userId'";
        $rsResults = mysqli_query($connection, $strSQL) or die('Could not connect: ' . mysql_error());
        $data = mysqli_fetch_array($rsResults);
        echo $data['total'];
    }
    
    public static function TotalFollowing($user, $connection){
        $strSQL = "SELECT COUNT(follow_id) as total FROM follows WHERE from_id = '$user->userId'";
        $rsResults = mysqli_query($connection, $strSQL) or die('Could not connect: ' . mysql_error());
        $data = mysqli_fetch_array($rsResults);
        echo $data['total'];
    }
    
    public static function TotalFollowers($user, $connection){
        $strSQL = "SELECT COUNT(follow_id) as total FROM follows WHERE to_id = '$user->userId'";
        $rsResults = mysqli_query($connection, $strSQL) or die('Could not connect: ' . mysql_error());
        $data = mysqli_fetch_array($rsResults);
        echo $data['total'];
    }
    
    public static function ChangeProfilePic($destination, $user, $connection){
        $insert = "UPDATE users SET profile_pic='$destination' WHERE user_id='$user->userId'";
        mysqli_query($connection, $insert);
        if (mysqli_affected_rows($connection) == 1) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function GetAllMessages($user, $connection){
        $strSQL = "SELECT * FROM messages WHERE from_id = '$user->userId' OR to_id = '$user->userId' ORDER BY date_sent DESC";
        $rsMessages = mysqli_query($connection, $strSQL) or die('Could not connect: ' . mysql_error());
        while ($rowMessages = mysqli_fetch_array($rsMessages)) {
            $db_userinfo = array();
            $strSQL2 = "SELECT * FROM users WHERE user_id = " . $rowMessages["from_id"];
            $rsUsers = mysqli_query($connection, $strSQL2) or die('Could not connect: ' . mysql_error());
            while ($row = mysqli_fetch_array($rsUsers)) {
                //Associative Array: Array that indexes with a string instead of a number.
                $db_userinfo["full_name"] = $row["first_name"] . ' ' . $row["last_name"];
                $db_userinfo["screen_name"] = $row["screen_name"];
                $db_userinfo["user_id"] = $row["user_id"];

                echo '<div class="t-header">'
                . '<a href="userpage.php?user_id=' . $db_userinfo["user_id"] . '">'
                . $db_userinfo["full_name"] . ' @' . $db_userinfo["screen_name"]
                . '</a>' . ' ' . getTweetTime($rowMessages["date_sent"]) . '</div>' . '<BR>'
                . '<div class="t-text">'
                . $rowMessages["message_text"] . '<BR><BR></div>'
                . '<hr>';
            }
        }
    }

    public static function AddMessage($user, $toUser, $text, $connection) {
        $sql = "INSERT INTO messages(from_id, to_id, message_text) VALUES('$user->userId','$toUser', '$text')";
        mysqli_query($connection, $sql);
        if (!mysqli_affected_rows($connection) == 1) {
            $msg = "Error to send a message. What a shame!";
            header("location:DirectMessage.php?Error=$msg");
        }
        header("location:DirectMessage.php");
    }

    public static function SearchUsers($text, $user, $connection){
        $html_result = "";
        $sql = "SELECT user_id, first_name, last_name, screen_name, profile_pic FROM users WHERE first_name LIKE '%".$text."%' OR last_name LIKE '%".$text."%' OR screen_name LIKE '%".$text."%' AND user_id <> '$user->userId' ORDER BY first_name";
        $rsUsers = mysqli_query($connection, $sql) or die('Could not connect: ' . mysql_error());
        if ($rsUsers->num_rows != 0){
            while ($rowUsers = mysqli_fetch_array($rsUsers)) {
                $member_id = $rowUsers["user_id"];
                if ($rowUsers["profile_pic"] == "") {
                    $img = "images/profilepics/default.jfif";
                } else {
                    $img = $rowUsers["profile_pic"];
                }
                $html_result .= '<div class="search-row-user">'
                        . '<div class="row-user-img"><div class="bold"><img class="bannericons" src="' . $img . '"></div></div>'
                        . '<div class="row-user-link"><a href="userpage.php?user_id=' . $rowUsers["user_id"] . '">'
                        . $rowUsers["first_name"] . ' ' . $rowUsers["last_name"] . ' @' . $rowUsers["screen_name"]
                        . '</a></div>';

                //checking following and followers users
                $sql2 = "SELECT follow_id FROM follows WHERE from_id = '$user->userId' AND to_id = '$member_id'";
                $sql3 = "SELECT follow_id FROM follows WHERE to_id = '$user->userId' AND from_id = '$member_id'";
                $sql4 = "SELECT user_id FROM users WHERE user_id = '$user->userId'";
                $rowsFollowing = mysqli_query($connection, $sql2) or die('Could not connect: ' . mysql_error());
                $rowsFollowers = mysqli_query($connection, $sql3) or die('Could not connect: ' . mysql_error());
                $rowsIsItYou = mysqli_query($connection, $sql4) or die('Could not connect: ' . mysql_error());

                if ($user->userId == $rowUsers["user_id"]) {
                    $html_result .= "<p>This user is you!</p></div>";
                } else {
                    if ($rowsFollowing->num_rows != 0) {
                        $html_result .= "<p>Following</p>";
                    } else {
                        $html_result .= '<div class="row-user-form"><form method="get" id="follow_form" action="follow_proc.php"><div class="form-group">'
                                . '<input name="user" type="hidden" value="' . $member_id . '"/>'
                                . '<input type="submit" name="follow" value="Follow" class="btn btn-dark"/></div></form></div>';
                    }

                    if ($rowsFollowers->num_rows != 0) {
                        $html_result .= "<p>&nbsp|&nbspFollows you</p></div>";
                    } else {
                        $html_result .= "</div>";
                    }
                }
            }
            echo $html_result;
        } else {
            $html_result = "<p>Not Found!</p>"
                    . "<p>No users found with the words: <i>" . $text . "</i></p>";
            echo $html_result;
        }
    }
}