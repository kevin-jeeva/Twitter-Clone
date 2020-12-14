<html>

<head>

<title>Fun with Forms</title>

<script language="javascript">

	function EditFields(dFn) {
	// dFn represents document."formname"

			// We start optimistically
			var success=true;
			var message="";
			var firsterror="";
			
			// Note! Making a mistake in any fieldname will result in this function returning true! 
			if (dFn.firstname.value == "") {
				// Set focus to the first field that trips an edit 
				if (firsterror == "") firsterror = dFn.firstname;
				// Add to the message list 
				message+="\n    • First name";
			}  
			if (dFn.lastname.value == "") {
				if (firsterror == "") firsterror = dFn.lastname;
				message+="\n    • Last name";
			}		
			// etc.
			
			
			if (message != "" ) {
				alert("Please enter\n" + message);
				firsterror.focus();
				success=false;			
			}
												   
			return success;
	}

	function WriteCookies(dFn) {
	// dFn represents document."formname"		
			
			// Perform edit checks, catch result
			var success=EditFields(dFn);	
			
			// Only write cookies if all edits passed 
			if (success) {
			
				var strExpDate;
				// Make sure this date is in the future
				strExpDate = " path=/; expires=Monday, 31-Dec-2012 12:00:00 GMT;";
			
				// Note! Making a mistake in any fieldname will result in this function returning true! 
				document.cookie = "FirstName=" + dFn.firstname.value + ";" + strExpDate;		
				document.cookie = "LastName=" + dFn.lastname.value + ";" + strExpDate;
						
				if (dFn.language[0].checked)document.cookie = "Language=" + dFn.language[0].value  + ";" + strExpDate;
				if (dFn.language[1].checked)document.cookie = "Language=" + dFn.language[1].value  + ";" + strExpDate;
				if (dFn.language[2].checked)document.cookie = "Language=" + dFn.language[2].value  + ";" + strExpDate;
				
				document.cookie = "Course=" + dFn.course.selectedIndex + ";" + strExpDate;
				
				// Recognize the conditional assignment?
				document.cookie = dFn.CPP.value + ((dFn.CPP.checked)? "=TRUE;":"=FALSE;")+ strExpDate;
				document.cookie = dFn.VisualBasic.value + ((dFn.VisualBasic.checked)? "=TRUE;":"=FALSE;")+ strExpDate;
				document.cookie = dFn.COBOL.value + ((dFn.COBOL.checked)? "=TRUE;":"=FALSE;")+ strExpDate;
				document.cookie = dFn.Java.value + ((dFn.Java.checked)? "=TRUE;":"=FALSE;")+ strExpDate;
				document.cookie = dFn.Oracle.value + ((dFn.Oracle.checked)? "=TRUE;":"=FALSE;")+ strExpDate;
				document.cookie = dFn.Hex.value + ((dFn.Hex.checked)? "=TRUE;":"=FALSE;")+ strExpDate;
				
			}
							
			return success;
	}

</script>


</head>

<body>

<table width="100%">

<tr>
       <td>
	   
<!-- Description of FORM tag :: 																				-->
<!-- Unique NAME is necessary for Javascript function used in the onSubmit event.  								-->
<!-- ONSUBMIT instructs form to call Javascript function.  														-->
<!-- ACTION tells form what page it goes to when form is submitted.  											-->
<!-- ACTION will only be performed if EditFields() returns true 												-->
<!-- METHOD "GET" passes the form elements and their values through URL parameters  							-->
<form name="myForm1" onsubmit="return EditFields(document.myForm1)" action="formdemo.get.php" 
      onreset="return confirm('Do you really want to reset the form?')" method="get">
<!-- Be aware of the fact that any syntax errors you make in EditFields() will result 							-->
<!-- in a "true" condition being returned.  That may confuse you if you are unaware of it!  					-->

<input type="hidden" name="MyHiddenField" value="Surprise!!!"></input>
<!-- Hidden fields are any data you might want to tag along with all the other form data  						-->
<!-- These fields are not entered, or seen by the user 															-->
<!-- It's a great way to pass on data from a previous page to a next page, even if this page doesn't need it 	-->


