<?php
  include 'classes/usersview.class.php';
  session_start();
  $userviewer = new UsersView();
  if($_SESSION["username"]!= null){
    echo $userviewer->welcomeUserByName($_SESSION["username"]);
    echo '<form  method="post">';
    echo '<button type="submit" name="logout">logout</button>';
    echo '</form>';

  }
  else {
    header("location: login.php");
  }
  if(isset($_POST["logout"])){
    session_destroy();
    header("location: login.php");
  }
