<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
?>
<html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Contact Us Page">
    <meta name="author" content="Kevin Daniel">
    <link rel="icon" href="favicon.ico">
    <title>Contact US</title>
    <!-- Bootstrap core CSS -->
    <link href="includes/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="includes/starter-template.css" rel="stylesheet">
	<!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-1.10.2.js" ></script>
	
	<script>
	//just a little jquery to make the textbox appear/disappear like the real Twitter website does
	$(document).ready(function() {
		//hide the submit button on page load
		$("#button").hide();
		$("#tweet_form").submit(function() {
			
			$("#button").hide();
		});
		$("#myTweet").click( function() {			
			this.attributes["rows"].nodeValue = 5;
			$("#button").show();
			
		});//end of click event
		$("#myTweet").blur( function() {			
			this.attributes["rows"].nodeValue = 1;
                        //$("#button").hide();

		});//end of click event
	});//end of ready event handler
    
	</script>
      
        <style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}
.Ctitle{
    font-family: verdana;
    text-align: center;
    font-size: 2em;
    width: 100%;
    padding-top: 0.5em;
    padding-bottom:0.5em;
    
}

tr:nth-child(even) {
  background-color: #99ddff;
}
tr:nth-child(odd) {
  background-color: #e0e0d2;
}
</style>
    </head>
    
    <body>
         <?php 
         include ("connect.php");
         include("includes/Header.php");?>
        <div class = "ContactUsBody">
            <div class = "Ctitle">Contact Information</div>
            <table style="width:100%">
                <tr>
                    <td>Company Name</td>
                    <td>Bitter Organization</td>
                </tr>
                 <tr>
                    <td> Phone Number </td>
                    <td>506-440-4082</td>
                </tr>
                 <tr>
                    <td>Address</td>
                    <td>146 McGibbon Street</td>
                </tr>
                 <tr>
                    <td>Email address</td>
                    <td><a href ="mailto:kevinjeeva1541@gmail.com">Kevinjeeva1541@gmail.com</a></td>
                </tr>
            </table>  
        </div>
    </body>
</html>