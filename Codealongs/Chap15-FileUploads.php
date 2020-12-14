<?php
//chapter 15 file uploads (used to upload photos in sprint #3)
?>
<form action="chap15_proc.php" method="post" enctype="multipart/form-data">
	Select your image (Must be under 10MB in size): 
	<input type="file" accept="image/*" name="pic"><br><br>
	<input id="button" type="submit" name="submit" value="Submit">
</form>
