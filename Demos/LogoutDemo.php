<?php
session_start();
unset($_SESSION["user"]);
session_destroy();
?>

<html>
<head>
	<title>Logout Demo</title>
</head>

<body>

	  <h3>You are now logged out.</h3>
	  <a href="LoginDemo.php">Click Here</a> to return to the login page.

</body>
</html>
