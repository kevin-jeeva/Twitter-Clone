<?php

function curPageURL() {
 $pageURL = 'http://';
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

function curPageLocation() {
 return $_SERVER["REQUEST_URI"];
}

function curPageName() {
 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}

?>


<html>
<head>
	<title>Page Name Demo</title>
</head>

<body>

<?php
	 echo "<BR>The current page URL is ".curPageURL();
	 
	 echo "<BR>The current page location is ".curPageLocation();
	 
	 echo "<BR>The current page name is ".curPageName();
?>

</body>
</html>
