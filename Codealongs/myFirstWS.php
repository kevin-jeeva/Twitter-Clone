<?php
$firstName = $_GET["fname"];
$lastName = $_GET["lname"];
$fullName = $firstName . " " . $lastName;
$format = $_GET["format"]; //XML or JSON

if ($format == "json") {
header("content-type: application/json");
echo json_encode(array("name"=>$fullName));
}
else {
header("content-type: text\xml");
echo "<?xml version=\"1.0\"?>";
echo "<root>";
echo "<name>" . $fullName . "</name>";
echo "</root>";
}

//Return a name
/*$firstName = $_GET["fname"];
$lastName = $_GET["lname"];
$fullName = $firstName.", ".$lastName;

$format = $_GET["format"]; //XML or JSON
if($format == "json")
{
    header("content-type: application/json");
    echo json_encode(array("name"=>$fullName)); 
}
else 
{
    header("content-type: text\xml");
    echo "<?xml version=\"1.0\"?>";
    echo "<root>";
    echo "<name>".$fullName."</name>";
    echo "</root>";
}
//echo $fullName; // return it
*/