<table border="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="500" bgcolor="#0033cc">
<tr>
	<td bgcolor="#666666"> 
		<table border="1" cellpadding="3" style="border-collapse: collapse" bordercolor="#cccccc" width="500" bgcolor="#ffffff" height="142">
		   
		   <tr>
		   	   <td width="500" height="18" colspan="2"> 
			   	   <p align="center"><font size="2" face="arial black" color="#666666">myForm1</font></p>
			   </td>
		   </tr>
		   
		   <tr>
		   	  <td width="250" height="38">
			   	   <font size="2" face="arial">First Name<br /></font>
				   <font face="arial">
				   		<input type="text" name="firstname" size="30"  maxlength="20">
				   </font>
			   </td>
			   <td width="250" height="38">
			   	   <font size="2" face="arial">Last Name<br /></font>
				   <font face="arial"> 
				   		 <input type="text" name="lastname" size="30"  maxlength="20">
				   </font>
			   </td>
		  </tr>
		  
		  <tr>
		  	  <td width="250" height="38">
			  	  <font size="2" face="arial">Language Preference<br /></font>
				  <font face="arial">
				  		<input type="radio"  name="language" value="English" >
				  </font>
				  <font size="2" face="arial"> English&nbsp; </font>
				  <font face="arial"> 
				  		<input type="radio" name="language" value="Français">
				  </font>
				  <font size="2" face="arial"> Français&nbsp; </font>
				  <font face="arial">
				  		<input type="radio" name="language" value="Español"  checked="checked" >
				  </font>
				  <font size="2" face="arial">Español</font>
			  </td>
			  <td width="250" height="38">
			  	  <font size="2" face="arial">Favorite Course<br /></font>
				  <font face="arial"> 
				  		<select size="1" name="course"> 
								<option>eCommerce Websites</option>
								<option>COBOL</option>
								<option>ISDP</option>
								<option>Technical Writing</option> 
								<option>Unix</option> 
								<option selected="yes">Whatever I'm Passing</option> 
						</select>
				  </font> 
			  </td>
		</tr>
		
		<tr>
			<td width="500" height="36" colspan="2">
				<font size="2" face="arial">
				  &nbsp;Preferred Computer Languages ::<br />
				  <input type="checkbox" name="CPP" value="C++" checked="checked"> C++&nbsp;
				  <input type="checkbox" name="VisualBasic" value="Visual Basic"> Visual Basic&nbsp;
				  <input type="checkbox" name="COBOL" value="COBOL"> COBOL&nbsp;
				  <input type="checkbox" name="Java" value="Java"> Java&nbsp;
				  <input type="checkbox" name="Oracle" value="Oracle" checked="checked"> Oracle&nbsp;
				  <input type="checkbox" name="Hex" value="Hex"> Hex! 
				</font>
			</td>
	   </tr>
	   
	   <tr>
	   	   <td width="250" height="19">&nbsp;</td>
		   <td width="250" height="19">&nbsp;</td>
	  </tr>
	  
	  <tr>
	  	  <td width="250" height="1"><input type="submit" value="submit" name="button1"> ( Method = Get )</td>
		  <td width="250" height="1"><input type="reset" value="reset" name="button2"></td>
	  </tr>
	  
	  </table>
	  </td>
</tr>
</table>
</form>

</td>
       <td align=right>
	   
<!-- Description of FORM tag :: 																				-->
<!-- Unique NAME is necessary for Javascript function used in the onSubmit event.  								-->
<!-- ONSUBMIT instructs form to call Javascript function.  														-->
<!-- ACTION tells form what page it goes to when form is submitted.  											-->
<!-- ACTION will only be performed if EditFields() returns true 												-->
<!-- METHOD "POST" passes the form elements and their values through local memory instead of URL.  				-->
<form name="myForm2" onsubmit="return EditFields(document.myForm2)" action="formdemo.post.php"  
      onreset="return confirm('Do you really want to reset the form?')" method="post">
