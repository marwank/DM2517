<?php
include('config.php');
session_start();
?>
<html>
<body>
  <?php
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
    $sql = "SELECT * FROM Posts WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
      echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'"/>';
  }
  ?>
</body>
</html>
