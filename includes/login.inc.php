<?php
  session_start();
  $usercontrl= new UsersController();
  if(isset($_POST["login"])){
    $username = $_POST["username"];
    $password = $_POST["pwd"];
    $field = array(
      'username'=>$username,
      'password'=>$password
      );
    if(empty($username)||empty($password)){
            $message= $usercontrl->required_validation($field);

      }
      else {
          $holder = $usercontrl->getUser($username);
          if($usercontrl->canSignup($username)){
            $message[0]= "wrong credentials <br>" ;
          }
          foreach ($holder as $key => $value) {
            if ($value['login']==$username && password_verify ($password ,$value['password'])) {

              $_SESSION["username"]=$username;
              header("location: home.php");
            }
            else {
                $message[0]= "wrong credentials <br>";
            }

          }
        }
      }
