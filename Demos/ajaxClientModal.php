<?php
// This code prevents page caching

	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 	// Date in the past
	header("Pragma: no-cache");
?> 

<?php
// Database Connectivity
	$db_connected = mysqli_connect("localhost:3308", "root", "", "ajaxdemo")
        or die("Not connected : " . mysql_error());

?>
<html>
<head>
<title>Ajax Modal Demo</title>
<!-- Builds on ajaxClient.php, see it for more extensive comments.  -->

<link rel="stylesheet" type="text/css" href="../Includes/ajaxDemo.css" />

<script type="text/javascript" src="../Includes/jquery-3.3.1.min.js"></script>

<!-- Change #1 - new js file -->
<script type="text/javascript" src="../Includes/jquery.simplemodal.js"></script>

<script type="text/javascript">

	$(document).ready(	function() {
	
		// Activate the following code if you want all the form fields to be cleared on load.
		// Be aware that any values you have initially set in radio buttons will be cleared by this code,
		// so if you want to use it, you'll have to trap the user selected radio button and assign a value manually!
		
		// $(':input').each( function() {
		//		if (this.type != "submit") {
		//			this.value="";
		//		}
		//	}	
		//
		// );

		// Hide the "Comment Received" message
		$("#comment_submitted").hide();
		$("#submit_a_comment").hide();

		// Change #2 - bind modal form to "Submit a comment"
		// Show comment form in modal dialog
		$("#submit_comment_link a").click(function () {
			
			$("#submit_a_comment").modal({
				opacity: 80,
				overlayCss: {backgroundColor:"#CCC"}
				
				// Try un-commenting the following section
				
				
				,onOpen: function (dialog) {
					dialog.overlay.fadeIn('fast', function () {
						dialog.data.hide('slow');
						dialog.container.fadeIn('fast', function () {
							dialog.data.slideDown('slow');
						});
					});
				}
				
				
								
				// Try un-commenting the following section
				
				
				,onClose: function (dialog) {
					dialog.data.fadeOut('fast', function () {
						dialog.container.hide('fast', function () {
							dialog.overlay.slideUp('slow', function () {
								$.modal.close();
							});
						});
					});
				}
				
			});//end modal
			
			return false;
		});
		
		// Change #3 - created a link to close the modal form
		// Attach a function to close the form to the click event
		$("#closeForm").click( function() {
			$.modal.close();
			return false;
		});
	});	
	
	function frmComment_submit() {
		
		// The $.get function is one utilization of JQuery's ajax capability
		$.get(
			// Parameter 1: the url of the remote script
			"ajaxServer.php", 
			
			// Parameter 2: data sent to the server
			$("#frmComment").serializeArray(),
			
			// Parameter 3: the callback function
			function(data) {
				
				// Build a comment element to be added to the page
				var commentDiv = '<div class="user_comment">'
							   + '<p><span class="user_comment_name">'
							   + 'You commented:' 
							   + '</span></p>'
							   + '<p class="user_comment_text">'
							   + data.comment
							   + '</p></div>';
				
				// Change #4 - effects added
				// Prepend the comment to the appropriate element
				$("#previously_submitted_comments").prepend(commentDiv).slideUp("fast").slideDown("slow");
				
				// Comment was submitted, so hide "the first" message
				$("#thefirst").hide();
				
			}, 
			"json"
		);
		
		// Hide the comment form
		$("#submit_a_comment").hide();
		
		// Change #5 - change text rather than hide/show
		$("#submit_comment_link").html("<p id=comment_submitted>Thank you for your comment.</p>");
				
		// Change #6 - close modal after form submission		
		// Simple-modal
		$.modal.close();
		return false;
	}
		
</script>
</head>

<body>

<div id="wrapper">

	<h3>Comments:</h3>

	<div id="previously_submitted_comments">

		<?php						
			$strSQL = "SELECT name, comment FROM comments ORDER BY id DESC"; 
			$rsComments = mysqli_query($db_connected, $strSQL)
				or die($db_name . " : " . $strSQL . " : " . mysql_error());
			
			if (mysqli_num_rows($rsComments) == 0) {
					 echo '
							 <div class="user_comment" id="thefirst">
								  <p>Customer reviews are submitted by consumers like you everyday! 
								  These perspectives are a series of views of the product in different settings 
								  that may help you in your purchasing decisions. 
								  We do not filter reviews based on positive or negative content.</p>
							 </div>
						';
				  
				   }
				   else while ($rowComments = mysqli_fetch_array($rsComments)) {
						echo '
							 <div class="user_comment">
								  <p>Submitted By: <span class="user_comment_name">' . $rowComments['name'] . '</span></p>
								  <p class="user_comment_text">' . $rowComments['comment'] . '</p>
							 </div>
						';
				  }
			
			mysqli_close($db_connected);
		?>

	</div>
	
	<div id="submit_a_comment" >
		<h3>Submit a Comment:</h3>
		<form id="frmComment" name="frmComment" onsubmit="return frmComment_submit();">
			<label for="name">Name:</label><br />
			<input type="text" id="name" name="name" value="" size="52" /><br />
			<label for="comment">Comment:</label><br />
			<textarea id="comment" name="comment" cols="40" rows="10"></textarea><br />
			<input type="submit" value="Submit" name="submit" />
			<a href="#" id="closeForm" style="position: absolute; right: 15px;">[Close/Cancel]</a>
		</form>
	</div>

	<!-- Change #7 - added/removed some small stuff -->
	<br /><br />
	<p id="submit_comment_link"><a href="#" >Submit a comment!</a></p>
	
</div>

</body>
</html>