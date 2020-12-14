<?php

class Student 
{
  private $studentId;
  private $name;
  protected $age; //protected -- accessible to this class and the subclasses
  CONST school = "NBCC";//cannot be overriden, don't use '$' 
  public static $status;
  
  public static function PrintSchool()
  {
      echo "NBCC<BR>";
  }
  
  //THIS IS A FINAL METHOD
  public function SomeMethod()
  {
      echo "THIS METHOD CAN'T BE OVERRIDEN IN THE CHILD CLASSES<BR>";
  }
  
  //THIS IS A CONSTRUCTOR METHOD
  public function __construct($studentId, $name, $age) {
      $this->studentId = $studentId;
      $this->name = $name;
      $this->age = $age;
  }
  
  //DESTRUCT METHOD
  public function __destruct() 
  {
      echo "OBJECT DESTROYED <BR>";
  }
  
  public function __get($name) {
      return $this->$name;
  }
  public function __set($name, $value) {
      $this->$name = $value;
  }
  
  //public abstract function SomeMethod();//abstract method -- placeholder -- used for later use -- no code inside
  
  //GETTERS AND SETTERS
//  public function getStudentId() {
//      //$this is reference to the current object
//      //-> means dereference the pointer (same as '.' -- dot operator)
//      return $this->studentId;
//  }
//
//  public function getName() {
//      return $this->name;
//  }
//
//  public function getAge() {
//      return $this->age;
//  }
//
//  public function setStudentId($studentId) {
//      $this->studentId = $studentId;
//  }
//
//  public function setName($name) {
//      $this->name = $name;
//  }
//
//  public function setAge($age) {
//      $this->age = $age;
//  }


}

?>