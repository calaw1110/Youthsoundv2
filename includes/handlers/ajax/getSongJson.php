<?php
// ajax 非同步請求歌單
include "../../config.php";
if (isset($_POST['songId'])) {
    $songId = $_POST['songId'];

    $query = mysqli_query($conn, "SELECT * FROM songs WHERE id ='$songId'");
    $resultArray = mysqli_fetch_array($query);
    //array->json
    echo json_encode($resultArray);
}
