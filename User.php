<?php

include_once("connect.php");

class User {

    private $userId;
    private $password;
    private $lastName;
    private $firstName;
    private $userName;
    private $province;
    private $phone;
    private $dateAdded;
    private $location;
    private $url;
    private $email;
    private $address;
    private $postalCode;
    private $profileImage;
    private $description;

    public function __construct($userId, $password, $lastName, $firstName, $userName, $province, $phone, $dateAdded, $location, $url, $email, $address, $postalCode, $profileImage, $description) {
        $this->userId = $userId;
        $this->password = $password;
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->userName = $userName;
        $this->province = $province;
        $this->phone = $phone;
        $this->dateAdded = $dateAdded;
        $this->location = $location;
        $this->url = $url;
        $this->email = $email;
        $this->address = $address;
        $this->postalCode = $postalCode;
        $this->profileImage = $profileImage;
        $this->description = $description;
    }
    
    public function __destruct() {
       // echo ("OBJECT DESTROYED");
    }
    
    public function __set($name, $value) {
        $this->$name = $value;
    }
    
    public function __get($name) {
        return $this->$name;
    }
    public function Insert($user)
    {
        return $user->firstName;
        //header("location:index.php");
    }
    public static function InsertNewUSer($user)
    {
        $con = $GLOBALS["con"];         
        //INSERT NEW USER
         $sql = "INSERT INTO `users`(`first_name`,`last_name`,`screen_name`,`password`,`address`,`province`,`postal_code`,`contact_number`,`email`,`url`,`description`,`location`)VALUES('$user->firstName'"
            . " ,'$user->lastName','$user->userName','$user->password','$user->address','$user->province' ,'$user->postalCode','$user->phone','$user->email','$user->url','$user->description','$user->location')";
        
        echo $sql;     
       
        mysqli_query($con, $sql);
        $msg = " ";
        
        if(mysqli_affected_rows($con) == 1) 
        {
           // echo 'success'; 
           $msg =  "your account is created Sucessfully!!";
           header("location:Login.php?message=$msg");  
        }
        else                               
        {
             //echo 'fail'; 
            $_SESSION["alert"] = "your account is not created, Please correct your errors!!";
            header("location:Signup.php?message=$msg"); 
        }
    }
    
