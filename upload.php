<?php
$servername = "localhost";
$username = "marwank";
$password = "marwank-xmlpub16";
$dbname = "marwank";
$conn = mysqli_connect($servername, $username, $password, $dbname);

/* check connection */
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
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
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>
