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

    if (isset($_POST['like']) && isset($_SESSION['uid'])) {
       $uid = $_SESSION['uid'];
       $pid = $_GET['id'];
       $get_previous_value_query = "SELECT value FROM Likes WHERE uid = $uid AND pid = $pid";
       $get_previous_value_result = mysqli_query($conn, $get_previous_value_query);
       if ($get_previous_value_row = mysqli_fetch_assoc($get_previous_value_result)) {
           // user has either liked or disliked this post before
           $previous_value = $get_previous_value_row['value'];
           if ($previous_value == 1) {
               // user has liked the post before
               // unlike it (set value to 0)
               $delete_previous_value = "DELETE FROM Likes WHERE uid = $uid AND pid = $pid";
               if (!mysqli_query($conn, $delete_previous_value)) {
                   echo "Error: " . $delete_previous_value . "<br>" . mysqli_error($conn);
               }
           } else if ($previous_value == -1) {
               // user has disliked the post before
               // like it (set value to 1)
               $set_previous_value_to_1_query = "UPDATE Likes SET value = 1 WHERE uid = $uid AND pid = $pid";
               if (!mysqli_query($conn, $set_previous_value_to_1_query)) {
                   echo "Error: " . $set_previous_value_to_1_query . "<br>" . mysqli_error($conn);
               }
           }
       } else {
           // user hasn't liked or disliked this post before
           // like it (set value to 1)
           $set_previous_value_to_1_query = "INSERT INTO Likes (uid, pid, value) VALUES ('$uid', '$pid', 1)";
           if (!mysqli_query($conn, $set_previous_value_to_1_query)) {
               echo "Error: " . $set_previous_value_to_1_query . "<br>" . mysqli_error($conn);
           }
       }
   }
   if (isset($_POST['dislike']) && isset($_SESSION['uid'])) {
       $uid = $_SESSION['uid'];
       $pid = $_GET['id'];
       $get_previous_value_query = "SELECT value FROM Likes WHERE uid = $uid AND pid = $pid";
       $get_previous_value_result = mysqli_query($conn, $get_previous_value_query);
       if ($get_previous_value_row = mysqli_fetch_assoc($get_previous_value_result)) {
           // user has either liked or disliked this post before
           $previous_value = $get_previous_value_row['value'];
           if ($previous_value == 1) {
               // user has liked the post before
               // dislike it (set value to -1)
               $set_previous_value_to_m1_query = "UPDATE Likes SET value = -1 WHERE uid = $uid AND pid = $pid";
               if (!mysqli_query($conn, $set_previous_value_to_m1_query)) {
                   echo "Error: " . $set_previous_value_to_m1_query . "<br>" . mysqli_error($conn);
               }
           } else if ($previous_value == -1) {
               // user has disliked the post before
               // undislike it (set value to 0)
               $delete_previous_value = "DELETE FROM Likes WHERE uid = $uid AND pid = $pid";
               if (!mysqli_query($conn, $delete_previous_value)) {
                   echo "Error: " . $delete_previous_value . "<br>" . mysqli_error($conn);
               }
           }
       } else {
           // user hasn't liked or disliked this post before
           // dislike it (set value to -1)
           $set_previous_value_to_m1_query = "INSERT INTO Likes (uid, pid, value) VALUES ('$uid', '$pid', 1)";
           if (!mysqli_query($conn, $set_previous_value_to_m1_query)) {
               echo "Error: " . $set_previous_value_to_m1_query . "<br>" . mysqli_error($conn);
           }
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

    // Fetch likes for the post
    $sql = "SELECT COUNT(value)
            AS score
            FROM Likes
            WHERE pid = '$id'
            AND value > 0";
    $result = mysqli_query($conn, $sql);
    $likes = mysqli_fetch_assoc($result);

    // Fetch dislikes for the post
    $sql = "SELECT COUNT(value)
            AS score
            FROM Likes
            WHERE pid = '$id'
            AND value < 0";
    $result = mysqli_query($conn, $sql);
    $dislikes = mysqli_fetch_assoc($result);

    $xml = new SimpleXMLElement('<xml/>');
    $xml->addChild('image', base64_encode($post['image']));
    $likesNode = $xml->addChild('likes');
    $likesNode->addChild('score', $likes['score']);
    $dislikesNode = $xml->addChild('dislikes');
    $dislikesNode->addChild('score', $dislikes['score']);
    if ($_GET['lang'] == 'se') {
        $likesNode->addChild('text', 'Gillningar');
        $dislikesNode->addChild('text', 'Ogillningar');
    } else {
        $likesNode->addChild('text', 'Likes');
        $dislikesNode->addChild('text', 'Dislikes');
    }
}
?>
<html>
<body>
    <h1><a href="welcome.php">Home</a></h1>
    <br>
    <?php
    if ($post) {
        echo '<img src="data:image/jpeg;base64,'. base64_encode($post['image']) . '"/>
        <p> Likes: ' . ($likes['score'] ? $likes['score'] : '0') . '</p>
        <p> Dislikes: ' . ($dislikes['score'] ? $dislikes['score'] : '0') . '</p>
        <p> Image description: ' . $post['description'] . '</p>';
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
      echo '<form method="post" action="post.php?id='.$id.'">
            <input type="submit" value="Like" name="like" />';
      echo '<form method="post" action="post.php?id='.$id.'">
            <input type="submit" value="Dislike" name="dislike" />';
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