    public static function UserNamCheck($name)
    {
        $con = $GLOBALS["con"]; 
        $userSql = "Select * from users Where screen_name = UPPER('$name')";
        // echo $userSql;
        $result = mysqli_query($con, $userSql);
         if(mysqli_num_rows($result) > 0)
        {
            return false;
        }
        else
        {
           // echo $userSql;
            return true;
        }
        
    }
    public static function GetUserDetailsByName($user)
    {
        $con = $GLOBALS["con"];        
        $sql = "SELECT user_id,first_name,last_name,screen_name,password,address,province,postal_code,contact_number, email,url,description,location,date_created,profile_pic 
                FROM users where screen_name = UPPER('$user->userName')";        
         $result = mysqli_query($con, $sql);
         return $result;
    }
    public static function GetUserDetailsById($user)
    {
        $con = $GLOBALS["con"];
        $sql = "Select user_id, date_created, screen_name, first_name, last_name from users where user_id = $user->userId";
        $result = mysqli_query($con, $sql);
        return $result;
    }
    public static function GetUserById($userId)
    {
        $con = $GLOBALS["con"];
        $sql = "Select user_id, date_created, screen_name, first_name, last_name,profile_pic,province from users where user_id = $userId";
        $result = mysqli_query($con, $sql);
        return $result;
    }
    public static function GetFollws($user)
    {
        $con = $GLOBALS["con"];    
        $sql = "SELECT user_id,first_name, last_name, screen_name,profile_pic from users where user_id != $user->userId And user_id Not in (Select to_id from follows where from_id = $user->userId) Order by rand() Limit 3";
        $result = mysqli_query($con, $sql);
        return $result;
    }
    public static function DisplayFollows($result)
    {
        while($val = mysqli_fetch_array($result))
       {
            $followUser= new User(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
            $followUser->profileImage = $val["profile_pic"];
           if($followUser->profileImage == null)
           {
              echo '<img class="bannericons" src="Images/profilepics/default.jfif">'; 
           }
           else
           {
              // $profile = $val["profile_pic"];
               echo "<img class=\"bannericons\" src=Images/profilepics/$followUser->profileImage>";
           }
           $followUser->firstName= $val["first_name"];
           $followUser->lastName = $val["last_name"];
           $followUser->userName = $val["screen_name"];
           $followUser->userId = $val["user_id"];
           
           $r = User::myTruncate( $followUser->firstName,$followUser->lastName,$followUser->userName);
           
           echo '<a href = "userpage.php?userId='.$val["user_id"].'">'.$r.'</a>';
           echo "<BR>";
           echo '<form method = "post" action = "Follow_proc.php">'
           . '<input  id = "followbutton" class = "followbutton" type = "submit" value = "Follow" name = "Follow">'
                   . '<input type = "hidden" value = '.$followUser->userId.' name = "FollowVal">'
                   . '<input type = "hidden" value = '.$followUser->userName.' name = "Following"></form>';   
           echo "<hr />";

        }
    }
    public static function LoginCheck($user)
    {
        $result = User::GetUserDetailsByName($user);
    
        if($val = mysqli_fetch_array($result))
        {
            if(password_verify($user->password, $val["password"])) 
            {    
                $user->firstName = $val["first_name"];
                $user->lastName = $val["last_name"];
                $user->userId = $val["user_id"];
                $user->userName = $val["screen_name"];  

            $_SESSION["first_name"] = $user->firstName;
            $_SESSION["Last_name"] = $user->lastName;     
            $_SESSION["user_Id"] = $user->userId;
            $_SESSION["user"] = $user->userName;

            $msg = "you are log in as"." " .$user->firstName;
            $_SESSION["alert"] = "you are log in as"." " .$user->firstName;
            header("location:index.php");
            }
           else 
            {
             $msg = "Please provide a valid password";
             session_destroy();
             header("location:Login.php?message=$msg");
            }
        }

        else
        {

             $msg = "Please provide a valid username and password";
             session_destroy();
             header("location:Login.php?message=$msg");
        }
    }
    public static function myTruncate($first, $last, $user)
    {

        $count = strlen($first.$last."@".$user);
        if($count <= 25)
        {
            return $first." ".$last." @".$user;
        }
        else 
        {
           $first = substr($first,0,9);    
           $last = substr($last, 0, 8);
           $user = substr($user, 0, 8);
           return $first." ".$last." @".$user;
        }
    
    }
    public static function DisplayPic($userId)
    {
        $result = self::GetUserById($userId);
        $first = "";
        $last = "";
        while($val = mysqli_fetch_array($result))
        {
            if($val["profile_pic"] == null)
            {
                $count = strlen($val["first_name"]." ".$val["last_name"]);
                if($count > 18)
                {
                    
                    $first = substr($val["first_name"],0,10);
                    $last = substr($val["last_name"], 0 ,10);
                   
                }
                else
                {
                    $first = $val["first_name"];
                    $last = $val["last_name"];
                }
                    echo'<img class="bannericons" src="images/profilepics/default.jfif">&nbsp;';
                    echo $first." ".$last;
                 
            }
            else
            {
                $count = strlen($val["first_name"]." ".$val["last_name"]);
                if($count > 18)
                {
                    
                    $first = substr($val["first_name"],0,10);
                    $last = substr($val["last_name"], 0 ,10);
                   
                }
                else
                {
                    $first = $val["first_name"];
                    $last = $val["last_name"];
                }
                    $profile = $val["profile_pic"];
                    echo'<img class="bannericons" src="images/profilepics/'.$profile.'">';
                    echo $first." ".$last;
                
            }
        }
    }
    public static function DisplayProvince($userId)
    {
        $result = self::GetUserById($userId);
        if($val = mysqli_fetch_array($result))
        {
            echo $val["province"];
        }
    }
    public static function DisplayDate($userId)
    {
        $result = self::GetUserById($userId);
        if($val = mysqli_fetch_array($result))
        {
            $date =  $val["date_created"];
            $since = new DateTime($date);
            echo $since->format("M d, Y");
        }
    }
    public static function SearchUser($search)
    {
        $con = $GLOBALS["con"];
       
        $sql = "Select user_id  from users where first_name LIKE UPPER('$search%') OR last_name LIKE UPPER('$search%') OR screen_name  LIKE UPPER('$search%')";
        $result = mysqli_query($con, $sql);
        if(mysqli_num_rows($result) > 0)
        {
            echo '<span class ="font-weight-bold">USERS FOUND</span><hr/>';
             self::DisplaySearchUser($result);
        }
        else
        {
              echo "USER NOT FOUND";
        }
    }
    public static function DisplaySearchUser($result)
    {
        $user = $_SESSION["user_Id"];
        while($val = mysqli_fetch_array($result))
        {
            if($val["user_id"] != $user)
            {
                self::FollowButton($val["user_id"]);
            }
            else
            {
                $id = $_SESSION["user_Id"];
                $text =  $_SESSION["first_name"].' '.$_SESSION["Last_name"].' @'.$_SESSION["user"];
                echo '<a href ="userpage.php?userId='.$id.'">'.$text.'</a><BR>';
            }
            
        }
    }
    public static function FollowButton($searchUserId)
    {
        $con = $GLOBALS["con"];
        $user = $_SESSION["user_Id"];
        $sql = "Select follow_id from follows where from_id = $user and to_id = $searchUserId";
        $result = mysqli_query($con, $sql);        
        if(!(mysqli_num_rows($result) > 0))
        {
             $nextSql = "Select follow_id from follows where from_id = $searchUserId and to_id = $user";
             $result2 = mysqli_query($con, $nextSql);       
             if(!(mysqli_num_rows($result2) > 0))
             {
                 $userDetails = self::GetUserById($searchUserId);
                 while($valUserDetails = mysqli_fetch_array($userDetails)){
                     if($valUserDetails["user_id"] != $user)
                     {
                 $id = $valUserDetails["user_id"];
                 $name = $valUserDetails["screen_name"];
                 $text = $valUserDetails["first_name"]." ".$valUserDetails["last_name"]." @".$valUserDetails["screen_name"];
                 echo '<form method = "post" action = "Follow_proc.php">'
                           . '<a href ="userpage.php?userId='.$id.'">'.$text.'</a>     <input  id = "followbutton" class = "followbutton" type = "submit" value = "Follow" name = "Follow">'
                            . '<input type = "hidden" value = '.$id.' name = "FollowVal">'
                            . '<input type = "hidden" value = '.$name.' name = "Following"></form><BR>';
                     }
                     
                 }
                 
             }
             else
             {
                 //display follow button and not following you and 
                 $userDetails = self::GetUserById($searchUserId);
                  while($valUserDetails = mysqli_fetch_array($userDetails)){
                    if($valUserDetails["user_id"] != $user)
                  {
                 $id = $valUserDetails["user_id"];
                 $name = $valUserDetails["screen_name"];                
                 $text = $valUserDetails["first_name"]." ".$valUserDetails["last_name"]." @".$valUserDetails["screen_name"];
                  echo '<form method = "post" action = "Follow_proc.php">'
                           . '<a href ="userpage.php?userId='.$id.'">'.$text.'</a>   <input  id = "followbutton" class = "followbutton" type = "submit" value = "Follow" name = "Follow">|Follows You'
                            . '<input type = "hidden" value = '.$id.' name = "FollowVal">'
                            . '<input type = "hidden" value = '.$name.' name = "Following"></form>';
                  }
                
                  }
             }
        }
        else
        {
             $nextSql = "Select follow_id from follows where from_id = $searchUserId and to_id = $user";
             $result2 = mysqli_query($con, $nextSql);
             if(mysqli_num_rows($result2) > 0)
             {
                 $userDetails = self::GetUserById($searchUserId);
                  while($valUserDetails = mysqli_fetch_array($userDetails)){
                    if($valUserDetails["user_id"] != $user)
                  {
                 $id = $valUserDetails["user_id"];
                 $name = $valUserDetails["screen_name"];
                 $text = $valUserDetails["first_name"]." ".$valUserDetails["last_name"]." @".$valUserDetails["screen_name"];
                 echo '<a href ="userpage.php?userId='.$id.'">'.$text.'</a>   Following | Follows You<BR>';
                  }
               
                  }
             }
             else
             {
                  $userDetails = self::GetUserById($searchUserId);
                   while($valUserDetails = mysqli_fetch_array($userDetails)){
                     if($valUserDetails["user_id"] != $user)
                     {
                 $id = $valUserDetails["user_id"];
                 $name = $valUserDetails["screen_name"];
                 $text = $valUserDetails["first_name"]." ".$valUserDetails["last_name"]." @".$valUserDetails["screen_name"];
                 echo '<a href ="userpage.php?userId='.$id.'">'.$text.'</a>    Following | Not Follows You<BR>';
                     }
                   
                   }
             }
             
             
        }
    }//main method end
    
    public static function GetAllMessages($userId)
    {
        $con = $GLOBALS["con"];
        $sql = "Select * from messages where to_id = $userId";
       
        $result = mysqli_query($con, $sql);
        if(mysqli_num_rows($result) > 0)
        {
            
            while($val = mysqli_fetch_array($result))
            {
                
                $User = self::GetUserById($val["from_id"]);
                while($valUser = mysqli_fetch_array($User))
                {
                    
                    $Name = $valUser["first_name"]." ".$valUser["last_name"]." @".$valUser["screen_name"];  
                    $message = $val["message_text"];                    
                    echo '<a href="userpage.php?userId='.$val["from_id"].'">'.$Name.'</a><BR>'.$message."<hr/>";
                }
                
            }
        }
        else
        {
            echo "<h2> No Messages Yet :)</h2>";
        }
    }
    public static function GetUserByScreenName($screenName)
    {
        $con = $GLOBALS["con"];
        $sql = "Select * from users where screen_name = UPPER('$screenName')";
        $result = mysqli_query($con,$sql);
        echo $sql;
        if(mysqli_num_rows($result) > 0)
        {
            while($val = mysqli_fetch_array($result))
            {
                return $val["user_id"];
            }
        }
        else
        {
            return false;
        }
    }
    public static function AddMessages($Main, $userId, $message)
    {
        $con = $GLOBALS["con"];
       
        $sql ="Insert into messages(from_id, to_id,message_text) values($Main,$userId,'$message')";
        mysqli_query($con, $sql);
        if(mysqli_affected_rows($con) == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public static function SearchUsersAjax($userName, $mainUser)
    {
        $con = $GLOBALS["con"];
        $sql = "Select * from users where screen_name like UPPER('$userName%')"; 
        $result = mysqli_query($con , $sql);
        $myArray = array();
        if(mysqli_num_rows($result) > 0)
        {
            while($val = mysqli_fetch_array($result))
            {
                //echo $val["screen_name"];
                //echo $val["user_id"];
                if($val["user_id"] == $mainUser)
                {
                    continue;
                }
                else
                {
                    $userId = $val["user_id"];
                    $values = self::CheckFollow($userId, $mainUser);
                    if($values == true)
                    {
                        $ResultUser = self::GetUserById($userId);   
                        while($ResVal = mysqli_fetch_array($ResultUser))
                        {
                            $OrgName = $ResVal["first_name"]." ". $ResVal["last_name"];
                            $Name = array("screen"=>$ResVal["screen_name"],"Name"=>$OrgName);
                           
                           // $js = json_encode($ResVal);
                            array_push($myArray, $Name);
                        }
                        
                    }   
                    else
                    {
                        continue;
                    }
                   
                }
            }
            
            if($myArray != null)
            {
                return $myArray;
                
            }
            else
            {
                return null;
            }
            
        }
        else
        {
            return null;
        }
    }
    public static function CheckFollow($userId, $mainUser)
    {
        $con = $GLOBALS["con"];
        $NewSql = "Select to_id from follows where from_id = $mainUser";                    
        $newResult = mysqli_query($con, $NewSql);
        if(mysqli_num_rows($newResult) > 0)
        {
            while($newVal = mysqli_fetch_array($newResult))
            {
                if($newVal["to_id"] == $userId)
                {                    
                    return true;
                }
            }
            return false;
        }
        else
        {
           echo 'NO USERS FOUND';
           return false;

        }
    }
  

}
