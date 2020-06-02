<?php include "includes/includeFiles.php";

if (isset($_GET['id'])) {
    $playlistId = $_GET['id'];
    echo "<script>playlistId='$playlistId'</script>";
} else {
    header("Location:index.php");
}
$playlist = new Playlist($conn, $playlistId); //先實作 Playlist 代入 歌單ID 取得 歌單相關資訊
$owner = new User($conn, $playlist->getOwner()); //實作User 代入歌單擁有者(username)資訊進去
?>
<div class="entityInfo">
    <div class="leftSection">
        <div class="playlistImage">
            <img src="assets/images/icons/playlist.png" alt="">
        </div>
    </div>

    <div class="rightSection">
        <h1><?php echo $playlist->getName(); ?></h1>
        <p>By <?php echo $playlist->getOwner(); ?></p>
        <p>總共有<?php echo $playlist->getNumberOfSongs() ?>首歌</p>
        <button class="button" onclick="deletePlaylist()">刪除歌單</button>
    </div>
</div>

<div class="tracklistContainer">
    <ul class="tracklist">
        <?php
        $songIdArray = $playlist->getSongIds();
        $i = 1;
        foreach ($songIdArray as $songId) {
            $playlistSong = new Song($conn, $songId);
            $songArtist = $playlistSong->getSongArtistId();
            echo "<li class='tracklistRow'>
                            <div class='trackCount'>
                                <img class='play' src='assets/images/icons/play-white.png'
                                onclick='setTrack(\"" . $playlistSong->getSongId() . "\",tempPlaylist,true)'>
                                <span class='trackNumber'>$i</span>
                            </div>
                            <div class='trackInfo'>
                                <span class='trackName'>" . $playlistSong->getSongTitle() . " </span>
                                <span class='artisName'>" . $songArtist->getArtistName() . "</span>
                            </div>
                            <div class='trackOptions'>
                                <input type='hidden' class='songId' value='" . $playlistSong->getSongId() . "'>
                                <img class='optionsBtn' src='assets/images/icons/more.png' onclick='showOptionsMunu(this)'>
                            </div>
                            <div class='trackDuration'>
                                <span class='duration'>" . $playlistSong->getSongDuration() . "</span>
                            </div>

                    </li>";
            $i++;
        }
        ?>
        <script>
            //將songIdArray 回傳時使用json格式 並儲存在tempSongIds 裡面 -> 這張專輯所有的歌的ID
            var tempSongIds = '<?php echo json_encode($songIdArray) ?>'
            // 將tempSongIds 內容轉成對應的物件型式
            tempPlaylist = JSON.parse(tempSongIds);
        </script>
    </ul>
</div>
<nav class="optionsMenu">
    <input type="hidden" class="songId">
    <?php
    echo Playlist::getPlaylistsDropdown($conn, $userLoggedIn->getUsername());
    ?>
    <div class="item" onclick="removeFromPlaylist(this,'<?php echo $playlistId; ?>')">從歌單中刪除</div>
</nav>