<!-- Be aware of the fact that any syntax errors you make in EditFields() will result 							-->
<!-- in a "true" condition being returned.  That may confuse you if you are unaware of it!  					-->

<input type="hidden" name="MyHiddenField" value="Surprise!!!"></input>
<!-- Hidden fields are any data you might want to tag along with all the other form data  						-->
<!-- These fields are not entered, or seen by the user 															-->
<!-- It's a great way to pass on data from a previous page to a next page, even if this page doesn't need it 	-->


<table border="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="500" bgcolor="#0033cc">
<tr>
	<td bgcolor="#666666"> 
		<table border="1" cellpadding="3" style="border-collapse: collapse" bordercolor="#cccccc" width="500" bgcolor="#ffffff" height="142">
		   
		   <tr>
		   	   <td width="500" height="18" colspan="2"> 
			   	   <p align="center"><font size="2" face="arial black" color="#666666">myForm2</font></p>
			   </td>
		   </tr>
		   
		   <tr>		   	   
		   	   <td width="250" height="38">
			   	   <font size="2" face="arial">First Name<br /></font>
				   <font face="arial">
				   		<input type="text" name="firstname" size="30"  maxlength="20" />
				   </font>
			   </td>
			   <td width="250" height="38">
			   	   <font size="2" face="arial">Last Name<br /></font>
				   <font face="arial"> 
				   		 <input type="text" name="lastname" size="30"  maxlength="20" />
				   </font>
			   </td>
		  </tr>
		  
		  <tr>
		  	   <td width="250" height="38">
			  	  <font size="2" face="arial">Language Preference<br /></font>
				  <font face="arial">
				  		<input type="radio"  name="language" value="English" />
				  </font>
				  <font size="2" face="arial"> English&nbsp; </font>
				  <font face="arial"> 
				  		<input type="radio" name="language" value="Français"   checked="checked" />
				  </font>
				  <font size="2" face="arial"> Français&nbsp; </font>
				  <font face="arial">
				  		<input type="radio" name="language" value="Español" />
				  </font>
				  <font size="2" face="arial">Español</font>
			  </td>
			  <td width="250" height="38">
			  	  <font size="2" face="arial">Favorite Course<br /></font>
				  <font face="arial"> 
				  		<select size="1" name="course"> 
								<option>eCommerce Websites</option>
								<option>COBOL</option>
								<option>ISDP</option>
								<option>Technical Writing</option> 
								<option>Unix</option> 
								<option>Whatever I'm Passing</option> 
						</select>
				  </font> 
			  </td>
		</tr>
		
		<tr>
			<td width="500" height="36" colspan="2">
				<font size="2" face="arial">
				  &nbsp;Preferred Computer Languages ::<br />
				  <input type="checkbox" name="CPP" value="C++" /> C++&nbsp;
				  <input type="checkbox" name="VisualBasic" value="Visual Basic" /> Visual Basic&nbsp;
				  <input type="checkbox" name="COBOL" value="COBOL" /> COBOL&nbsp;
				  <input type="checkbox" name="Java" value="Java" /> Java&nbsp;
				  <input type="checkbox" name="Oracle" value="Oracle" /> Oracle&nbsp;
				  <input type="checkbox" name="Hex" value="Hex" /> Hex! 
				</font>
			</td>
	   </tr>
	   
	   <tr>
	   	   <td width="250" height="19">&nbsp;</td>
		   <td width="250" height="19">&nbsp;</td>
	  </tr>
	  
	  <tr>
	  	  <td width="250" height="1"><input type="submit" value="submit" name="button1"> ( Method = Post )</td>
		  <td width="250" height="1"><input type="reset" value="reset" name="button2"></td>
	  </tr>
	  
	  </table>
	  </td>
</tr>
</table>
</form>


</td>
</tr>
<tr>
       <td colspan=2><center>
	   
<!-- Description of FORM tag :: 																				-->
<!-- Unique NAME is necessary for Javascript function used in the onSubmit event.  								-->
<!-- ONSUBMIT instructs form to call Javascript function.  														-->
<!-- ACTION tells form what page it goes to when form is submitted.  											-->
<!-- ACTION will only be performed if WriteCookies() returns true 												-->
<form name="myForm3" onsubmit="return WriteCookies(document.myForm3)" action="formdemo.cookies.php" 
      onreset="return confirm('Do you really want to reset the form?')" >
