<?php

  class Dbh{
    //change these values to match the data base used later
    //what iam using is xxamp so here are the defults
    private $host ="localhost";
    private $user ="root";
    private $pwd ="";
    private $dbName ="test";//  make a data base and name it here

    protected function connect(){
      $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;
      $pdo = new PDO($dsn, $this->user, $this->pwd);
      $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);// this makes it so I dont need to add parametars to the fetch() function and I always fetch an array if I want to fetch an object I would have to add a parameter then but I wont.
      return $pdo;
    }

  }
