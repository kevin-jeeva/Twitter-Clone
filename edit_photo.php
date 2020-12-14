<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Contact Us Page">
    <meta name="author" content="Kevin Daniel">
    <link rel="icon" href="favicon.ico">
    <link href="includes/starter-template.css" rel="stylesheet">
    <title>Edit Photo</title>  
    <link href="includes/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.10.2.js" ></script>
  <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">-->
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
  <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>-->
 
  
</head>
<body>
    <div class = "container"><?php 
    session_start();
    include("connect.php"); 
    
    include("includes/Header.php");?>
        
<div class ="container">
    <BR><BR>
<form class="form-group" id = "frm_photo" action="edit_photo_proc.php" method="post" enctype="multipart/form-data">
    <h1><mark>Select your image (Must be under 10MB in size):<mark></h1><br>
               
	<input class ="btn btn-primary btn-block btn-lg"type="file" accept="image/*" name="pic"><br>
        
                
	<input class="btn btn-success btn-block btn-lg" id="button" type="submit" name="submit" value="Submit">

</form>
</div>
</body>
</html>
<?php

if(isset($_SESSION["alert"]) && ($_SESSION["alert"] != ""))
{
    $message = $_SESSION["alert"];
    echo  "<script>alert('$message')</script>";
    $_SESSION["alert"] = "";
}

?>