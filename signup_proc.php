<?php //include("connect.php"); ?>
<?php 
session_start();

//INCLUDE FILES
include("connect.php"); 
include("User.php");

function ValidateUser()
{
     $user = $_POST["username"];;
     $userMain = AddSlahes($user);
     
     if(User::UserNamCheck($user))
     {
         return true;
     }
     else
     {
         return false;
     }
    
}

function AddSlahes($value)
{
    $trim = trim($value);
    $result = addslashes($trim);
    $resultMain = strip_tags($result);
    //echo $resultMain;
    return $resultMain;
    
}
//insert the user's data into the users table of the DB
//if everything is successful, redirect them to the login page.
//if there is an error, redirect back to the signup page with a friendly message

if(ValidateUser())
{
if(isset($_POST["firstname"])&&isset($_POST["lastname"])&&isset($_POST["email"])&&isset($_POST["username"])&&isset($_POST["password"])&&isset($_POST["confirm"])&&isset($_POST["phone"])&&isset($_POST["address"])&&
        isset($_POST["province"])&&isset($_POST["postalCode"])&&isset($_POST["url"])&&isset($_POST["desc"])&&isset($_POST["location"]))
{
    $password = AddSlahes($_POST["password"]);
    $pass = password_hash($password, PASSWORD_DEFAULT);
    if(ValidatePostal(AddSlahes($_POST["postalCode"]),AddSlahes($_POST["province"])))
    {
    //USER CLASS CONSTRUCTOR
    $user = new User(0,$pass,AddSlahes($_POST["lastname"]), AddSlahes($_POST["firstname"]),AddSlahes($_POST["username"]),AddSlahes($_POST["province"]),
           AddSlahes($_POST["phone"]),0,AddSlahes($_POST["location"]),AddSlahes($_POST["url"]),AddSlahes($_POST["email"]),
           AddSlahes($_POST["address"]),AddSlahes($_POST["postalCode"]),0,AddSlahes($_POST["desc"]));
    
    //Creates a new user
    User::InsertNewUSer($user);
    }//validate postal
    else
    {
        header("location:Signup.php");
    }
    
}
}
else
{
    $_SESSION["alert"] = "The username is already exists please choose another name";   
    header("location:Signup.php");
}

function ValidatePostal($postalp,$province)
{
    $postal = $postalp;
    $postal = explode(" ", $postal);
    $pr ="";
    foreach ($postal as $p)
    {
        $pr = $pr.$p;
    }
   
    //echo $pr;
    //echo $postal;
    $provinceCode1 = GetProvinceCode($province);
   
    $url = "http://localhost/includes/fedex/ValidatePostalCodeService/ValidatePostalCodeWebServiceClient.php?"
            ."PostalCode=$pr";
    $cobj = curl_init();
    curl_setopt_array($cobj, Array(
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_ENCODING       => 'UTF-8'
    ));
  
    $data = curl_exec($cobj);
   
    echo $data;
    $provinceCodeCheck = simplexml_load_string($data);
     $result =  $provinceCodeCheck->result;    
     $message = $provinceCodeCheck->message;
     echo $result."<BR>".$message;
     if($result == 'true')
     {
         if($message == $provinceCode1)
         {
           //  echo "<script>alert('Sucess')</script>";
             return true;
         }
         else
         {
              $_SESSION["alert"] = "Please correct the province";
              return false;
         }
     }
     else
     {
         $_SESSION["alert"] = "$message";
          return false;
     }
    
   
      
}
function GetProvinceCode($province)
{
    switch($province)
    {
        case "British Columbia":
            return 'BC'; 
            break;
        case "Alberta":
            return 'AB';
            break;
        case "Saskatchewan":
            return 'SK';
            break;
        case "Manitoba":
            return 'MB';
            break;
        case "Ontario":
            return 'ON';
            break;
        case "Quebec":
            return 'QC';
            break;
        case "New Brunswick":
            return 'NB';
            break;
        case "Prince Edward Island":
            return 'PE';
            break;
        case "Nova Scotia":
            return 'NS';
            break;
        case "Newfoundland and Labrador":
            return 'NF';
            break;
        case "Northwest Territories":
            return 'NT';
            break;
        case "Nunavut":
            return 'NU';
            break;
        case "Yukon":
            return 'YT';
            break;
        
    }
}

?>