<?php
function p($myString)
{
    echo $myString." "."<BR>";
}

$students = array("Kevin","Jeeva","Daniel","Jeeva");
$foundStudents = preg_grep("/j/i",$students);//returns an array of mataching elements
print_r($foundStudents);

$myString = "how much wood could a woodchuck chuck";
$result = preg_match("/wood/i", $myString);//only gets the first match
 print_r($result);
 $myarr;
 preg_match_all("/chuck/", $myString,$myarr);// will get all the instance
printf("5s <BR> %s", $myarr[0][0], $myarr[0][1]);

$myStr = "Tuition is $3200";//put slash infront of any special character
p(preg_quote($myStr));

$myString = "how much wood could a woodchuck chuck";//this replace the string with the matching words
$new = preg_replace("/wood/", "good", $myString);
p($new);
$new = preg_filter("/good/", "wood", $myString);//this one does not return anything
p($new);

$myStr = "how|much|wood|could";
$myArr = preg_split("/\|/", $myStr);
print_r($myArr);
echo "<BR>";

p(strlen($myString));//gets the length of the string


//string compare
$str1 = "hello";
$str2 = "Hello";
p(strcasecmp($str1,$str2));//case in-sensesitive

p(strtolower($str2));
p(ucfirst("fredericton"));//make the first_character to the upper case

$myString = "Cafè Française + & ^ % $ ©";
p(htmlentities($myString));

$myString = "Billy .,*/-O'donnel";
echo addslashes($myString)."<BR>";
//For Sprint #3 - mysqli_real_escape_string($con, $myString);
$myString = "Java <BR> is <i>cool<i>";
$myString = strip_tags($myString);
p($myString);
      