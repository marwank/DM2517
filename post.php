<?php
include('config.php');
session_start();
if ($id = $_GET['id']) {
    if ($tag = $_POST['tag']) {
        $query = "INSERT INTO Tags (pid, tag) VALUES ('$id', '$tag')";
        if (!mysqli_query($conn, $query)) {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    }

    if ($comment = $_POST['comment']) {
        $uid = $_SESSION['uid'];
        $query = "INSERT INTO Comments (uid, pid, content) VALUES ('$uid', '$id', '$comment')";
        if (!mysqli_query($conn, $query)) {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    }

    if ($desc = $_POST['desc']) {
        $query = "UPDATE Posts SET description = '$desc' WHERE id = '$id'";
        if (!mysqli_query($conn, $query)) {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    }

    $sql = "SELECT * FROM Posts WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
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
        echo '<form method="post" action="post.php?id=' . $id . '">
        Add a tag to your image:
        <input type="text" accept="text/plain" name="tag" id="tag"/>
        <input type="submit" value="Add tag"/>
        </form>';
        echo '<form method="post" action="post.php?id=' . $id . '">
        Edit the description of your image:
        <input type="text" accept="text/plain" name="desc" id="desc">
        <input type="submit" value="Edit description">
        </form>';
    }

    if (isset($_SESSION['uid'])) {
        echo '<form method="post" action="post.php?id=' . $id . '">
        Add a comment to this image:
        <input type="text" accept="text/plain" name="comment" id="comment"/>
        <input type="submit" value="Add comment" />
        </form>';
    }
    ?>
</body>
</html>
