<?php
include('config.php');
session_start();
$id = $_GET['id'];
$sql = "SELECT * FROM Posts WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result)
?>
<html>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if ($row) {
            echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'"/>';
        }
    }
    
    if (isset($_SESSION['username'])) {

    }

    ?>
    <form action="post.php" method="post" enctype="text/plain">
        Add a tag to your image:
        <input type="text" accept="text/plain" name="usertag" id="usertag">
        <input type="submit" value="Add tag" name="submit">
    </form>

    <?php

    ?>
</body>
</html>




<?php
