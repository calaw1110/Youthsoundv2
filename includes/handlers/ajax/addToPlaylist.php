<?php
include "../../config.php";
if (isset($_POST['playlistId']) && isset($_POST['songId'])) {
    $playlistId = $_POST['playlistId'];
    $songId = $_POST['songId'];
    //SQL MAX()找到最大值
    $orderIdQuery = mysqli_query($conn, "SELECT  IFNULL(MAX(playlistOrder) + 1,1) AS playlistOrder FROM playlistSongs  WHERE playlistId='$playlistId'");

    $row = mysqli_fetch_array($orderIdQuery);
    $order = $row['playlistOrder'];

    $query = mysqli_query($conn, "INSERT INTO playlistSongs(songId,playlistId,playlistOrder) VALUES($songId,$playlistId,$order)");
} else {
    echo "加入歌單失敗";
}
