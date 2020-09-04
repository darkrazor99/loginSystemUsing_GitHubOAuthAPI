<?php
  include 'classes/userscontroller.class.php';
  include 'includes/login.inc.php';
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form method="post">
      <label>username</label>
      <input style="margin-bottom: 10px; width: 200px; margin-left: 9px;" type="text" name="username" value="<?php echo (isset($_POST['username']) ? $_POST['username'] : ''); ?>">
      <br>
      <label>password</label>
      <input style="margin-bottom: 10px; width: 200px; margin-left: 10px;" type="password" name="pwd" value="<?php echo (isset($_POST['pwd']) ? $_POST['pwd'] : ''); ?>">
      <br>
      <button type="submit" name="login">login</button>
      <p><a href="signup.php?action=signup">signup with github</a></p>
    </form>

  </body>
</html>
