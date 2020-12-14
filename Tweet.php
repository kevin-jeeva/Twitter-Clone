<?php
include_once("User.php");
class Tweet {
 
    private $tweetId;
    private $tweetText;
    private $userId;
    private $orginalTweetId;
    private $replyToTweetId;
    private $dateAdded;
    
    public function __construct($tweetId, $tweetText, $userId, $orginalTweetId, $replyToTweetId, $dateAdded) {
        $this->tweetId = $tweetId;
        $this->tweetText = $tweetText;
        $this->userId = $userId;
        $this->orginalTweetId = $orginalTweetId;
        $this->replyToTweetId = $replyToTweetId;
        $this->dateAdded = $dateAdded;
    }
    public function __destruct()
    {
        echo "OBJECT DESTROYED";
    }
    
    public function __get($name) {
        return $this->$name;
    }
    public function __set($name, $value) {
        $this->$name = $value;
    }
    public static function InsertTweet($tweet)
    {
        $con = $GLOBALS["con"];
        $sql = "Insert into tweets(tweet_text,user_id, reply_to_tweet_id)values('$tweet->tweetText',$tweet->userId,$tweet->replyToTweetId)";
        mysqli_query($con, $sql);
            if(mysqli_affected_rows($con) == 1)
            {
                $_SESSION['alert'] = "Your tweet have posted";
                header("location:index.php"); 
            }
            else 
            {
                  $_SESSION['alert'] = "Your tweet have not posted";
                 header("location:index.php"); 
            }
    }
    public static function GetTweetById($tweetId)
    {
        $con = $GLOBALS["con"];
        $sql = "Select tweet_id,tweet_text,user_id,date_created,reply_to_tweet_id,original_tweet_id from tweets where tweet_id = $tweetId";
       // echo $sql;
        $result = mysqli_query($con, $sql);
        return $result;
    }
    public static function ReTweet($tweet)
    {
        $result = Tweet::GetTweetById($tweet->orginalTweetId);
            if($val = mysqli_fetch_array($result))
            {   
                $user = new User($_SESSION["user_Id"],0,$_SESSION["Last_name"],$_SESSION["first_name"],$_SESSION["user"],0,0,0,0,0,0,0,0,0,0);
                $tweet->tweetText = $val["tweet_text"];
                $tweet->userId = $user->userId;

                Tweet::InsertreTweet($tweet);

            }
            else
            {
                echo "error";
            }
            
    }
    public static function InsertreTweet($tweet)
    {
        $con = $GLOBALS["con"];
        $sql = "Insert into tweets(tweet_text,user_id,original_tweet_id,reply_to_tweet_id)values(\"$tweet->tweetText\",$tweet->userId,$tweet->orginalTweetId,$tweet->replyToTweetId)";
        echo $sql;
        mysqli_query($con, $sql);
            if(mysqli_affected_rows($con) == 1)
            {
                echo "success";
                   $_SESSION["alert"] = "You have sucessfully retweeted";
                   header("location:index.php"); 
            }
            else 
            {
                echo "failure";
                  $_SESSION["alert"] = "Some problems in retweeting retweeted";
                  header("location:index.php");
            }
    }
    public static function InsertReply($tweet)
    {
        $con = $GLOBALS["con"];
        $sql = "Insert into tweets (tweet_text,user_id,reply_to_tweet_id) values(\"$tweet->tweetText\",$tweet->userId,$tweet->replyToTweetId)";
       
        mysqli_query($con, $sql);
        //echo $sql;
        if(mysqli_affected_rows($con) == 1)
        {
           return true;
        }
         else 
        {
             
            return false;
        }
    }
    public static function GetTweetIdByFollows($user)
    {
        $con = $GLOBALS["con"];
        $sql = "Select tweet_id,tweet_text,user_id,original_tweet_id,reply_to_tweet_id,date_created from tweets where user_id = $user->userId OR user_id IN (select to_id from follows where from_id = $user->userId) ORDER BY date_created DESC";
        $result = mysqli_query($con, $sql);
        return $result;
    }
    public static function GetTweets($result)
    {
       // $con = $GLOBALS["con"];
        if($result != null)
        {
            while($val = mysqli_fetch_array($result))//select all the tweets
            {

                if($val["original_tweet_id"] == 0)
                { //echo "here";
                   //Display the original tweet
                   $main = Tweet::GetOriginalUser($val["user_id"]);//get the user and their tweet
                   Tweet::DisplayOriginalTweet($main,$val);

                }
                elseif (($val["original_tweet_id"] != 0) && ($val["reply_to_tweet_id"] != 0) )
                {
                    // this is an reply to reply
                }
                else
                {
                    //Display the retweets
                    Tweet::DisplayReTweet($val);
                }
            }
        }
    }
    public static function GetOriginalUser($userId)
    {
       // $con = $GLOBALS["con"];
        $singleUser = new User($userId,0,0,0,0,0,0,0,0,0,0,0,0,0,0); 
        $result = User::GetUserById($singleUser->userId);
        return $result;
    }
    public static function DisplayOriginalTweet($main,$val)
    {
        while($mainVal = mysqli_fetch_array($main))
        {   
            if($val["reply_to_tweet_id"] == 0)
            {
                $singleUser = new User($mainVal["user_id"],0,0,0,0,0,0,0,0,0,0,0,0,0,0); 
                $singleUser->firstName = $mainVal["first_name"];
                $singleUser->lastName = $mainVal["last_name"];
                $singleUser->userName = $mainVal["screen_name"];

                $reply = $val["tweet_id"]."|".$val["tweet_text"]."|".$singleUser->firstName." ".$singleUser->lastName." @".$singleUser->userName."|";                                        
                $time = Tweet::Interval($val["date_created"]);   
                $likeResult = self::Like($val["tweet_id"]);
                $likeImage;
                $likeCount = "";
                if($likeResult == true)
                {
                    $likeImage = "Images/after_like.jpg";
                    $likeCt = self::likeCount($val["tweet_id"]);
                    if($likeCt != 0) { $likeCount = $likeCt; } else {$likeCount = "";}
                }
                else
                {
                     $likeImage = "Images/before_like.png";
                     $likeCt = self::likeCount($val["tweet_id"]);
                     if($likeCt != 0) { $likeCount = $likeCt; } else {$likeCount = "";}
                }

                //main owner for the tweet
                 echo '<div><a href ="userpage.php?userId='.$singleUser->userId.'">'.$singleUser->firstName." ".$singleUser->lastName." @".$singleUser->userName. '</a>'."  ".$time.'<BR>'
                    . $val["tweet_text"].'<BR>'
                    . '<a href="like.php?tweetId='.$val["tweet_id"].'"><img class = "img-rounded" width="35" height="35" src='.$likeImage.'></a>'.$likeCount.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                    . '<a href="retweet.php?value='.$val["tweet_id"].'"><img src = "Images/retweet.png"class = "img-rounded" width="35" height="35" ></a>'
                    . '&nbsp;&nbsp;<a href="#myModal" data-toggle="modal" data-tweetid ="'.$val["tweet_id"].'"><img src ="Images/reply.png" class = "img-rounded" widht="35" height="35"></a>'
                    . '<br></div>';
                 Tweet::DisplayReplies($val,$singleUser->userName,$singleUser->userId);
             }
             //echo "<hr/>";
        }
    }
    
