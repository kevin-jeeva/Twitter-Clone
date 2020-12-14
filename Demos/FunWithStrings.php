<html>
<head>
	<title>Fun with Strings Demo</title>
</head>

<body>

	  <?php
		   
		   // Simple strings
		   // Note the . is used as a concatenation operator!
		   $strS1 = 'Hello';
		   $strS2 = ' Joe1  ';		   
		   echo '1) ' . $strS1 . $strS2 . '<br/><br/>';
		   
		   // An intentional error
		   // I'm trying to display quotes around Joe2... activate the following line of code to see the results.
		   //$strS2 = ' 'Joe2' ';
		   echo '2) ' . $strS1 . $strS2 . '<br/><br/>';


		   // If you want to use quotes *inside* your string, you need to use \' to represent '
		   // Look carefully at the following line of code...
		   $strS2 = ' \'Joe3\' ';
		   echo '3) ' . $strS1 . $strS2 . '<br/><br/>';
		  
		   
		   // Double quotes and single quotes can generally be used interchangably, 
		   // but they have unique characteristics when used with embedded variables.
		   // Look carefully at the differences in the following code, and the different results.
		   
		   echo '4) $strS1 $strS2' . '<br/><br/>';
		   echo "5) $strS1 $strS2" . '<br/><br/>';
		   
		   $intNum1 = 5;
		   echo '6) The value of $intNum1 is $intNum1' . '<br/><br/>';
		   echo '7) The value of $intNum1 is ' . $intNum1 . '<br/><br/>';
		   echo "8) The value of $intNum1 is $intNum1" . '<br/><br/>';
		   
		   // Above, note the differing behaviour of the variable $intNum when it is inside single quotes, 
		   // versus when it is inside double quotes! (see output)
		   
		   echo '<hr>';
		   
		   // Some examples of how to build SQL statements.  There's many different ways!
		   // All examples produce the same results.
		   
		   // Always remember, many times your problem is with invalid SQL syntax, not PHP!!!!
		   
		   // Hardcoded can be useful in some situations
		   // Note how I have to use the \ character to place the required single quotes that SQL expects inside
		   // the single quotes that PHP expects.
		   $strSQL = 'SELECT * FROM SomeTable WHERE SomeField = \'WhatIWant\' ';
		   echo '100) ' . $strSQL . '<br/><br/>';
		   
		   // Hardcoded can be useful in some situations
		   // Note how when I use double quotes for my PHP string, I can use single quotes for my SQL without any additional characters
		   $strSQL = "SELECT * FROM SomeTable WHERE SomeField = 'WhatIWant' ";
		   echo '101) ' . $strSQL . '<br/><br/>';
		   
		   // Often, we'll place what we want into a variable.  That makes things more flexible.
		   // Here, we append what we want into the SQL string.  Note the use of the \ character to resolve the 
		   // PHP single quotes from the SQL single quotes.
		   $strFieldValue = 'WhatIWant';
		   $strSQL = 'SELECT * FROM SomeTable WHERE SomeField = \'' . $strFieldValue . '\'';
		   echo '102) ' . $strSQL . '<br/><br/>';
		   
		   // Here, I use the power of embedded variable names within double quotes
		   $strFieldValue = 'WhatIWant';
		   $strSQL = "SELECT * FROM SomeTable WHERE SomeField = '$strFieldValue'";
		   echo '103) ' . $strSQL . '<br/><br/>';
		   
   		   
	 ?>

		 

</body>
</html>
