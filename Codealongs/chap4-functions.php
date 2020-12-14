<?php

//type hinting will throw an exception if the type doesnot match

//this is function
function Addnumber(int $x,int $y)
{
  return $x + $y;   
}
echo Addnumber(15,5)."<br>";
//echo Addnumber("Kevin", "Jeeva");
echo rand(1,6)."<BR>";
echo getrandmax()."<BR>";
echo rand(getrandmax(),5)."<BR>";


function PrintMessage(&$x)
{
    $x = "bonjour";
    echo $x."<br>";
}

$message = "Hello world";
PrintMessage($message);
echo $message;

//this is recursive function - the function call itself
function factorial($n)
{
   return ($n == 1) ? 1:$n * factorial($n -1);
      /*if($n == 1)
      {
          return 1;
      }
       else 
      {
      return $n * factorial($n - 1);
      }*/
   
}

echo factorial(10);
?>


