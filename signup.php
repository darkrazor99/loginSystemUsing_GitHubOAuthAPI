<?php
include 'classes/userscontroller.class.php';
// Needed values according to the github oauth Api doc
define('OAUTH2_CLIENT_ID', '9e60c5fbf378a68f460f');
define('OAUTH2_CLIENT_SECRET', 'e3d8899490f36e1d3819d5be09ee08faadc9bbb9');
define('APP_NAME','test');

$authorizeURL = 'https://github.com/login/oauth/authorize';
$tokenURL = 'https://github.com/login/oauth/access_token';
$apiURLBase = 'https://api.github.com';

session_start();


// Start the login process by sending the user to Github's authorization page
if(get('action') == 'signup') {
  // Generate a random hash and store in the session for security
  $_SESSION['state'] = hash('sha256', microtime(TRUE).rand().$_SERVER['REMOTE_ADDR']);
  unset($_SESSION['access_token']);
  $params = array(
    'client_id' => OAUTH2_CLIENT_ID,
    'redirect_uri' => "http".'://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'],
    'scope' => 'user',
    'state' => $_SESSION['state']
  );
  // Redirect the user to Github's authorization page
  header('Location: ' . $authorizeURL . '?' . http_build_query($params));
  die();
}

// When Github redirects the user back here, there will be a "code" and "state" parameter in the query string
if(get('code')) {
  // Verify the state matches our stored state
  if(!get('state') || $_SESSION['state'] != get('state')) {
    header('Location:  loginprepare.php');
    die();
  }
  // Exchange the auth code for a token
  $token = apiRequest($tokenURL, array(
    'client_id' => OAUTH2_CLIENT_ID,
    'client_secret' => OAUTH2_CLIENT_SECRET,
    'redirect_uri' => "http". '://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'],
    'state' => $_SESSION['state'],
    'User-Agent' => APP_NAME,
    'code' => get('code')
  ));
  $_SESSION['access_token'] = $token->access_token;
  header('Location: ' . $_SERVER['PHP_SELF']);
}

if(session('access_token')) {
  $response = apiRequest($apiURLBase. '/user');
  $usercontrl = new UsersController();
  if($usercontrl->canSignup($response->login)){
    echo '<h3>please enter the password you will be using for this wepsite</h3>';
    echo '<br>';
    echo '<form  method="post">';
    echo '<label>password</label>';
    echo '<input type="password" name="pwd" value="">';
    echo '<button type="submit" name="signup">signup</button>';
    echo '</form>';
    if(isset($_POST["signup"])){
      $hashed_PWD = password_hash($_POST['pwd'],PASSWORD_DEFAULT);
      $usercontrl->signUp($response->login, $response->name, $hashed_PWD, session('access_token'));
      $_SESSION['username']=$response->login;
      header("location: home.php");
    }
  }
  else {
      echo "already signed up";
      echo '<p><a href="loginprepare.php">login</a></p>';
  }

}
  else {
    header("location: login.php");
}

function apiRequest($url, $post=FALSE, $headers=array())
{
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  if($post)
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  $headers[] = 'Accept: application/json';
  if(session('access_token'))
    $headers[] = 'Authorization: Bearer ' . session('access_token');
    $headers[] = 'User-Agent:' . APP_NAME;
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  $response = curl_exec($ch);
  return json_decode($response);
}

function get($key, $default=NULL)
{
  return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
}

function session($key, $default=NULL)
{
  return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
}
