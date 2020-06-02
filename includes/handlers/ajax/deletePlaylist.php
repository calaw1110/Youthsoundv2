<?php
include "../../config.php";

if (isset($_POST['playlistId'])) {
    $playlistId = $_POST['playlistId'];
    //刪除歌單內的歌曲
    $deletePlaylistSongsQuery = mysqli_query(
        $conn,
        "DELETE FROM playlistsongs WHERE playlistid='$playlistId'"
    );
    //刪除歌單
    $deletePlaylistsQuery = mysqli_query(
        $conn,
        "DELETE FROM playlists WHERE id='$playlistId'"
    );
} else {
    echo "刪除失敗";
}
