<?php
include("Student.php");
$s = new Student(1541, "Kevin", 19);
$s->name = "jeeva";
echo $s->age."<BR>";
echo $s->name."<BR>";
$s->SomeMethod();
Student::PrintSchool();//CALL THE STATIC METHOD
PrintDetails($s);

//type-hinting
function PrintDetails(Student $students)
{
    echo $students->name." ".$students->age."<BR>";
}

?>
