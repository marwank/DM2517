<?php
include("config.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $sql = "SELECT id FROM Users WHERE username = '$username' AND password = '$password'";
  $result = mysqli_query($conn, $sql);
  $count = mysqli_num_rows($result);
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

  if ($count == 1) {
    $_SESSION['uid'] = $row;
    $_SESSION['username'] = $username;
    header("location: welcome.php");
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}
?>
<html>
<body>
  <form action='register.php' method='post' accept-charset='UTF-8'>
    <fieldset>
      <legend>Register</legend>
      <label for='username' >Username:</label>
      <input type='text' name='username' id='username' maxlength="255" />
      <label for='password' >Password:</label>
      <input type='password' name='password' id='password' maxlength="255" />
      <input type='submit' name='Submit' value='Register'/>
    </fieldset>
  </form>
  <form action='login.php' method='post' accept-charset='UTF-8'>
    <fieldset>
      <legend>Login</legend>
      <label for='username' >Username:</label>
      <input type='text' name='username' id='username' maxlength="255" />
      <label for='password' >Password:</label>
      <input type='password' name='password' id='password' maxlength="255" />
      <input type='submit' name='Login' value='Login'/>
    </fieldset>
  </form>
</body>
</html>
