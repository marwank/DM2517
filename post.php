<?php
include('config.php');
session_start();
if ($id = $_GET['id']) {
  $sql = "SELECT * FROM Posts WHERE id = '$id'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  if ($desc = $_GET['desc']) {
    $query = "UPDATE Posts SET description = '$desc' WHERE id = '$id'";
    if (!mysqli_query($conn, $query)) {
      echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
  }
  if ($tag = $_GET['tag']) {
    $query = "INSERT INTO Tags (pid, tag) VALUES ('$id', '$tag')";
    if (!mysqli_query($conn, $query)) {
      echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
  }
}
?>
<html>
<body>
  <?php
  if ($row) {
    echo '<img src="data:image/jpeg;base64,'. base64_encode($row['image']) . '"/>';
    echo '<p> Image description: ' . $row['description'] . '</p>';
  }

  if (isset($_SESSION['uid']) && ($_SESSION['uid'] == $row['uid'])) {
    echo '<form action="post.php" method="get">
    Add a tag to your image:
    <input type="text" accept="text/plain" name="tag" id="tag"/>
    <input type="hidden" name="id" value="' . $id . '"/>
    <input type="submit" value="Add tag"/>
    </form>';
    echo '<form action="post.php" method="get">
    Edit the description of your image:
    <input type="text" accept="text/plain" name="desc" id="desc">
    <input type="hidden" name="id" value="' . $id . '"/>
    <input type="submit" value="Edit description">
    </form>';
  }
  ?>
</body>
</html>
