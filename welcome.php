<?php
  include('config.php');
  session_start();
  if (!isset($_SESSION['username'])) {
    header("location:login.php");
  }
?>
<html>
<head>
  <title>Welcome</title>
</head>
<body>
  <h1>Welcome <?php echo $_SESSION['username']; ?></h1>
  <h2><a href="login.php">Sign Out</a></h2>
  <form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" accept="image/jpeg,image/gif,image/x-png" name="userimage" id="userimage">
    <input type="submit" value="Upload Image" name="submit">
  </form>
</body>
</html>