    public static function Like($tweetId)
    {
        $userId = $_SESSION["user_Id"];
        $con = $GLOBALS["con"];
        $sql = "Select like_id from likes where tweet_id = $tweetId And user_id = $userId";
        $result = mysqli_query($con, $sql);
        if(mysqli_num_rows($result) > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public static function likeCount($tweetId)
    {
        $con = $GLOBALS["con"];
        $sql = "Select Count(like_id) as LikeCount from likes where tweet_id = $tweetId";
        $result = mysqli_query($con, $sql);
        if(mysqli_num_rows($result) > 0)
        {
            if($val = mysqli_fetch_array($result))
            {
                return $val["LikeCount"];
            }
        }
        else
        {
            return "";
        }
    }
    public static function DisplayReplies($val,$userName,$userID)
    {
        $con = $GLOBALS["con"];
        $repTweetId = $val["tweet_id"];
        $sqlresultReplies = "Select tweet_text,user_id,tweet_id,date_created from tweets where reply_to_tweet_id = $repTweetId";
        $resultReplies =  mysqli_query($con,$sqlresultReplies);
        if(mysqli_num_rows($resultReplies) > 0)
        {
            echo'<p class="text-danger"><mark>Replies</mark></p>';
            while($valReplies = mysqli_fetch_array($resultReplies))
            {
                $repliedUserId = $valReplies["user_id"];
                $repliedUserTweet = $valReplies["tweet_text"];
                $repliedTime = $valReplies["date_created"];
                
                $resultRepliedUser = User::GetUserById($repliedUserId);
                
                while($valRepliedUser = mysqli_fetch_array($resultRepliedUser))
                {
                    $repliedFirst = $valRepliedUser["first_name"];
                    $repliedLast = $valRepliedUser["last_name"];
                    $repliedScreen = $valRepliedUser["screen_name"];
                    $t = $valReplies["tweet_id"]."|".$valReplies["tweet_id"];
                    $repTime = Tweet::Interval($valReplies["date_created"]);
                    
                    $likeResult = self::Like($valReplies["tweet_id"]);
                    $likeImage;
                    $likeCount = "";
                    if($likeResult == true)
                    {
                        $likeImage = "Images/after_like.jpg";
                        $likeCt = self::likeCount($valReplies["tweet_id"]);
                        if($likeCt != 0) { $likeCount = $likeCt; } else {$likeCount = "";}
                    }
                    else
                    {
                         $likeImage = "Images/before_like.png";
                         $likeCt = self::likeCount($valReplies["tweet_id"]);
                         if($likeCt != 0) { $likeCount = $likeCt; } else {$likeCount = "";}
                    }
                    
                    
                    
                    echo '<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href ="userpage.php?userId='.$valRepliedUser["user_id"].'">'.$repliedFirst." ".$repliedLast." @".$repliedScreen. '</a>'."  ".$repTime.' Replied to <a href="userpage.php?userId='.$userID.'">@'.$userName.'</a><BR>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                  . $repliedUserTweet.'<BR>'
                  . '<form>'
                  . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="like.php?tweetId='.$valReplies["tweet_id"].'"><img class = "img-rounded" width="35" height="35" src='.$likeImage.'></a>'.$likeCount.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                  . '<a href="retweet.php?value='.$valReplies["tweet_id"].'"><img src = "Images/retweet.png"class = "img-rounded" width="35" height="35" ></a>'
                  . '&nbsp;&nbsp;<a href="#myModal" data-toggle="modal" data-tweetid ="'.$valReplies["tweet_id"].'"><img src ="Images/reply.png" class = "img-rounded" widht="35" height="35"></a>'
                  . '</form><br></div>';

                    //More Replies
                    $getMoreReplies = Tweet::GetMoreReplies($repliedUserId,$valReplies["tweet_id"]);    


                }
            }
           
        }
        echo"<hr/>";
    }
    public static function DisplayReTweet($val)
    {
        $con = $GLOBALS["con"];
        $singleUser = new User($val["user_id"],0,0,0,0,0,0,0,0,0,0,0,0,0,0);        
        $main = User::GetUserById($singleUser->userId);

        while($mainVal= mysqli_fetch_array($main))
        {                                                   
            $singleUser->firstName = $mainVal["first_name"];
            $singleUser->lastName = $mainVal["last_name"];
            $singleUser->userName = $mainVal["screen_name"];                                        
            $time = Tweet::Interval($val["date_created"]);

             //ORGINAL TWEET USER
            $userTweetId = $val["original_tweet_id"];     
            $selectUserTweetResult = Tweet::GetTweetById($userTweetId);
            while($valselectUserTweetResult = mysqli_fetch_array($selectUserTweetResult))
            {
               $selectUserResult = User::GetUserById($valselectUserTweetResult["user_id"]);
          
                while($mainUser = mysqli_fetch_array($selectUserResult))
                {
                    $originalTweetUser = new User(0,0,$mainUser["last_name"],$mainUser["first_name"],$mainUser["screen_name"],0,0,0,0,0,0,0,0,$mainUser["profile_pic"],0);

                    $singleUser->firstName = $mainVal["first_name"];
                    $singleUser->lastName = $mainVal["last_name"];
                    $singleUser->userName = $mainVal["screen_name"];

                    $time = Tweet::Interval($val["date_created"]);

                    $likeResult = self::Like($val["tweet_id"]);
                    $likeImage;
                    $likeCount = "";
                    if($likeResult == true)
                    {
                        $likeImage = "Images/after_like.jpg";
                        $likeCt = self::likeCount($val["tweet_id"]);
                        if($likeCt != 0) { $likeCount = $likeCt; } else {$likeCount = "";}
                    }
                    else
                    {
                         $likeImage = "Images/before_like.png";
                         $likeCt = self::likeCount($val["tweet_id"]);
                         if($likeCt != 0) { $likeCount = $likeCt; } else {$likeCount = "";}
                    }
                    
                    
                    echo '<div><a href ="userpage.php?userId='.$singleUser->userId.'">'.$singleUser->firstName." ".$singleUser->lastName." @".$singleUser->userName. '</a>'."  ".$time.' <a class ="font-weight-bold">retweeted from '.$originalTweetUser->firstName.'&nbsp;'.$originalTweetUser->lastName.'</a><BR>'
                            . $val["tweet_text"].'<BR>'
                            . '<form>'
                            . '<a href="like.php?tweetId='.$val["tweet_id"].'"><img class = "img-rounded" width="35" height="35" src='.$likeImage.'></a>'.$likeCount.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                            . '<a href="retweet.php?value='.$val["tweet_id"].'"><img src = "Images/retweet.png"class = "img-rounded" width="35" height="35" ></a>'
                            . '&nbsp;&nbsp;<a href="#myModal" data-toggle="modal" data-tweetid ="'.$val["tweet_id"].'"><img src ="Images/reply.png" class = "img-rounded" widht="35" height="35"></a>'
                            . '</form><br></div>';  
                     $getMoreReplies = Tweet::DisplayReplies($val,$singleUser->userName,$singleUser->userId);  
                }
            }
        }
        
    }
    public static function Interval($tweetTime)
    {
        date_default_timezone_set("America/Halifax");
        $now = new DateTime();//current datetime stamp
        $tweetime = new DateTime($tweetTime);
        $interval = $now->diff($tweetime);


        if($interval->y > 1) return $interval->format("%y years ago");
        elseif($interval->y > 0) return $interval->format("%y year ago");
        elseif($interval->m > 1) return $interval->format("%m months ago");
        elseif($interval->m > 0) return $interval->format("%m month ago");
        elseif($interval->d > 1) return $interval->format("%d days ago");
        elseif($interval->d > 0) return $interval->format("%d day ago");
        elseif($interval->h > 1) return $interval->format("%h hours ago");
        elseif($interval->h > 0) return $interval->format("%h hour ago");
        elseif($interval->i > 1) return $interval->format("%i minutes ago");
        elseif($interval->i > 0) return $interval->format("%i minute ago");
        elseif($interval->s > 1) return $interval->format("%s seconds ago");
        elseif($interval->s > 0) return $interval->format("%s second ago");
    }
    public static function GetMoreReplies($repliedTo,$tweetid,$space="&nbsp;&nbsp;&nbsp;")
    {

            $con = $GLOBALS["con"];
            $moreTweetId = 0;
           //ORIGINAL USER
            
         // $repliedToUser = "select screen_name from users where user_id = $repliedTo";
          $resultRepliedToUser = User::GetUserById($repliedTo);//mysqli_query($con, $repliedToUser);
           if($valResultRepliedToUser = mysqli_fetch_array($resultRepliedToUser)){
              $repliedToUserName = $valResultRepliedToUser["screen_name"];

               $repTweetCheck = "select user_id,tweet_text,tweet_id,date_created from tweets where reply_to_tweet_id = $tweetid";    
               $resultrepTweetCheck = mysqli_query($con, $repTweetCheck);
               if(mysqli_num_rows($resultrepTweetCheck) > 0)
               {

                   while($valresultrepTweetCheck = mysqli_fetch_array($resultrepTweetCheck))
                   {
                       $moreTweetId = $valresultrepTweetCheck["tweet_id"];
                       $spaces = "&nbsp;&nbsp;&nbsp;&nbsp;".$space ;

                       $u = $valresultrepTweetCheck["user_id"];
                      // $repUsers = "select first_name,last_name,screen_name from users where user_id = $u";
                       $resultRepUsers= User::GetUserById($u);//mysqli_query($db,$repUsers);
                       while($valRepUsers = mysqli_fetch_array($resultRepUsers)){


                           $repUserDetails = new User($valRepUsers["user_id"],0,$valRepUsers["last_name"],$valRepUsers["first_name"],$valRepUsers["screen_name"],0,0,$valresultrepTweetCheck["date_created"],0,0,0,0,0,0,0);
                            $repliedTime = Tweet::Interval($repUserDetails->dateAdded); 
                            
                            $likeResult = self::Like($valresultrepTweetCheck["tweet_id"]);
                            $likeImage;
                            $likeCount = "";
                            if($likeResult == true)
                            {
                                $likeImage = "Images/after_like.jpg";
                                $likeCt = self::likeCount($valresultrepTweetCheck["tweet_id"]);
                                if($likeCt != 0) { $likeCount = $likeCt; } else {$likeCount = "";}
                            }
                            else
                            {
                                 $likeImage = "Images/before_like.png";
                                 $likeCt = self::likeCount($valresultrepTweetCheck["tweet_id"]);
                                 if($likeCt != 0) { $likeCount = $likeCt; } else {$likeCount = "";}
                            }
                            
                            
                            
                       echo '<div>'.$spaces.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href ="userpage?userId='.$repUserDetails->userId.'">'.$repUserDetails->firstName." ".$repUserDetails->lastName." @".$repUserDetails->userName. '</a>'."  ".$repliedTime.' Replied To <a href="userpage.php?userId='.$valResultRepliedToUser["user_id"].'">@'. $repliedToUserName.'</a><BR>'.$space.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                           . $valresultrepTweetCheck["tweet_text"].'<BR>'
                           . '<form>'
                           . ''.$spaces.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="like.php?tweetId='.$valresultrepTweetCheck["tweet_id"].'"><img class = "img-rounded" width="35" height="35" src='.$likeImage.'></a>'.$likeCount.''
                           . '&nbsp;&nbsp;&nbsp;<a href="retweet.php?value='.$valresultrepTweetCheck["tweet_id"].'"><img src = "Images/retweet.png"class = "img-rounded" width="35" height="35" ></a>'
                           . '&nbsp;&nbsp;<a href="#myModal" data-toggle="modal" data-tweetid ="'.$valresultrepTweetCheck["tweet_id"].'"><img src ="Images/reply.png" class = "img-rounded" widht="35" height="35"></a>'
                           . '</form><br></div>';
                       $spaces = "&nbsp;&nbsp;&nbsp;".$spaces;
                       Tweet::GetMoreReplies($u,$moreTweetId,$spaces);
                       }

                   }
                   //replies($u,$moreTweetId,$spaces);
               }
               else
               {

               }

           } 

       }
       
       //userpage
       public static function DisplayUserInfo($user)
       {
           $userId = $user->userId;
           $resultUserId = User::GetUserById($userId);           
           $resultTweets = self::GetTweetByUserId($userId);
           self::DisplayTweetAndRetweet($resultUserId,$resultTweets);
       }
       public static function GetTweetByUserId($userId)
       {
           $con = $GLOBALS["con"];
           $sql = "select tweet_id,tweet_text,original_tweet_id,date_created,reply_to_tweet_id from tweets where user_id = $userId order by date_created DESC";
           $result = mysqli_query($con, $sql);
           return $result;
       }
       public static function DisplayTweetAndRetweet($userResult, $tweetResult)
       {
           while($valUser = mysqli_fetch_array($userResult))
           {
               while($valTweet = mysqli_fetch_array($tweetResult))
               {
                   if($valTweet["original_tweet_id"] == 0)
                   {
                       if($valTweet["reply_to_tweet_id"] == 0)
                       {
                       //Original tweet without reply
                        $singleUser = new User($valUser["user_id"],0,0,0,0,0,0,0,0,0,0,0,0,0,0); 
                        $singleUser->firstName = $valUser["first_name"];
                        $singleUser->lastName = $valUser["last_name"];
                        $singleUser->userName = $valUser["screen_name"];

                                                               
                        $time = self::Interval($valTweet["date_created"]);   
                            $likeResult = self::Like($valTweet["tweet_id"]);
                            $likeImage;
                            $likeCount = "";
                            if($likeResult == true)
                            {
                                $likeImage = "Images/after_like.jpg";
                                $likeCt = self::likeCount($valTweet["tweet_id"]);
                                if($likeCt != 0) { $likeCount = $likeCt; } else {$likeCount = "";}
                            }
                            else
                            {
                                 $likeImage = "Images/before_like.png";
                                 $likeCt = self::likeCount($valTweet["tweet_id"]);
                                 if($likeCt != 0) { $likeCount = $likeCt; } else {$likeCount = "";}
                            }
                        
                        

                        //main owner for the tweet
                         echo '<div><a href ="userpage.php?userId='.$singleUser->userId.'">'.$singleUser->firstName." ".$singleUser->lastName." @".$singleUser->userName. '</a>'."  ".$time.'<BR>'
                            . $valTweet["tweet_text"].'<BR>'
                            . '<a href="like.php?tweetId='.$valTweet["tweet_id"].'"><img class = "img-rounded" width="35" height="35" src='.$likeImage.'></a>'.$likeCount.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                            . '<a href="retweet.php?value='.$valTweet["tweet_id"].'"><img src = "Images/retweet.png"class = "img-rounded" width="35" height="35" ></a>'
                            . '&nbsp;&nbsp;<a href="#myModal" data-toggle="modal" data-tweetid ="'.$valTweet["tweet_id"].'"><img src ="Images/reply.png" class = "img-rounded" widht="35" height="35"></a>'
                            . '<br></div>';
                          Tweet::DisplayReplies($valTweet,$singleUser->userName,$singleUser->userId);
                       }
                   }
                   else if($valTweet["original_tweet_id"] != 0) 
                   {
                       if($valTweet["reply_to_tweet_id"] == 0)
                       {
                       $mainTweetUserResult = self::GetUserInfoByTweetId($valTweet["original_tweet_id"]);
                       while($valMainUserResult = mysqli_fetch_array($mainTweetUserResult))
                       {
                           //main user 
                            $mainUser = new User(0,0,$valMainUserResult["last_name"],$valMainUserResult["first_name"],$valMainUserResult["screen_name"],0,0,0,0,0,0,0,0,0,0);
                            //retweet
                            $singleUser = new User($valUser["user_id"],0,0,0,0,0,0,0,0,0,0,0,0,0,0); 
                             $singleUser->firstName = $valUser["first_name"];
                             $singleUser->lastName = $valUser["last_name"];
                             $singleUser->userName = $valUser["screen_name"];


                             $time = self::Interval($valTweet["date_created"]);   
                             $likeResult = self::Like($valTweet["tweet_id"]);
                            $likeImage;
                            $likeCount = "";
                            if($likeResult == true)
                            {
                                $likeImage = "Images/after_like.jpg";
                                $likeCt = self::likeCount($valTweet["tweet_id"]);
                                if($likeCt != 0) { $likeCount = $likeCt; } else {$likeCount = "";}
                            }
                            else
                            {
                                 $likeImage = "Images/before_like.png";
                                 $likeCt = self::likeCount($valTweet["tweet_id"]);
                                 if($likeCt != 0) { $likeCount = $likeCt; } else {$likeCount = "";}
                            }
                             
                             
                             

                             //retweet
                              echo '<div><a href ="userpage.php?userId='.$singleUser->userId.'">'.$singleUser->firstName." ".$singleUser->lastName." @".$singleUser->userName. '</a>'."  ".$time.'<a class ="font-weight-bold">retweeted from '.$mainUser->firstName.'&nbsp;'.$mainUser->lastName.'</a><BR>'
                                 . $valTweet["tweet_text"].'<BR>'
                                 . '<a href="like.php?tweetId='.$valTweet["tweet_id"].'"><img class = "img-rounded" width="35" height="35" src='.$likeImage.'></a>'.$likeCount.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
                                 . '<a href="retweet.php?value='.$valTweet["tweet_id"].'"><img src = "Images/retweet.png"class = "img-rounded" width="35" height="35" ></a>'
                                 . '&nbsp;&nbsp;<a href="#myModal" data-toggle="modal" data-tweetid ="'.$valTweet["tweet_id"].'"><img src ="Images/reply.png" class = "img-rounded" widht="35" height="35"></a>'
                                 . '<br></div>';
                                 Tweet::DisplayReplies($valTweet,$singleUser->userName,$singleUser->userId);
                       }
                       }
                   }
                   else
                   {
                       //no replies to show
                   }
               }
           }
       }
       public static function GetUserInfoByTweetId($tweetId)
       {
           $con = $GLOBALS["con"];
         $sql= "Select tweet_text,user_id,tweet_id,date_created from tweets where tweet_id = $tweetId";
         $result =  mysqli_query($con,$sql);
          while($val = mysqli_fetch_array($result))
          {
              //echo $val["user_id"];
              $userResult = User::GetUserById($val["user_id"]);
              return $userResult;
          }
           
       }
       public static function DisplayNumTweets($userId)
       {
           $con = $GLOBALS["con"];
           $sql = "select count(tweet_id) as numTweet from tweets where user_id = $userId AND reply_to_tweet_id = 0";
           $result = mysqli_query($con,$sql);
           if(mysqli_num_rows($result) != null)
           {
                while(($val = mysqli_fetch_array($result)))
                {
                    echo $val["numTweet"];
                }
           }
           else
           {
               echo "0";
           }
       }
       public static function DisplayNumFollowers($userId)
       {
           $con = $GLOBALS["con"];
           $sql = "Select count(follow_id) as followers from follows where to_id = $userId";
           $result = mysqli_query($con,$sql);
           if(mysqli_num_rows($result) != null)
           {
                while(($val = mysqli_fetch_array($result)))
                {
                    echo $val["followers"];
                }
           }
           else
           {
               echo "0";
           }
       }
       public static function DisplayNumFollowing($userId)
       {
           $con = $GLOBALS["con"];
           $sql = "Select count(follow_id) as followers from follows where from_id = $userId";
           $result = mysqli_query($con,$sql);
           if(mysqli_num_rows($result) != null)
           {
                while(($val = mysqli_fetch_array($result)))
                {
                    echo $val["followers"];
                }
           }
           else
           {
               echo "0";
           }
       }
       public static function DisplayFollowersKnow($userId)
       {
            $con = $GLOBALS["con"];
            $user = $_SESSION["user_Id"];
            $sql = "Select distinct(to_id) from follows where to_id in (Select to_id from follows where from_id = $user ) AND to_id in (Select to_id from follows where from_id = $userId )  order by rand() LIMIT 3";
            
            $result = mysqli_query($con,$sql);
           if(mysqli_num_rows($result) > 0)
           {
            while($val = mysqli_fetch_array($result))
            {     
                self::DisplayPicAndUser($val["to_id"]);
            }
           }
               
                
       }
       public static function DisplayNumFollowersKnow($userId)
       {
            $con = $GLOBALS["con"];
            $user = $_SESSION["user_Id"];
            $sql = "Select count(distinct(to_id)) as Count from follows where to_id in (Select to_id from follows where from_id = $user ) AND to_id in (Select to_id from follows where from_id = $userId )  order by rand() LIMIT 3";
            
            $result = mysqli_query($con,$sql);
            if(mysqli_num_rows($result) > 0)
           {
            while($val = mysqli_fetch_array($result))
            {     
                echo $val["Count"];
            }
           }    
                
       }
       
       public static function DisplayPicAndUser($userId)
       {
        $result = User::GetUserById($userId);
        $first = "";
        $last = "";
        while($val = mysqli_fetch_array($result))
        {
            if($val["profile_pic"] == null)
            {       
                $id = $val["user_id"];
                    $UserDetails = User::myTruncate($val["first_name"], $val["last_name"], $val["screen_name"]);
                    echo '<img class="bannericons" src="images/profilepics/default.jfif">&nbsp;<a href ="userpage.php?userId='.$id.'">'.$UserDetails."</a><BR><BR>";
                    echo $first." ".$last;
                 
            }
            else
            {
                     $id = $val["user_id"];
                    $UserDetails = User::myTruncate($val["first_name"], $val["last_name"], $val["screen_name"]);
                    $profile = $val["profile_pic"];
                    echo '<img class="bannericons" src="images/profilepics/'.$profile.'"><a href="userpage.php?userId='.$id.'">'.$UserDetails."</a><BR><BR>";
                    echo $first." ".$last;
                
            }
        }
     }
     public static function DisplaySearchTweet($search)
     {
         $con = $GLOBALS["con"];
         $sql = "select tweet_id,tweet_text,user_id,original_tweet_id, reply_to_tweet_id,date_created from tweets where tweet_text LIKE UPPER('%".$search."%') AND reply_to_tweet_id = 0";
        
        
         $result = mysqli_query($con, $sql);          
         if(mysqli_num_rows($result) > 0)
         {
             echo '<span class ="font-weight-bold">TWEETS FOUND</span><hr/>';
             
             while($val = mysqli_fetch_array($result))
             {
                 //display original tweets
                 $res = self::GetTweetById($val["tweet_id"]);
                 self::GetTweets($res);
                
             }

         }
         else
         {
             echo "NOT TWEETS FOUND <BR>";
         }
         
     }
     public static function GetOriginalTweetResult($tweetId)
     {
         $result = self::GetTweetById($tweetId);
         if($val = mysqli_fetch_array($result))
         {
             echo $val["tweet_id"]."   REply:". $val["reply_to_tweet_id"];
             if($val["reply_to_tweet_id"] == 0)
             {
                 echo "ZERO";
                 $r =  self::GetTweetById($val["tweet_id"]);
                 self::GetTweets($r);
             }
             else
             {
                   self::GetOriginalTweetResult($val["reply_to_tweet_id"]);
                 
             }
         }
     }
     public static function GetReplyTweetId($reply)
     {
         $con = $GLOBALS["con"];
         $sql = "select * from tweets where reply_to_tweet_id = $reply";
         $result = mysqli_query($con, $sql);
         return $result;
     }
     public static function  GetRecentLikes($userId)
     {
         $con = $GLOBALS["con"];
         $sql = "select * from likes where tweet_id in (select tweet_id from tweets where user_id = $userId)order by date_created desc";
         $result = mysqli_query($con, $sql);
         if(mysqli_num_rows($result) > 0)
         {
             while($val = mysqli_fetch_array($result))
             {//like result
                 $user = User::GetUserById($val["user_id"]);
                 while($userVal = mysqli_fetch_array($user))
                 {//user details
                     $profile = $userVal["profile_pic"];
                     if($profile == null)
                     {
                        $profile = 'default.jfif'; 
                     }
                     $tweet = self::GetTweetTextById($val["tweet_id"]);
                     $Name = $userVal["first_name"]." ".$userVal["last_name"];
                     $time = self::Interval($val["date_created"]);
                     echo '<img class = "bannericons" width="35" height="35" src="images/profilepics/'.$profile.'">'
                             . '&nbsp;&nbsp <a href="userpage.php?userId='.$userVal["user_id"].'">'.$Name.'</a>   Liked you tweet  '.$time.'<BR/>'.$tweet.'<hr/>';
                 }
             }
         }
         else
         {
             echo"<hr/>";
             return null;
         }
     }
     
     public static function GetTweetTextById($tweetId)
     {
         $con = $GLOBALS["con"];
         $tweet = self::GetTweetById($tweetId);
         //$result = mysqli_query($con,$tweet);
         if($val = mysqli_fetch_array($tweet))
         {
             return $val["tweet_text"];
         }
         
     }
     public static function GetRecentReTweet($userId)
     {
         $con = $GLOBALS["con"];
         $sql = "select tweet_text, date_created, user_id from tweets where original_tweet_id != 0  and original_tweet_id in (select tweet_id from tweets where user_id = $userId)order by date_created desc";
         $result = mysqli_query($con, $sql);
         if(mysqli_num_rows($result) > 0)
         {
             while($val = mysqli_fetch_array($result))
             {
                  $user = User::GetUserById($val["user_id"]);
                  while($userVal = mysqli_fetch_array($user))                    
                  {
                      $profile = $userVal["profile_pic"];
                      if($profile == null)
                     {
                        $profile = 'default.jfif'; 
                     }
                      $Name = $userVal["first_name"]." ".$userVal["last_name"];
                      $time = self::Interval($val["date_created"]);
                      $tweet = $val["tweet_text"];
                      
                      echo'<img class = "bannericons" width="35" height="35" src="images/profilepics/'.$profile.'">'
                              . '   <a href="userpage.php?userId='.$userVal["user_id"].'">'.$Name.'</a>  Retweeted your tweet '.$time.'  <BR> '.$tweet.'<hr/>';
                  }
             }
         }
         else
         {
             echo "<hr/>";
             return null;
         }
     }
     public static function GetRecentReplies($userId)
     {
         $con =$GLOBALS["con"];
         $sql ="select user_id,tweet_text,date_created from tweets where reply_to_tweet_id != 0  and reply_to_tweet_id in (select tweet_id from tweets where user_id = $userId) order by date_created desc";
         //echo $sql;
         $result = mysqli_query($con, $sql);
         if(mysqli_num_rows($result) > 0)
         {
             while($val = mysqli_fetch_array($result))
             {
                  $user = User::GetUserById($val["user_id"]);
                  while($userVal = mysqli_fetch_array($user))                    
                  {
                      $profile = $userVal["profile_pic"];
                      if($profile == null)
                     {
                        $profile = 'default.jfif'; 
                     }
                      $Name = $userVal["first_name"]." ".$userVal["last_name"];
                      $time = self::Interval($val["date_created"]);
                      $tweet = $val["tweet_text"];
                      
                      echo'<img class = "bannericons" width="35" height="35" src="images/profilepics/'.$profile.'">'
                              . '   <a href="userpage.php?userId='.$userVal["user_id"].'">'.$Name.'</a>  Retweeted your tweet '.$time.'  <BR> '.$tweet.'<hr/>';
                  }
             }
         }
         else
         {
             echo "<hr/>";
             return null;
         }
     }

}
