<?php

// This PHP page is *called from* ajaxClient.php (STEP.4, Parameter 1) on the CLIENT side.  										
//																																	
// It receives the data you entered in your form via URL parameters. (STEP.4, Parameter 2)											
//																																	
// This page is *executed on* the SERVER side.  So, if "you" (the client) are located in Saint John, and the actual					
// YeS website (the server) is located in California, this page is executed IN California, not IN Saint John.						
//  																																
// This page is not designed to interact with your browser!  It should NOT contain any HTML.  Trying to place HTML into this		
// page will usually cause it to stop working, and you will not receive any indication of that (ie error message, etc).				
//																																	
// Basically then, this page receives data from ajaxClient.php, inserts it into a database table, retrieves it back (to make sure 	
// it's in the table), "encodes" it, and returns it to ajaxClient.php , which then displays it.										
//																																	
															


// Connect to database - Ref YeSV4.8.30
$db = mysqli_connect("localhost", "root", "","ajaxdemo")
		or die(mysql_error());
		
//mysql_select_db("ajaxDemo", $db);

// STEP.6 -- Build an SQL string, insert new comment into the database.												
//																													
// Be VERY CAREFUL building this string... an invalid or misspelled name, 											
// or a missing ' or , will cause this page	to stop working!														
//																													
// Ref YeSV4.8.40 , .50																								
mysqli_query($db, "INSERT INTO comments (name, comment) VALUES ('" 
					. mysqli_real_escape_string($db, $_GET['name']) . 
					"', '" 
					. mysqli_real_escape_string($db, $_GET['comment']) . 
					"')"
			);
			
// Retrieves the ID generated for an AUTO_INCREMENT column by the previous query (usually INSERT). 		
$insert_id = mysqli_insert_id($db);

// Ref YeSV4.8.60 ... Can you SELECT the newly inserted comment?	Proves it was inserted correctly!	
$rs = mysqli_query($db, "SELECT name, comment FROM comments WHERE id={$insert_id}");

// Ref YeSV4.8.70 ... Retrieve the newly inserted comment from recordset, encode into JSON.									
// You don't really need a loop here since only 1 record should be in the recordset.										
// The loop is included only to show you the functionality required for other scenerios that may involve multiple records.	
// In this case, the loop should only execute 1 time.																		
while($row = mysqli_fetch_assoc($rs)) {
	$json_out = json_encode($row);
}

// STEP.7 -- return the JSON data to the ajaxClient.php page, which will display it in STEP.4, Parameter 3.			
// Ref YeSV4.8.80																									
echo $json_out;				
?>