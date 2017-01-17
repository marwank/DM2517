<?php
include('config.php');
session_start();
if ($searchquery = $_GET['searchquery']) {
    $terms = explode(" ", $searchquery);
    $sql = "SELECT pid FROM
                (SELECT pid FROM Tags WHERE tag IN(".implode(',',$terms).")
            GROUP BY pid ORDER BY count(pid) DESC";

    if ($result = mysqli_query($conn, $sql)) {
        print("eyy");
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<a href="post.php?id=' . $row['id'] . '">
            <img src="data:image/jpeg;base64,'.base64_encode( $row['image'] ).'"/>
            </a>';
        }
    } else {
        print("yoo");
    }

}
?>
