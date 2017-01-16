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

/*
$sql = "SHOW TABLES";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
// output data of each row
while($row = mysqli_fetch_assoc($result)) {
echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
}
} else {
echo "0 results";
}
*/
$uname = $_POST['username'];
$pword = $_POST['password'];

$sql = "INSERT INTO Users (username, password) VALUES ('$uname', '$pword')";
if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>