<!-- Be aware of the fact that any syntax errors you make in WriteCookies() or EditFields() will result 		-->
<!-- in a "true" condition being returned.  That may confuse you if you are unaware of it!  					-->

<input type="hidden" name="myhiddenfield" value="Surprise!!!"></input>
<!-- Hidden fields are any data you might want to tag along with all the other form data 						-->
<!-- These fields are not entered, or seen by the user 															-->
<!-- It's a great way to pass on data from a previous page to a next page, even if this page doesn't need it 	-->


<table border="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="500" bgcolor="#0033cc">
<tr>
	<td bgcolor="#666666"> 
		<table border="1" cellpadding="3" style="border-collapse: collapse" bordercolor="#cccccc" width="500" bgcolor="#ffffff" height="142">
		   
		   <tr>
		   	   <td width="500" height="18" colspan="2"> 
			   	   <p align="center"><font size="2" face="arial black" color="#666666">myForm3</font></p>
			   </td>
		   </tr>
		   
		   <tr>		   	   
		   	   <td width="250" height="38">
			   	   <font size="2" face="arial">First Name<br /></font>
				   <font face="arial">
				   		<input type="text" name="firstname" size="30" maxlength="20">
				   </font>
			   </td>
			   <td width="250" height="38">
			   	   <font size="2" face="arial">Last Name<br /></font>
				   <font face="arial"> 
				   		 <input type="text" name="lastname" size="30" maxlength="20">
				   </font>
			   </td>
		  </tr>
		  
		  <tr>
		  	  <td width="250" height="38">
			  	  <font size="2" face="arial">Language Preference<br /></font>
				  <font face="arial">
				  		<input type="radio"  name="language" value="English" checked="checked" >
				  </font>
				  <font size="2" face="arial"> English&nbsp; </font>
				  <font face="arial"> 
				  		<input type="radio" name="language" value="Français">
				  </font>
				  <font size="2" face="arial"> Français&nbsp; </font>
				  <font face="arial">
				  		<input type="radio" name="language" value="Español">
				  </font>
				  <font size="2" face="arial">Español</font>
			  </td>
			  <td width="250" height="38">
			  	  <font size="2" face="arial">Favorite Course<br /></font>
				  <font face="arial"> 
				  		<select size="1" name="course"> 
								<option>eCommerce Websites</option>
								<option>COBOL</option>
								<option>ISDP</option>
								<option>Technical Writing</option> 
								<option>Unix</option> 
								<option>Whatever I'm Passing</option> 
						</select>
				  </font> 
			  </td>
		</tr>
		
		<tr>
			<td width="500" height="36" colspan="2">
				<font size="2" face="arial">
				  &nbsp;Preferred Computer Languages ::<br />
				  <input type="checkbox" name="CPP" value="CPP"> C++&nbsp;
				  <input type="checkbox" name="VisualBasic" value="VisualBasic"> Visual Basic&nbsp;
				  <input type="checkbox" name="COBOL" value="COBOL"> COBOL&nbsp;
				  <input type="checkbox" name="Java" value="Java"> Java&nbsp;
				  <input type="checkbox" name="Oracle" value="Oracle"> Oracle&nbsp;
				  <input type="checkbox" name="Hex" value="Hex"> Hex! 
				</font>
			</td>
	   </tr>
	   
	   <tr>
	   	   <td width="250" height="19">&nbsp;</td>
		   <td width="250" height="19">&nbsp;</td>
	  </tr>
	  
	  <tr>
	  	  <td width="250" height="1"><input type="submit" value="submit" name="button1"> ( Method = Cookies )</td>
		  <td width="250" height="1"><input type="reset" value="reset" name="button2"></td>
	  </tr>
	  
	  </table>
	  </td>
</tr>
</table>
</form>

	   </center></td>
      
</tr>
</table>

</body>

</html>

