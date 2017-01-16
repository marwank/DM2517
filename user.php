<?php
include('config.php');
session_start();
if (!isset($_SESSION['username'])) {
    header("location:login.php");
}
$username = $_GET['username'];
?>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <?php
    $sql = "SELECT image from Posts WHERE uid IN
    (SELECT id FROM Users WHERE username = '$username')";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'"/>';
    }
    ?>
</body>
</html>
