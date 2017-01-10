<?php
include('config.php');
session_start();
if (!isset($_SESSION['username'])) {
  header("location:login.php");
}

if ($_FILES['userimage']['error'] !== UPLOAD_ERR_OK) {
    die("Upload failed with error code " . $_FILES['userimage']['error']);
}

$info = getimagesize($_FILES['userimage']['tmp_name']);
if ($info === FALSE) {
    die("Unable to determine image type of uploaded file");
}

if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
    die("Not a gif/jpeg/png");
}

$fileName = $_FILES['userimage']['name'];
$tmpName = $_FILES['userimage']['tmp_name'];
$fileSize = $_FILES['userimage']['size'];
$fileType = $_FILES['userimage']['type'];
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
