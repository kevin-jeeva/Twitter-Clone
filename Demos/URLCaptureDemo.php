<?php

// Sometimes, you have to check if something exists before trying to use it.
// Recognize the conditional assignment?
$PageID = empty($_GET['PageID'])? "" : $_GET['PageID'];

?>

<html>
<head>
	<title>URL Capture Demo</title>
</head>

<body>

<?php
	 echo '
	 
	 <H2>Your requested PageID is ' . $PageID . '  </H2>
	 
	 '
?>

</body>
</html>
