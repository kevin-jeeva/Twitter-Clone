<?php
// This page assumes that it is being called from SessionsDemo1.php


	// 4. Start a session.  Every individual page that wants to use the shared session variables must do this.										
	// If a page does not need to use the session variables, you do not need to do this step.  It does not affect any existing session variables.	
	session_start();
	// Comment out the above to see the affect on the demo!
		   
// The session_start() declaration needs to go at the top of a PHP document before any HTML is sent to the browser.  The reason for this:
//		•	PHP Sessions create cookies
//		•	Cookies need to be sent in the HTTP header
//		•	The HTTP header is sent before the page document
//		•	Since a PHP script is interpreted in sequence, if any HTML (or other text/markup) is written to the page document, it is then too late to commit any changes to the HTTP header

?>


<html>
<head>
	<title>Session Demo 2</title>
</head>

<body>

	  <?php
	  
	  	   echo '<h3>Checking to see if session variables are persistent between pages...</h3>';
	  	   echo 'The content of $_SESSION[\'var1\'] is *' . $_SESSION["var1"] . '*<br />';
		   echo 'The content of $_SESSION[\'var2\'] is *' . $_SESSION["var2"] . '*<br />';
		   echo 'The content of $_SESSION[\'var3\'] is *' . $_SESSION["var3"] . '*<br /><br />';

	  	   // 5. Deregistering individual session variable														
		   // Remember how we could "delete" dynamically allocated variables in C++?  This is the same concept.	
	  	   unset($_SESSION["var1"]);

	  	   echo '<h3>Checking to see if "var1" has been destroyed (without isset)...</h3>';
	  	   echo 'The content of $_SESSION[\'var1\'] is *' . $_SESSION["var1"] . '*<br />';
		   echo 'The content of $_SESSION[\'var2\'] is *' . $_SESSION["var2"] . '*<br />';
		   echo 'The content of $_SESSION[\'var3\'] is *' . $_SESSION["var3"] . '*<br /><br />';
		   
		   // 6. Notice the error message you received from trying to use an "unset" variable?	
		   //    Better coding practice is to do this...										
		   
		   echo '<h3>Checking to see if "var1" has been destroyed (with isset)...</h3>';
	  	   if (isset($_SESSION["var1"])) echo 'The content of $_SESSION[\'var1\'] is *' . $_SESSION["var1"] . '*<br />';
		   if (isset($_SESSION["var2"])) echo 'The content of $_SESSION[\'var2\'] is *' . $_SESSION["var2"] . '*<br />';
		   if (isset($_SESSION["var3"])) echo 'The content of $_SESSION[\'var3\'] is *' . $_SESSION["var3"] . '*<br /><br />';
	  	  

	  ?>
	  
	  <a href="SessionsDemo3.php">Next Page</a>

</body>
</html>
