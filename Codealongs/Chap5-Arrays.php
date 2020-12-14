<?php
session_start();
//echo $_SESSION["name"];
$cities[0] = "Fredericton";
$cities[1] = "Saint John";
$cities[2] = "Moncton";

function sanitize_data(&$val, $key)
{
    echo " values {$val}  key {$key}<BR>";
}
array_walk($cities,"sanitize_data");

$city = next($cities);
echo $city;
echo next($cities);
echo "Current ".current($cities);
echo  prev($cities);
echo  prev($cities);
//easier way
$cities = [5=>"Fredericton","Saint John","Moncton","boston"]; //5=> means "goes to"
echo $cities[6]."Indexed at number six";
//associate array 
//Eg: fredericton is the index and the 60000 is the value
//$population = ["Fredericton" => 60000, "Sain John" => 75000, "Moncton" => 80000];

$population = array("Fredericton" => 60000, "Sain John" => 75000, "Moncton" => 80000);
echo "<BR>";
print_r($population);//prints the array

//2- dimensional array  [ array of arrays ]
$twoDarray = array("jimmy" => array(99 =>"moncton",98,100,500),
                   "Johnny" => array(100,100,99,99),
                    "Kevin" => array(10,20,30,40));
echo "<BR>";
print_r($twoDarray);

//for loop
foreach($twoDarray as $students)
{
   
    echo $students[0]. " ".$students[1]." ".$students[2]."<BR>";
}
echo count($twoDarray);
echo sizeof($twoDarray);

//$myNum = range("A","F");
$myNum = range(1,100);

//print_r(array_reverse($myNum));
echo "<BR>";
print_r(array_flip($myNum));
//print_r($myNum);

//read from a file
$students = file("Students.txt");
print_r($students);
echo "<BR>";
foreach($students as $student)
{
    //List
    // - it is similar to array
    // - assigns multiple variable in one operation
    
    list($name,$city,$num) = explode("|", $student);
    echo $name." ".$city." ".$num."<BR>";
}
array_unshift($myNum,200);// add to the beginning of the array
array_push($myNum,500);//add to the end of the array
array_shift($myNum);//remove the element from the beginning of the array
array_pop($myNum);//remove from the end of the array
print_r($myNum);
echo "<BR>";

if(in_array("Moncton", $cities))// this is going to determine if an element exist in the array
{
    echo "Found"." ". "<BR>";
}
else
{
    echo "Not found";
}

sort($cities);
print_r($cities);
sort($cities,SORT_NATURAL);
natcasesort($cities);
print_r($cities);

echo "<BR>";

$newArr = array("Best1","Test2","Test10","Test22");
sort($newArr,SORT_NATURAL);
print_r($newArr);
echo "<BR>";

$mergedArray = array_merge($cities,$newArr);
sort($mergedArray,SORT_NATURAL);
print_r($mergedArray);
echo "<BR>";

