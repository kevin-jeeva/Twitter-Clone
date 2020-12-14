
<?php
//this is for sprint 6
$screenName = $_GET["to"]; //grab whatever they typed
GetUsers($screenName);

function GetUsers($screenName) {
//run a DB query to retrieve the users that match the given screenname
//$sql = "select * from users where screen_name like '%$screenName%'
//call the method in your users class!!!!
//loop through the results and build an array
//json_encode the array and return it
$userList[] = array();
$userList[0] = array('id'=> 12345, 'name'=>"Nick", 'username'=>"nicktaggart");
$userList[1] = array('id'=> 12345, 'name'=>"Nickies", 'username'=>"nicktaggart");
$json_data = json_encode($userList);
echo $json_data;

}
?>