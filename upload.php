<?php
include('config.php');
session_start();
if (!isset($_SESSION['username'])) {
  header("location:login.php");
}

$fileName = $_FILES['userfile']['name'];
$tmpName = $_FILES['userfile']['tmp_name'];
$fileSize = $_FILES['userfile']['size'];
$fileType = $_FILES['userfile']['type'];
$fp = fopen($tmpName, 'r');
$content = fread($fp, filesize($tmpName));
$content = addslashes($content);
fclose($fp);

$sql = "INSERT INTO Posts (uid, description, image) VALUES ('3', 'Test description', '$content')";
if (mysqli_query($conn, $sql)) {
    header("location: welcome.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>
