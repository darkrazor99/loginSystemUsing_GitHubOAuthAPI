<?php
include 'dbh.class.php';
//only interacts with database (model)
class Users extends Dbh{

  protected function getUserbyUsername($username){
    $sql = "SELECT * FROM users WHERE login = ?";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$username]);
    $results = $stmt->fetchAll();
    return $results;
  }
  protected function setUser($username, $name, $password, $accessToken){
    $sql = "INSERT INTO users(login,name,password,accessToken) VALUES(?,?,?,?)";
    $stmt = $this->connect()->prepare($sql);
    $stmt->execute([$username, $name, $password, $accessToken]);

  }
}
