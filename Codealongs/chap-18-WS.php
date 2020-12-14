<?php
$postal = "Y0A0Y0";
$pr = 'AB';
$count = 0;
$url = "http://localhost/includes/fedex/ValidatePostalCodeService/ValidatePostalCodeWebServiceClient.php?"
        ."PostalCode=$postal";
$cobj = curl_init();
curl_setopt_array($cobj, Array(
    CURLOPT_URL            => $url,
    CURLOPT_RETURNTRANSFER => TRUE,
   // CURLOPT_ENCODING       => 'UTF-8'
));
//curl_setopt($cobj,CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($cobj);
echo $data;
$xmlObject = simplexml_load_string($data);
//echo $xmlObject->message;
echo "<script>alert('$xmlObject->message');</script>";



  

/*$format = "json";
$firstName = "Kevin";
$lastName = "Daniel";
$url = "http://localhost/codealongs/myFirstWS.php?"
. "format=$format&fname=$firstName&lname=$lastName";
//curl is the versatile set of libraries that allow php to send/retrieve
//http data
//google and Amazon (AWS) use web services alot
$cobj =curl_init($url);
// the data should return back to here instead of displaying on the screen
curl_setopt($cobj, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($cobj);
if ($format == "json") {
$object = array(json_decode($data));
//echo $object[0];
//echo $object->{"name"};
echo var_dump($object);
}
else {
$xmlObject = simplexml_load_string($data);
echo "the full name is " . $xmlObject->name;
}

echo "<BR><BR>";

//CALL A WEATHER WEB SERVICE
$url = "api.openweathermap.org/data/2.5/weather?q=Fredericton&units=metric&APPID=45bfb762ed60106a45fd68fdcc0848fa";
$client = curl_init($url);
curl_setopt($client,CURLOPT_RETURNTRANSFER,1); //returns not display on the screen;
$data = curl_exec($client);
//echo $data;
$myArray = json_decode($data,true);
print_r($myArray);
echo "<BR>";
echo $myArray["coord"]["lon"]."<BR>";
echo $myArray["coord"]["lat"]."<BR>";
echo "temperature: ".$myArray["main"]["temp"]."<BR>";
curl_close($client);



/*$format = "xml";
$firstName = "Kevin Jeeva";
$lastName = "Daniel";
$url = "http://localhost/codealongs/myFirstWS.php?"
. "format=$format&fname=$firstName&lname=$lastName";
echo $url;
//curl -- client url -- is the versatile set of libraries that allows php to send/retrive http data
//Google and Amazon (AWS) use web services alot
$cobj = curl_init($url);

//the data should return back to here instead of displaying on the screen
curl_setopt($cobj, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($cobj);
echo $data;
if($format == "json")
{
    $object = arrya(json_decode($data));
    //echo $object[0];
   //echo $object->["name"];
    echo var_dump($object);
}
 else     
 {
    // $xmlObject = simplexml_load_string($data);
     //echo "the full name is ".$xmlObject->name;
 }
*/
?>