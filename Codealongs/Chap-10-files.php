<?php
//absolute paths
$filepath = "c:\PHP\grades.txt";
printf("the size of the file is %s bytes"."<BR>", filesize($filepath));
printf("the name of the file is %s"."<BR>", basename($filepath));
printf("the folder path is  %s <BR>", dirname($filepath));

//relative path
$relPath = "../Images/bell.png";
printf("the size of the file is %s Kilobytes <BR>", round(filesize($relPath)/1024));
echo "absolute path". realpath($relPath);
echo "Disk space remaining ". (disk_free_space("c:")/1024)."<BR>";
echo "Disk total space ".( disk_total_space("c:")/1024)."<BR>";
echo "file last modified ".date("m-d-y h:i:ss a", filemtime($relPath))."<BR>";
echo "last accessedd ".date("m-d-y h:i:ss a", fileatime($relPath))."<BR>";

//open the file
//r means read
//w means write
//x means create
//w+ means read and write
//a means append
//a+ means append and read

//this opens a file and store it in an variable
$myFile = fopen($filepath,"a+");
fwrite($myFile, "Kevin\r\n");
fwrite($myFile,"Jeeva\r\n");
fwrite($myFile, "Write beginning of the text \r\n");
rewind($myFile);//suppose to go to the start of the file

while(!feof($myFile))//not the end of the file
{
     //fgets gets a single line
     //fgetc gets a single character
     echo fgets($myFile)."<BR>";
}

fclose($myFile);
?>

