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
    <h1>Welcome <?php echo '<a href="user.php?username=' . $_SESSION['username'] . '">' . $_SESSION['username'] . '</a>'; ?></h1>
    <h2><a href="logout.php">Sign Out</a></h2>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" accept="image/jpeg,image/gif,image/x-png" name="userimage"/>
        <input type="submit" value="Upload Image"/>
    </form>
    <form action="search.php" method="get" enctype="text/plain">
        Search among uploaded images:
        <input type="text" accept="text/plain" name="searchquery"/>
        <input type="submit" value="Search"/>
    </form>
</body>
</html>
