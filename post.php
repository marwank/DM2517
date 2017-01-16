<?php
include('config.php');
session_start();
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
    $sql = "SELECT * FROM Posts WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $tag = $_POST['usertag'];
      $sql = "INSERT INTO Tags (pid, tag) VALUES ('$id', '$tag')";
      if (!mysqli_query($conn, $sql)) {
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
    }
}
?>
<html>
<body>
    <?php
    if ($row) {
        echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'"/>';
    }

    if (isset($_SESSION['uid']) && ($_SESSION['uid'] == $row['uid'])) {
        echo '<form action="post.php?id=' . $id . '" method="post" enctype="text/plain">
                Add a tag to your image:
                <input type="text" accept="text/plain" name="usertag" id="usertag">
                <input type="submit" value="Add tag" name="submit">
              </form>';
    }
    ?>
</body>
</html>




<?php
