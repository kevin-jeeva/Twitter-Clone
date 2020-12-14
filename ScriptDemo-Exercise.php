<?php
// This code prevents page caching

	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1			
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 	// Date in the past	
	header("Pragma: no-cache");
?> 

<?php
// Normally, we would place our database connectivity code here.				
// In the case of this 1-2-3 example, you will find it embedded in Step3 below.	

?>

<html>
 
<head>
	<title>Simple Scripting Demo</title>
</head>

<body />



<?php 
// "Database Connectivity"

	// Normally, because you only have to connect once per page,
	// you would put this at the top of the page.				

	
	// Server													
	$db_server = "localhost:3308";
  
	// Database username (root is default)						
	$db_user = "root";
  
	// Database password 										
	// Our database doesn't have a password						
	$db_passwd = "";
  
	// Database name 											
	// In this example, should be the one you created in phase 1	
	$db_name = "productsdemo";
	
	// 1. Create a connection to the local database				
	$db_connected = mysqli_connect($db_server, $db_user, $db_passwd,$db_name) 
		or die("Not connected : " . mysql_error());

// End of "Database Connectivity"		
?>

<?php

	$strSQL = "SELECT ID, Category, Image, Price, Description,Option1Desc, Option1a, Option1b, Option1c,Option1d,Option2Desc, Option2a, Option2b, Option2c, Option2d FROM Products ORDER BY ID";
									
	$rsProd = mysqli_query($db_connected, $strSQL)
		or die($db_name . " : " . $strSQL . " : " . mysql_error());
		

?>

<p><b>
<!-- Normally, we would not show this to the user! 									--> 
<!-- This is useful debug code so you can see what is going on behind the scenes 	-->
<font color="#ff0000">Connected to :: </font><?php echo $db_name; ?> <br />
<font color="#ff0000">Using SQL :: </font><?php echo $strSQL; ?> <br />
<font color="#ff0000">Records retrieved :: </font><?php echo mysqli_num_rows($rsProd); ?> <br /><br />
</b></p>

<?php 
	
  
  while ($rowProd = mysqli_fetch_array($rsProd)) {
  
   
	   echo '
		  <hr /><br />
		  <img src="Demos/images/' 		. $rowProd["Image"] . '.gif" height=100 width=100 align=left />
		  Item #' 					. $rowProd["ID"] .  
		  '<br />Price :: ' 		. number_format($rowProd["Price"], 2, ".", ",") . 
		  '<br />Category :: ' 		. $rowProd["Category"] . 
		  '<br />Description::'         .$rowProd["Description"].'<br />
		';		
		
		if ($rowProd["Option1Desc"] != "") {
			echo '
				<br clear=all /><br />
				option1desc <br />
				<ul>
					<li>'.$rowProd["Option1a"].'</li> <li>'.$rowProd["Option1b"].'</li>
					<li>'.$rowProd["Option1c"].'</li> <li>'.$rowProd["Option1d"].'</li>
				</ul>
			';
		}
					
		// Display Option2... currently mostly hardcoded, but with some							
		// provided code for inspiration. Change to be dynamic, from database.					
		if ( $rowProd["Option2Desc"] != "" ) {
		   	echo '
				<br clear=all /><br /> '
				. $rowProd["Option2Desc"] . ' <br /> 
				<ul>
					<li>'.$rowProd["Option2a"].'</li> <li>'.$rowProd["Option2b"].'</li>
					<li>'.$rowProd["Option2c"].'</li> <li>'.$rowProd["Option2d"].'</li>
				</ul>
			';
		}	
} // End of the while		

// End of "Display Individual Records"	
?>
</BODY>
</HTML>
