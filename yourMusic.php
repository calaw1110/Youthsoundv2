<?php
include "includes/includeFiles.php";
?>
<div class="playlistsContainer">
    <div class="gridViewContainer">
        <h2>歌單列表</h2>
        <div class="buttonItems">
            <button class="button" onclick="createPlaylist()">建立歌單</button>
        </div>
        <?php
//取得會員帳號
$username = $userLoggedIn->getUsername();
//歌單查詢 SQL
$playlistQuery = mysqli_query($conn, "SELECT * FROM playlists WHERE owner='$username'");
//判斷是否有歌單
//false
if (mysqli_num_rows($playlistQuery) == 0) {
    echo "<span class='noResults'>你沒有任何歌單</span>";
}
//true
while ($row = mysqli_fetch_array($playlistQuery)) {
    $playlist = new Playlist($conn, $row);
    echo "<div class='gridViewItem' role='link' tabindex='0' onclick='openPage(\"playlist.php?id=" . $playlist->getId() . "\")'>
                <div class='playlistImage'>
                    <img src='assets/images/icons/playlist.png'>
                </div>
                <div class='gridViewInfo'>" . $playlist->getName() . "</div>
                </div>";
}
?>
    </div>
</div>
