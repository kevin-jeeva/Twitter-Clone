<?php

// This page is designed to be called from FormDemo.php , so its logic is useless unless you are coming from that page	
// It demonstates how PHP retrieves data in Local Memory.																

// $_POST is a language construct and is known as a "SUPERGLOBAL" 
// The "$" denotes a variable
// Variables do not need to be declared in PHP
// PHP automatically determines the data type

// Look in local memory for a post named firstname, and put its value into the variable $strFirstName
$strFirstName = $_POST["firstname"];

$strLastName  = $_POST["lastname"];
$strLanguage  = $_POST["language"];
$strFavCourse = $_POST["course"];

// isset() can be used to check if something exists before trying to use it, otherwise you'll invoke an error.
// Of course, ***good programming habits*** dictate you should always do this, even if you don't think
// you have to.  For example, I would implement the isset() shown below in the above code as well.

// To see what happens when things go wrong, change the above firstname to firstnameX and rerun FormDemo

// Recognize the conditional assignment?
// This is saying "If CPP exists, put its value into variable $strCPP.  Oterwise, put a NULL into $strCPP"
$strCPP 	  	= isset($_POST['CPP'])		 	?		$_POST['CPP']  	 	 	:"";

$strVisualBasic = isset($_POST['VisualBasic'])	?		$_POST['VisualBasic'] 	:"";
$strCOBOL 		= isset($_POST['COBOL'])		?		$_POST['COBOL']		 	:"";
$strJava 		= isset($_POST['Java'])		 	?		$_POST['Java']		 	:"";
$strOracle 		= isset($_POST['Oracle'])	 	?		$_POST['Oracle']		:"";
$strHex 		= isset($_POST['Hex'])		 	?		$_POST['Hex']		 	:"";

?>

<HTML>
 
<HEAD>
<TITLE>Fun With Forms - POST</TITLE>
</HEAD>

<BODY>

<P><HR>
	   <FONT FACE="Arial" SIZE="2">
	   		 <B>You could do it similiar to the example in FormDemo.Get, or, we'll do it the easy way in a loop ::</B>   
	   		 <BR>
			 <?php
					 
				$loopCounter=0;
				foreach ($_POST as $x) {
					echo "<br />{$loopCounter} = {$x}";
					$loopCounter++;
				}
			 ?>
			 
	  </FONT>
<HR></P>


<P><HR>
	   <FONT FACE="Arial" SIZE="2">
	   		 <B>Let's put the results into a single variable / string ::</B>   
	   		 <BR><BR>
			 <?php
			 		 
				$loopCounter=0;
				foreach($_POST as $y) {
					if (isset($strMessage))
						$strMessage .= $loopCounter++. "-[ " . $y . "]<br />";
					else 
						$strMessage = $loopCounter++. "-[ " . $y . "]<br />";
				}
			 ?>
			 Message ::<br /> <?php echo $strMessage ?>
	 </FONT>
<HR></P>

<?php
// "Behind the scenes"
// Activate this code if you want to see all your POST variables in readable format
// Useful for debugging!

	echo '<pre>';
	print_r($_POST);
	echo '</pre>';

?>

<a href="FormDemo.php">Back to beginning</a>

</BODY>
</HTML>

