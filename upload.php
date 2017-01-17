<?php
include('config.php');
session_start();
if (!isset($_SESSION['username'])) {
    header("location:login.php");
}

if ($_FILES['userimage']['error'] !== UPLOAD_ERR_OK) {
    die("Upload failed with error code " . $_FILES['userimage']['error']);
}

$info = getimagesize($_FILES['userimage']['tmp_name']);
if ($info === FALSE) {
    die("Unable to determine image type of uploaded file");
}

if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
    die("Not a gif/jpeg/png");
}

$fileName = $_FILES['userimage']['name'];
$tmpName = $_FILES['userimage']['tmp_name'];
$fileSize = $_FILES['userimage']['size'];
$fileType = $_FILES['userimage']['type'];
$fp = fopen($tmpName, 'r');
$content = fread($fp, filesize($tmpName));
$content = addslashes($content);
fclose($fp);

$userid = $_SESSION['uid'];
$sql = "INSERT INTO Posts (uid, description, image) VALUES ('$userid', 'Test description', '$content')";
if (mysqli_query($conn, $sql)) {
    header("location: welcome.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

function makeThumbnails($updir, $img, $id)
{
    $thumbnail_width = 134;
    $thumbnail_height = 189;
    $thumb_beforeword = "thumb";
    $arr_image_details = getimagesize("$updir" . $id . '_' . "$img"); // pass id to thumb name
    $original_width = $arr_image_details[0];
    $original_height = $arr_image_details[1];
    if ($original_width > $original_height) {
        $new_width = $thumbnail_width;
        $new_height = intval($original_height * $new_width / $original_width);
    } else {
        $new_height = $thumbnail_height;
        $new_width = intval($original_width * $new_height / $original_height);
    }
    $dest_x = intval(($thumbnail_width - $new_width) / 2);
    $dest_y = intval(($thumbnail_height - $new_height) / 2);
    if ($arr_image_details[2] == IMAGETYPE_GIF) {
        $imgt = "ImageGIF";
        $imgcreatefrom = "ImageCreateFromGIF";
    }
    if ($arr_image_details[2] == IMAGETYPE_JPEG) {
        $imgt = "ImageJPEG";
        $imgcreatefrom = "ImageCreateFromJPEG";
    }
    if ($arr_image_details[2] == IMAGETYPE_PNG) {
        $imgt = "ImagePNG";
        $imgcreatefrom = "ImageCreateFromPNG";
    }
    if ($imgt) {
        $old_image = $imgcreatefrom("$updir" . $id . '_' . "$img");
        $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
        imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
        $imgt($new_image, "$updir" . $id . '_' . "$thumb_beforeword" . "$img");
    }
}

mysqli_close($conn);
?>
