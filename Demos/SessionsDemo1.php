<?php
// These 3 pages (SessionsDemo1,2,3) illustrate the use of Session Variables.															
// Session variables once created can be used by any page on your website!																

// Closing your browser kills the session.  Also, you as the programmer can kill the session using the session_destroy() method			
// shown in SessionsDemo3.																												

// Consider session variables to be similar to global variables in C++... once created, anybody can use them.							

// BEWARE!  Trying to use a session variable that has not been created will cause a PHP error to appear on your webpage,				
// along with any associated logic going awry.   Since a user can typically browse to any page in any order, you have to				
// take into account that your assumption that a session variable has been created by another page can't be held as						
// universally true!  When coding logic involving session variables, ALWAYS ask yourself the question "What if it doesn't exist?",		
// and code for that scenerio as well! 																									

 
	// 1. Start a session.  Every individual page that wants to use the shared session variables must do this.										
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
	<title>Session Demo 1</title>
</head>

<body>

	  <?php

	  	   // Calling an unregistered session variable					
		   // Similiar to trying to use an undeclared variable in C++	
	  	   echo '<h3>Trying to use an unregistered session variable...</h3>';
	  	   echo 'The content of $_SESSION[\'var1\'] is *' . $_SESSION["var1"] . '*<br /><br />';

	  	   // 2. Register 3 session variables							
		   // Similiar to declaring and initializing variables in C++	
	  	   $_SESSION["var1"] = "11111";
		   $_SESSION["var2"] = "22222";
		   $_SESSION["var3"] = "33333";

	  	   // 3. Using registered session variables																
		   // Here, I'm using them in simple HTML echos, but like any variable, you can do whatever you want.	
	  	   echo '<h3>Trying to use registered session variables...</h3>';
	  	   echo 'The content of $_SESSION[\'var1\'] is *' . $_SESSION["var1"] . '*<br />';
		   echo 'The content of $_SESSION[\'var2\'] is *' . $_SESSION["var2"] . '*<br />';
		   echo 'The content of $_SESSION[\'var3\'] is *' . $_SESSION["var3"] . '*<br /><br />';

	  ?>

	  <a href="SessionsDemo2.php">Next Page</a>

</body>
</html>
