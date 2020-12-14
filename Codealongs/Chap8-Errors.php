<?php
$fh = fopen("Students.txt", "r");
//suppress the errors (hide them)
ini_set("display_errors",0); //modify the php.ini file
error_reporting(E_ERROR);//or E_ALL
try
{
    $result = fwrite($fh, "can't do this coz it's read only"); //return boolean
    if ($result == 0) {throw new Exception("error writing to file");}
    
    echo $resultsd."<BR>";
} 
catch (Exception $ex) {
    
    error_log( "ERROR IN THE FILE ". " ". $ex->getFile()." on the line ".$ex->getLine()." ". $ex->getMessage());
    exit;//stop the execution of the program
}
finally 
{
    fclose($fh);
}



