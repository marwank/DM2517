<?php
$server = "localhost";
$username = "marwank";
$password = "marwank-xmlpub16";
$database = "marwank";
$mysqli = new mysqli($server, $username, $password, $database);

/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

$uname = $_POST['username'];
$pword = $_POST['password'];
$query = "INSERT INTO users (username, password) VALUES ($uname, $pword)";
/* Create table doesn't return a resultset */
if ($mysqli->query($query) === TRUE) {
    printf("User successfully created.\n");
}
?>
