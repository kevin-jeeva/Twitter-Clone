<?php include("../connect.php"); ?>
    <?php

//$_POST - lets look at http header
//it is a special variable

//we need to connect to database
 // 1.host - localhost
 // 2. username - root
 // 3. password - blank
 //4. database name - productsdemo


if (isset($_POST["txtName"])) {
    //won't get here the first time you visit the page
    //will only get if a form has been submitted via post
    
    //define("DB_HOST", "localhost");//define a constant at run time
    
    $name = $_POST["txtName"];
    $email = $_POST["txtEmail"];
    echo($name." ".$email. "<br>");
//    
   //select statement
    $sql = "select * from products";   
    if($result = mysqli_query($con, $sql))
    {
        while ($row = mysqli_fetch_array($result))
        {
            echo $row["ID"]. "  ".$row["Category"]. "  " . $row["Description"]."<br>"; 
        }
    }
    
    //insert statement
   /* $prodId = 1000;//$_POST["Whatever"]
    $desc = $name;
    $price = 19.99;
    
    $sql = "INSERT INTO `productsdemo`.`products`
(`ID`,`Category`,`Description`,`Image`,`Price`)VALUES($prodId, 'rock', '$desc','',$price)";
  // echo $sql; 
    mysqli_query($con, $sql);
    
    if(mysqli_affected_rows($con) == 1)
    {
        $msg = "Record inserted";
       // echo "Inserted";
    }
    else
    {
        $msg = " Oops something happened ";
    }*/
    $msg = "";
    //update statement 
    $desc = " kevin";
    $sql = "update products set Description =  '$desc' where ID = 1000";
    mysqli_query(($con), $sql);//this executes the statement
    echo $sql;
    if(mysqli_affected_rows($con) == 1)
    {
       $msg = "update successful";
    }
    else 
    {
      $msg = "error on update";   
    }
    
    //send the user somewhere else using a header redirect
      //? is the url query string 
    header("location:chap27.php?message=$msg");//this is a redirect 
     
      
   }

    ?>

