<?php
include('config.php');
session_start();
if ($id = $_GET['id']) {
    $sql = "SELECT * FROM Posts WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($tag = $_GET['usertag']) {
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
        echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'"/>';
    }

    if (isset($_SESSION['uid']) && ($_SESSION['uid'] == $row['uid'])) {
        echo '<form action="post.php" method="get">
                <input type="hidden" name="id" value="' . $id . '"/>
                Add a tag to your image:
                <input type="text" accept="text/plain" name="usertag" id="usertag"/>
                <input type="submit" value="Add tag"/>
              </form>';
        echo '<form action="post.php?id=' . $id . '" method="post" enctype="text/plain">
                Edit the description of your image:
                <input type="text" accept="text/plain" name="userdesc" id="userdesc">
                <input type="submit" value="Edit description">
              </form>'
    }
    ?>
</body>
</html>
