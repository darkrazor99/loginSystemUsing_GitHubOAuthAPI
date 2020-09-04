<?php
include 'users.class.php';
class UsersView extends Users{

  public function welcomeUserByName($name){
    $result= "welcome ". $name;
    return $result;
  }
}
