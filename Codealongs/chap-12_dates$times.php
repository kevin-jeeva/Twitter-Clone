<?php
//check date makes sure if the date is valid and returns 1 if it is true
$valid = checkdate(2,29,2020);
echo $valid;
setlocale(LC_ALL, "can-EN");
//%A - means day of the week
//%d - day of the month
//%f - full date
//%B -  month
echo strftime("%A, %B %d, %Y")."<BR>";
echo date("F d, Y")."<BR>";

//Times!!
//i means minutes
date_default_timezone_set("America/Halifax");
echo date("h:i:sa")."<BR>";

$dateArray = getdate();
print_r($dateArray);

echo "page was last modified on".date("F d,y,h:i:sa", getlastmod())."<BR>";

$dateTweeted = "2025-10-12 16:00:00";// will come from the database
$now = new DateTime();//current datetime stamp

$tweetime = new DateTime($dateTweeted);
$interval = $now->diff($tweetime);
//echo $interval->format("%d %h %i %s seconds");

if($interval->y > 1) echo $interval->format("%y years")."Ago" ."<BR>";
elseif($interval->y > 0) echo $interval->format("%y year")."<BR>";
elseif($interval->m > 1) echo $interval->format("%m months")."<BR>";
elseif($interval->m > 0) echo $interval->format("%m month")."<BR>";
elseif($interval->d > 1) echo $interval->format("%d days")."<BR>";
elseif($interval->d > 0) echo $interval->format("%d day")."<BR>";
elseif($interval->h > 1) echo $interval->format("%h hours")."<BR>";
elseif($interval->h > 0) echo $interval->format("%h hour")."<BR>";
elseif($interval->i > 1) echo $interval->format("%i minutes")."<BR>";
elseif($interval->i > 0) echo $interval->format("%i minute")."<BR>";
elseif($interval->s > 1) echo $interval->format("%s seconds")."<BR>";
elseif($interval->s > 0) echo $interval->format("%s second")."<BR>";

?>
