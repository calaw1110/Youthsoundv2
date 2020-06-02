<?php include("includes/includeFiles.php");

if (isset($_GET['id'])) {
    $albumId = $_GET['id'];
} else {
    header("Location:index.php");
}
$album = new Album($conn, $albumId);
$artist = $album->getAlbumArtist(); //回傳Album實作化
?>
<div class="entityInfo">
    <div class="leftSection">
        <img src="<?php echo $album->getAlbumArtworkPath() ?>" alt=""></div>
    <div class="rightSection">
        <h2><?php echo $album->getAlbumTitle(); ?></h2>
        <p>By <?php echo $artist->getArtistName(); ?></p>
        <p><?php echo "總共有  " . $album->getNumberOfSongs() . "  首" ?></p>
    </div>
</div>

<div class="tracklistContainer">
    <ul class="tracklist">
        <?php
        $songIdArray = $album->getSongIds();
        $i = 1;
        foreach ($songIdArray as $songId) {
            $albumSong = new Song($conn, $songId);
            $albumArtist = $albumSong->getSongArtistId();
            echo "<li class='tracklistRow'>
                            <div class='trackCount'>
                                <img class='play' src='assets/images/icons/play-white.png'
                                onclick='setTrack(\"" . $albumSong->getSongId() . "\",tempPlaylist,true)'>
                                <span class='trackNumber'>$i</span>
                            </div>
                            <div class='trackInfo'>
                                <span class='trackName'>" . $albumSong->getSongTitle() . " </span>
                                <span class='artisName'>" . $albumArtist->getArtistName() . "</span>
                            </div>
                            <div class='trackOptions'>
                                <input type='hidden' class='songId' value='" . $albumSong->getSongId() . "'>
                                <img class='optionsBtn' src='assets/images/icons/more.png' onclick='showOptionsMunu(this)'>
                            </div>
                            <div class='trackDuration'>
                                <span class='duration'>" . $albumSong->getSongDuration() . "</span>
                            </div>

                    </li>";
            $i++;
        }
        ?>
        <script>
            //將songIdArray 回傳時使用json格式 並儲存在tempSongIds 裡面 -> 這張專輯所有的歌的ID
            var tempSongIds = '<?php echo json_encode($songIdArray)  ?>'
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
</nav>
