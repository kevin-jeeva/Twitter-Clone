<?php 
session_start();
$userId  = $_SESSION["user_Id"];
?>

<script src="https://code.jquery.com/jquery-3.3.1.js" ></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
$(document).ready(function() {
//hide the submit button on page loadg
$("#button").hide();

$("#message_form").submit(function() {
//alert("submit form");
$("#button").hide();
});
$("#message").focus( function() {
//this will "magically" make the textbox have 5 rows and also
//show the submit button
this.attributes["rows"].nodeValue = 5;
$("#button").show();
});//end of click event

$("#to").keyup(//key up event for the user name textbox

function(e) {
if (e.keyCode === 13) {
//don't do anything if the user types the enter key, it might try to submit the form
return false;
}
jQuery.get(
"User_Search_AJAX.php",
$("#message_form").serializeArray(),
function(data) {//anonymous function
//uncomment this alert for debugging the directMessage_proc.php page
//alert(data);
//clear the users datalist
$("#dlUsers").empty();
//if (typeof(data) === "undefined") {
if (data === "undefined") {
$("#dlUsers").append("<option value='NO USERS FOUND' label='NO USERS FOUND'></option>");
}

$.each(data, function(index, element) {
//this will loop through the JSON array of users and add them to the select box
$("#dlUsers").append("<option value='" + element.name + "' label='" + element.name + "'></option>");
//alert(element.id + " " + element.name);
});
},
//change this to "html" for debugging the UserSearch_AJAX.php page
"json"
);
//make sure the focus stays on the textbox so the user can keep typing
$("#to").focus();
return false;
}
);
});//end of ready event handler

</script>



<form method="post" id="message_form" action="DirectMessage_proc.php">
<div class="form-group">
Send message to: <input type="text" id="to" name="to" list="dlUsers" autocomplete="off"><br>
<datalist id="dlUsers">

</datalist>
<input type="hidden" name="userId" value="<?=$userId?>">

<textarea class="form-control" name="message" id="message" rows="1" placeholder="Enter your message here"></textarea>
<input type="submit" name="button" id="button" value="Send" class="btn btn-primary btn-lg btn-block login-button"/>

</div>
</form>
