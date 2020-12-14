<?php
// This page assumes that it is being called from SessionsDemo2.php

	// 7. Start a session.  Every individual page that wants to use the shared session variables must do this.										
	// If a page does not need to use the session variables, you do not need to do this step.  It does not affect any existing session variables.	
	session_start();
		   
// The session_start() declaration needs to go at the top of a PHP document before any HTML is sent to the browser.  The reason for this:
//		•	PHP Sessions create cookies
//		•	Cookies need to be sent in the HTTP header
//		•	The HTTP header is sent before the page document
//		•	Since a PHP script is interpreted in sequence, if any HTML (or other text/markup) is written to the page document, it is then too late to commit any changes to the HTTP header

?>


<html>
<head>
	<title>Session Demo 3</title>
</head>

<body>

	  <?php
		   
   		   echo '<h3>Checking to see if session variables are persistent between pages...</h3>';
	  	   if (isset($_SESSION["var1"])) echo 'The content of $_SESSION[\'var1\'] is *' . $_SESSION["var1"] . '*<br />';
		   if (isset($_SESSION["var2"])) echo 'The content of $_SESSION[\'var2\'] is *' . $_SESSION["var2"] . '*<br />';
		   if (isset($_SESSION["var3"])) echo 'The content of $_SESSION[\'var3\'] is *' . $_SESSION["var3"] . '*<br /><br />';

	 	   // 8. Deregistering individual session variables
	  	   unset($_SESSION["var2"]);
		   unset($_SESSION["var3"]);
		   
		   // 9. All done? Destroy the session to free up system resources        
		   // 	 Use this sparingly as it destroys all existing session variables!
	 	   session_destroy();
		   
		   echo '<h3>Checking to see if any session variables remain...</h3>';
	  	   if (isset($_SESSION["var1"])) echo 'The content of $_SESSION[\'var1\'] is *' . $_SESSION["var1"] . '*<br />';
		   if (isset($_SESSION["var2"])) echo 'The content of $_SESSION[\'var2\'] is *' . $_SESSION["var2"] . '*<br />';
		   if (isset($_SESSION["var3"])) echo 'The content of $_SESSION[\'var3\'] is *' . $_SESSION["var3"] . '*<br /><br />';

	 ?>

		   <a href="SessionsDemo1.php">Back to beginning</a>

</body>
</html>
