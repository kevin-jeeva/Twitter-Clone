<?php
// This code prevents page caching

	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 	// Date in the past
	header("Pragma: no-cache");
?> 

<?php
// Database Connectivity

	$db_connected = mysql_connect("localhost", "root", "")
		or die("Not connected : " . mysql_error());
	$db_name = "ajaxDemo";
	$db_selected = mysql_select_db($db_name, $db_connected)
		or die("Not selected : " . mysql_error());
?>


<html>
<head>
<title>Ajax Demo</title>

<!-- Required stylesheet 																-->
<link rel="stylesheet" type="text/css" href="../Include/ajaxDemo.css" />

<!-- jQuery is a JavaScript library, used to extend, enhance, and simplify JavaScript. 	-->
<!-- jQuery is accessed by simply including a JavaScript file. 	  		   				-->
<!-- Ref YeSV4.5.30 																	-->
<script type="text/javascript" src="../Include/jquery-1.3.2.min.js"></script>


<script type="text/javascript">	
	
	// STEP.1 -- This function is called when the page loads	
	// jQuery being used - Ref YeSV4.5.40 						

	// Clear the form - Ref YeSV4.6.20
	$(document).ready(	   function( ) {
						   	  // Clear the form (FF caches form data between refreshes by default)
							  // Activate the following code if you want all the form fields to be cleared on load.
							  // Be aware that any values you have initially set in radio buttons will be cleared by this code,
							  // so if you want to use it, you'll have to trap the user selected radio button and assign a value manually!
							  
						   	  // $(':input').each(	 function( ) {
							  //					 	if (this.type != "submit") {
							  //			   			   this.value="";
							  //						}
							  // 					 }
					  		  //				  );

						   	  // Initially hide the "Comment Submitted" message - Ref YeSV4.6.30
						   	  $('#comment_submitted').hide( );

							 }
					);
	// End of jQuery STEP.1
	
</script>	




<script type="text/javascript">	
	
	// STEP.4 -- This JavaScript function will be called when you submit your comment via the form	
	// Ref YeSV4.7.10																				
	function ajaxFormSubmit( ) {
		
		// The $.get function is one utilization of JQuery's ajax capability
		$.get(
			// Parameter 1: the url of the remote script - Ref YeS4.7.30						
			// ajaxServer.php is the code that will insert our data into the appropriate table	
			// STEP.5 -- See the code in this file...											
			"ajaxServer.php", 
			
			// Parameter 2: data sent to the server - Ref YeS4.7.40			
			// The form where you entered your data is called "frmAjax"		
			$("#frmAjax").serializeArray(),
			
			// Parameter 3: the callback function - Ref YeS4.7.50						
			// ie What do you want to do with the data returned from ajaxServer.php?	
			function(data) {
				
				// DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE 	
				// If you're having problems with your ajaxServer page, 															
				// activate the following alert line *and* change parameter 4 below to "html".										
				// alert(data);	
				// DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE	
				
				// Build a comment element to be added to the page - Ref YeS4.7.60			
				var commentDiv = '<div class="user_comment">'
							   + '<p><span class="user_comment_name">'
							   + 'You commented:' 
							   + '</span></p>'
							   + '<p class="user_comment_text">' + data.comment + '</p>'
							   + '<p><br/ ><br /><img src="../Images/stars_rating_03.gif" height=19 width=91 align=right></p>'
							   + '</div>';
				
				// Prepend ("put before") the comment to the appropriate element - Ref YeS4.7.70	
				// So, you're instructing the page to display the <div> you built above 			
				// just before the <div> called "submitted_comments" (see HTML below).				
				$("#submitted_comments").prepend(commentDiv);
				
				// Comment was submitted, so hide "the first" message
				$("#thefirst").hide();
								
			}, 
						
			// Parameter 4:  Type of Data - Ref YeS4.7.80
			"json"
			// DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE 	
			// If you're having problems with your ajaxServer page, 															
			// change the above to "html" and activate the alert(data) found at parameter 3 above.								
			// DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE DEBUG CODE 	
		);
		
		// Comment was submitted, so hide the comment form - Ref YeS4.7.80
		$("#ajaxForm").hide();

		// Show the "thank you" (STEP.8) message using a slideDown animation - Ref YeS4.7.80
		$("#comment_submitted").slideDown("slow");
		
		return false;
	}	
	// End of STEP.4
		
</script>


</head>

<body>

<div id="wrapper"> <!-- These IDs are referenced by various code elements.  Ensure they are unique! --> 

	 <h3>Comments:</h3>

	 <!-- STEP.2 -- Get previous comments (if any) from the database -->
	 <div id="submitted_comments">  <!-- These IDs are referenced by various code elements.  Ensure they are unique! --> 
	 <?php
	 
		  $strSQL = "SELECT name, comment FROM comments ORDER BY id DESC"; 
		  $rsComments = mysql_query($strSQL)
				or die($db_name . " : " . $strSQL . " : " . mysql_error());
		  
		  if ( mysql_num_rows($rsComments) == 0 ) { 
		  	 echo '
					 <div class="user_comment" id="thefirst"> <!-- These IDs are referenced by various code elements.  Ensure they are unique! --> 
					 	    <p>Customer reviews are submitted by consumers like you everyday! 
								  These perspectives are a series of views of the product in different settings 
								  that may help you in your purchasing decisions. 
								  We do not filter reviews based on positive or negative content.</p>
					 </div>
				';
		  
		   }
		   else while ($rowComments = mysql_fetch_array($rsComments)) {
		  		echo '
					 <div class="user_comment">
					 	  <p>Submitted By: <span class="user_comment_name">' . $rowComments['name'] . '</span></p>
						  <p class="user_comment_text">' . $rowComments['comment'] . '</p>
						  <p><br /><br /><img src="../Images/stars_rating_00.gif" height=19 width=91 align=right></p>
					 </div>
				';
		  }
		  
		  mysql_close($db_connected);
	 ?>
	 </div>

	 <!-- STEP.3 -- Enter new comment -->
	 <div id="ajaxForm" > <!-- These IDs are referenced by various code elements.  Ensure they are unique! --> 
	 	  <h3>Submit a Comment:</h3>
		  <form id="frmAjax" name="frmAjax" onsubmit="return ajaxFormSubmit();"> <!-- These IDs are referenced by various code elements.  Ensure they are unique! --> 
		  		<label for="name">Name:</label><br />
				<input type="text" id="name" name="name" value="" size="52" /><br />
				<label for="comment">Comment:</label><br />
				<textarea id="comment" name="comment" cols="40" rows="10"></textarea><br />
				<input type="submit" value="Submit" name="submit" />
		  </form>
	 </div>

	 <!-- STEP.8 -- Confirm receipt of comment -->
	 <p id="comment_submitted">Thank you for your comment.</p> <!-- These IDs are referenced by various code elements.  Ensure they are unique! --> 
	 
</div>

</body>
</html>