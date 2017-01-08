<?php
$server = "http://xml.csc.kth.se/utbildning/kth/kurser/DM2517/xmlpubh11/phpMyAdmin/index.php"
$username = "marwank"
$password = "marwank-xmlpub16"
$database = "marwank"
if (!mysql_connect($server, $username, $password, $database)) {
  error_log("Failed to connect to database!", 0);
}
?>
