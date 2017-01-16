<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'marwank');
define('DB_PASSWORD', 'marwank-xmlpub16');
define('DB_DATABASE', 'marwank');
$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

/* check connection */
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
