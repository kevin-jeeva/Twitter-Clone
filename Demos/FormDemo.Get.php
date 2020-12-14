<?php 

// This page is designed to be called from FormDemo.php , so its logic is useless unless you are coming from that page	
// It demonstates how PHP retrieves URL Parameters.																		
	
// $_GET is a language construct and is known as a "SUPERGLOBAL" 
// The "$" denotes a variable
// Variables do not need to be declared in PHP
// PHP automatically determines the data type
 
// Look for a URL Parameter named firstname, and put its value into the variable $strFirstName
$strFirstName = $_GET["firstname"];
 
$strLastName  = $_GET["lastname"];
$strLanguage  = $_GET["language"];
$strFavCourse = $_GET["course"];

// isset() can be used to check if something exists before trying to use it, otherwise you'll invoke an error.
// Of course, ***good programming habits*** dictate you should always do this, even if you don't think
// you have to.  For example, I would implement the isset() shown below in the above code as well.

// To see what happens when things go wrong, change the above firstname to firstnameX and rerun FormDemo

// Recognize the conditional assignment?
// This is saying "If CPP exists, put its value into variable $strCPP.  Oterwise, put a NULL into $strCPP"
$strCPP 	  	= isset($_GET['CPP'])		 ?		$_GET['CPP']  	 	 :"";

$strVisualBasic = isset($_GET['VisualBasic'])?		$_GET['VisualBasic'] :"";
$strCOBOL 		= isset($_GET['COBOL'])		 ?		$_GET['COBOL']		 :"";
$strJava 		= isset($_GET['Java'])		 ?		$_GET['Java']		 :"";
$strOracle 		= isset($_GET['Oracle'])	 ?		$_GET['Oracle']		 :"";
$strHex 		= isset($_GET['Hex'])		 ?		$_GET['Hex']		 :"";

?>

 
<html>

 
<head>
<title>Fun with Forms - Get</title>
</head>

<body>

<p><hr>
	<font size="2" face="arial"> 
		  <b>You received ::</b>
		  <br />
		  <br /> First Name: <?php  echo $strFirstName; ?>
		  <br /> Last Name:  <?php  echo $strLastName; ?>
		  <br /> Language:  <?php  echo $strLanguage; ?>
		  <br /> Favorite Course:  <?php  echo $strFavCourse; ?>
		  <br /> Favorite Computer Language(s): 
		  <?php echo $strCPP; echo $strVisualBasic; echo $strCOBOL; echo $strJava; echo $strOracle; echo $strHex; ?>
	</font>
<hr></p>


<?php
// "Behind the scenes"
// Activate this code if you want to see all your GET variables in readable format
// Useful for debugging!

	echo '<pre>';
	print_r($_GET);
	echo '</pre>';

?>

<a href="formdemo.php">Back to beginning</a>

</body>
</html>

