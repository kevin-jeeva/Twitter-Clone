<?php
//these are defined as constants

define('DB_HOST', 'localhost:3308');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'bitter-kevin');

//define('DB_NAME', 'productsdemo');


global $con;
	  $con = mysqli_connect(DB_HOST,DB_USER,DB_PASS, DB_NAME);
          //check it is a valid connection
      if (!$con)
      {
         die('Could not connect: ' . mysqli_error());
      }
?>
