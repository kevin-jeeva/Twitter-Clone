<?php

// This page is designed to be called from FormDemo.php , so its logic is useless unless you are coming from that page	
// It demonstates how PHP retrieves Cookies.																			

// $_COOKIE is a language construct and is known as a "SUPERGLOBAL" , and is an array
// The "$" denotes a variable
// Variables do not need to be declared in PHP
// PHP automatically determines the data type

// Look for a cookie named FirstName, and put its value into the variable $strFirstName
$strFirstName = $_COOKIE['FirstName'];

$strLastName  = $_COOKIE['LastName'];
$strLanguage  = $_COOKIE['Language'];
$strCourse 	  = $_COOKIE['Course'];

// isset() can be used to check if something exists before trying to use it, otherwise you'll invoke an error.
// Of course, ***good programming habits*** dictate you should always do this, even if you don't think
// you have to.  For example, I would implement the isset() shown below in the above code as well.

// To see what happens when things go wrong, change the above firstname to firstnameX and rerun FormDemo

// Recognize the conditional assignment?
// This is saying "If CPP exists, put its value into variable $strCPP.  Oterwise, put "no" into $strCPP"
$strCPP 	  		= isset($_COOKIE['CPP'])		 	?		$_COOKIE['CPP']  	 	 	: "no";

$strVisualBasic 	= isset($_COOKIE['VisualBasic'])	?		$_COOKIE['VisualBasic'] 	: "no";
$strPHP 			= isset($_COOKIE['PHP'])			?		$_COOKIE['PHP']			 	: "no";
$strJava 			= isset($_COOKIE['Java'])		 	?		$_COOKIE['Java']		 	: "no";
$strOracle 			= isset($_COOKIE['Oracle'])	 		?		$_COOKIE['Oracle']			: "no";
$strHex 			= isset($_COOKIE['Hex'])		 	?		$_COOKIE['Hex']		 		: "no";

?>


<html>
 
<head>

<title>Fun with Forms - Cookies</title>

</head>

<body>

<!-- Description of FORM tag :: -->
<!-- NAME needs to be unique.  -->
<!-- ACTION tells form what page it goes to when form is submitted.  -->
<form name="myForm3" action="formdemo.php">
<table border="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="500" bgcolor="#0033cc">
<tr>
	<td bgcolor="#666666"> 
		<table border="1" cellpadding="3" style="border-collapse: collapse" bordercolor="#cccccc" width="500" bgcolor="#ffffff" height="142">
		   
		   <tr>
		   	   <td width="500" height="18" colspan="2"> 
			   	   <p align="center"><font size="2" face="arial black" color="#666666">Fun with Forms - Controls Seeded From Cookies<br>( PHP Version )</font></p>
			   </td>
		   </tr>
		   
		   <tr>		   	   
		   	   <td width="250" height="38">
			   	   <font size="2" face="arial">First Name<br></font>
				   <font face="arial">
				   		<input type="text" name="firstname" size="30" maxlength="20" value=<?php echo $strFirstName; ?>>
				   </font>
			   </td>
			   <td width="250" height="38">
			   	   <font size="2" face="arial">Last Name<br></font>
				   <font face="arial"> 
				   		 <input type="text" name="lastname" size="30" maxlength="20" value=<?php echo $strLastName ?> >
				   </font>
			   </td>
		  </tr>
		  
		  <tr>
		  	  <td width="250" height="38">
			  	  <font size="2" face="arial">Language Preference<br></font>
				  <font face="arial">
				  		<input type="radio"  name="language" value="English" <?php echo ($strLanguage=='English')?('CHECKED="CHECKED"'):('') ?> >
				  </font>
				  <font size="2" face="arial"> English&nbsp; </font>
				  <font face="arial"> 
				  		<input type="radio" name="language" value="Français" <?php echo ($strLanguage=='Français')?('CHECKED="CHECKED"'):('') ?> >
				  </font>
				  <font size="2" face="arial"> Français&nbsp; </font>
				  <font face="arial">
				  		<input type="radio" name="language" value="Español" <?php  echo ($strLanguage=='Español')?('CHECKED="CHECKED"'):('') ?> >
				  </font>
				  <font size="2" face="arial">Español</font>
			  </td>
			  <td width="250" height="38">
			  	  <font size="2" face="arial">Favorite Course<br></font>
				  <font face="arial"> 
				  		<select size="1" name="course"> 
							<?php 
								// I'll do this part a bit differently to demo some language constructs
								for ($i=0; $i<6; $i++) {
									echo "<OPTION";
									if ($strCourse==$i) 
										echo ' selected="yes"';
									echo ">";
									switch ($i) {
										case 0:
											echo "ServerSide Websites";
											break;
										case 1:
											echo "Ethics";
											break;
										case 2:
											echo "ISDP";
											break;
										case 3:
											echo "Technical Writing";
											break;
										case 4:
											echo "Unix";
											break;
										default:
											echo "Whatever I'm Passing";
											break;
										
									}
									echo "</OPTION>";
								}
							
							?>
						</select>
				  </font> 
			  </td>
		</tr>
		
		<tr>
			<td width="500" height="36" colspan="2">
				<font size="2" face="arial">
				  &nbsp;Preferred Computer Languages ::<br>
				  <input type="checkbox" name="cpp" value="cpp" <?php if($strCPP=="yes") echo 'Checked="CHECKED"'; ?> > C++&nbsp;
				  <input type="checkbox" name="visualbasic" value="visualbasic" <?php if($strVisualBasic=="yes") echo 'Checked="CHECKED"'; ?>  > Visual Basic&nbsp;
				  <input type="checkbox" name="cobol" value="php" <?php if($strPHP=="yes") echo 'Checked="CHECKED"'; ?> > PHP&nbsp;
				  <input type="checkbox" name="java" value="java" <?php if($strJava=="yes") echo 'Checked="CHECKED"'; ?> > Java&nbsp;
				  <input type="checkbox" name="oracle" value="oracle" <?php if($strOracle=="yes") echo 'Checked="CHECKED"'; ?> > Oracle&nbsp;
				  <input type="checkbox" name="hex" value="hex" <?php if($strHex=="yes") echo 'Checked="CHECKED"'; ?> > Hex! 
				</font>
			</td>
	   </tr>
	   
	   <tr>
	   	   <td width="250" height="19">&nbsp;</td>
		   <td width="250" height="19">&nbsp;</td>
	  </tr>
	  
	  <tr>
	  	  <td width="250" height="1"><input type="submit" value="submit" name="button1"><br/><font size="2" face="arial"> ( Back to FormDemo PHP Version ) </font></td>
		  <td width="250" height="1"><input type="reset" value="reset" name="button2"></td>
	  </tr>
	  
	  </table>
	  </td>
</tr>
</table>
</form>


<?php
// "Behind the scenes"
// Activate this code if you want to see all your COOKIE variables in readable format
// Useful for debugging!

	echo '<pre>';
	print_r($_COOKIE);
	echo '</pre>';

?>

<a href="FormDemo.Cookies.htm">Do you want to retrieve your cookies using client-side Javascript? ... </a>

</body>
</html>

