<?php
include('config.php');
session_start();
if ($searchquery = $_GET['searchquery']) {
    $terms = str_replace(" ", "','", $searchquery);
    $sql = "SELECT pid FROM Tags WHERE tag IN ('".$terms."') GROUP BY pid ORDER BY count(pid) DESC;";

    if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $pid = $row['pid'];
            $get_post_query = "SELECT * FROM Posts WHERE id = '$pid'";
            $get_post_result = mysqli_query($conn, $get_post_query);
            $get_post_row = mysqli_fetch_assoc($get_post_result);
            echo '<a href="post.php?id=' . $get_post_row['id'] . '">
            <img width=400px height=300px src="data:image/jpeg;base64,'.base64_encode( $get_post_row['image'] ).'"/>
            </a>';
        }
    } else {
        print("yoo");
    }

}
?>
<h1><a href="welcome.php">Home</a></h1>
