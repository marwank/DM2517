<?php
include('config.php');
session_start();
$username = $_GET['username'];
?>
<html>
<head>
    <title>Welcome</title>
</head>
<body>
    <h1><a href="welcome.php">Home</a></h1>
    <?php
    $sql = "SELECT id, image from Posts WHERE uid IN
    (SELECT id FROM Users WHERE username = '$username')";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<a href="post.php?id=' . $row['id'] . '">
        <img width=400px height=300px src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'"/>
        </a>';
    }
    ?>
</body>
</html>
