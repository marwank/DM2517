<?php
include('config.php');
session_start();
if ($id = $_GET['id']) {
    // Remove tag
    if ($tag = $_POST['removeTag']) {
        $sql = "DELETE FROM Tags
                WHERE pid = '$id'
                AND tag = '$tag'";
        if (!mysqli_query($conn, $sql)) {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Add tag
    if ($tag = $_POST['addTag']) {
        $sql = "INSERT INTO Tags (pid, tag)
                VALUES ('$id', '$tag')";
        if (!mysqli_query($conn, $sql)) {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Remove comment
    if ($cid = $_POST['removeComment']) {
        $sql = "DELETE FROM Comments
                WHERE id = '$cid'";
        if (!mysqli_query($conn, $sql)) {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Add comment
    if ($comment = $_POST['addComment']) {
        $uid = $_SESSION['uid'];
        $sql = "INSERT INTO Comments (uid, pid, comment)
                VALUES ('$uid', '$id', '$comment')";
        if (!mysqli_query($conn, $sql)) {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Add description
    if ($desc = $_POST['addDescription']) {
        $sql = "UPDATE Posts
                SET description = '$desc'
                WHERE id = '$id'";
        if (!mysqli_query($conn, $sql)) {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    // Feth the post
    $sql = "SELECT *
            FROM Posts
            WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $post = mysqli_fetch_assoc($result);

    // Fetch tags for the post
    $sql = "SELECT *
            FROM Tags
            WHERE pid = '$id'";
    $tags = mysqli_query($conn, $sql);

    // Fetch comments for the post
    $sql = "SELECT Comments.id, uid, username, comment
            FROM Users
            JOIN Comments
            ON Users.id = uid AND pid = '$id'";
    $comments = mysqli_query($conn, $sql);
}
?>
<html>
<body>
    <a href="welcome.php">Home</a>
    <br>
    <?php
    if ($post) {
        echo '<img src="data:image/jpeg;base64,'. base64_encode($post['image']) . '"/>';
        echo '<p> Image description: ' . $post['description'] . '</p>';
        while ($tag = mysqli_fetch_assoc($tags)) {
            echo '<p>' . $tag['tag'] . '</p>';
            if ($_SESSION['uid'] == $post['uid']) {
                echo '<form method="post" action="post.php?id=' . $id . '">
                <input type="hidden" name="removeTag" value="'. $tag['tag'] . '"/>
                <input type="submit" value="Remove"/>
                </form>';
            }
        }

        while ($comment = mysqli_fetch_assoc($comments)) {
            $username = $comment['username'];
            echo '<p> <a href="user.php?username=' . $username . '">' . $username . '</a>: ' . $comment['comment'] . '</p>';
            if ($_SESSION['uid'] == $comment['uid']) {
                echo '<form method="post" action="post.php?id=' . $id . '">
                <input type="hidden" name="removeComment" value="'. $comment['id'] . '"/>
                <input type="submit" value="Remove"/>
                </form>';
            }
        }
    }

    if ($_SESSION['uid'] == $post['uid']) {
        echo '<form method="post" action="post.php?id=' . $id . '">
        Add a tag to your image:
        <input type="text" accept="text/plain" name="addTag"/>
        <input type="submit" value="Add tag"/>
        </form>';
        echo '<form method="post" action="post.php?id=' . $id . '">
        Edit the description of your image:
        <input type="text" accept="text/plain" name="addDescription"/>
        <input type="submit" value="Edit description"/>
        </form>';
    }

    if (isset($_SESSION['uid'])) {
        echo '<form method="post" action="post.php?id=' . $id . '">
        Add a comment to this image:
        <input type="text" accept="text/plain" name="addComment"/>
        <input type="submit" value="Add comment" />
        </form>';
    }
    ?>
</body>
</html>
