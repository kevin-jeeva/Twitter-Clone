<?php

	// 1. Start a session
	session_start();
		   
// The session_start() declaration needs to go at the top of a PHP document before any HTML is sent to the browser.  The reason for this:
//		•	PHP Sessions create cookies
//		•	Cookies need to be sent in the HTTP header
//		•	The HTTP header is sent before the page document
//		•	Since a PHP script is interpreted in sequence, if any HTML (or other text/markup) is written to the page document, it is then too late to commit any changes to the HTTP header

?>



<html>
<head>
	<title>Login Demo</title>
</head>

<body>

<?php

if (isset($_SESSION["user"])) {
	// Check if the session variable has already been registered
	echo 'You are already logged in!';
	echo '<br /><a href="LogoutDemo.php">Log Out</a>';
} else {
	// Check that the login form was submitted
	if (isset($_POST["username"])) {
		// check the username
		if ($_POST["username"] == "zxcvb") {
			
			// Check the password
			// BUT we don't want to keep the password in plain text:
			// if ($_POST["password"] == "mnbvc") {
			
			// The sha1 hash will be what should be stored in the database
			if (sha1($_POST["password"]) == "7f8fc84dd2a02f8e4ae8844c40688ebc1416260c") {
				//echo sha1($_POST['password']);
				echo 'You\'ve successfully logged in!';
				echo '<br /><a href="LogoutDemo.php">Log Out</a>';
				$_SESSION["user"] = $_POST["username"];
			} else {
			  	echo $_POST["password"];
				echo ' hashed to ';
				echo sha1($_POST["password"]);
				echo '<br /><br />Was expecting a password that hashes to ';
				echo sha1("mnbvc");
				
				echo '<br /><br />Password failed.';
				echo '<br /><br /><a href="LoginDemo.php">Try again</a>';
			}
		} else {
			echo 'Username not registered.';
		}
	} else {
		// Display login form
		echo '
			<form name="login_form" action="" method="POST">
				<label for="username">User Name (zxcvb)</label>
				<input type="text" name="username" id="username" /><br />
				<label for="username">Password (mnbvc)</label>
				<input type="password" name="password" id="password" /><br />
				<input type="submit" value="Login" />
			</form>
		';
	}
}

?>

</body>
</html>
