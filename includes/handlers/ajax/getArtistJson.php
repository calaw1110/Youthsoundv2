<?php
// ajax 非同步請求Artist名字
include "../../config.php";
if (isset($_POST['artistId'])) {
    $artistId = $_POST['artistId'];

    $query = mysqli_query($conn, "SELECT * FROM artists WHERE id ='$artistId'");
    $resultArray = mysqli_fetch_array($query);
    echo json_encode($resultArray);
}
