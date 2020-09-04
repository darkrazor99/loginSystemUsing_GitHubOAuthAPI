<?php
include 'users.class.php';
class UsersController extends Users{

    public function signUp($username, $name, $password, $accessToken){//things u need to sight up go here
      $this->setUser($username, $name, $password, $accessToken);
    }
    public function getUser($username){
      return $this->getUserbyUsername($username);
    }

    public function canSignup($username){

      $check = $this->getUser($username);
      if(empty($check)){
        return true;
      }
      else{
        return false;
      }
    }
    public function required_validation($field ){
        $count=0;
        foreach ($field as $key => $value) {
          if(empty($value)){
            $error[$count]= "<p>" . $key . " is required </p>";
            $count++;

          }
        }
        return $error;
    }
}
