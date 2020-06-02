<?php
include("includes/includeFiles.php");
if (isset($_GET['id'])) {
    $artistId = $_GET['id'];
} else {
    header("Location:index.php");
}
$artist = new Artist($conn, $artistId);
?>
<div class="entityInfo borderBottom">
    <div class="centerSection">
        <div class="artistInfo">
            <h1 class="artistName">
                <?php echo $artist->getArtistName(); ?>
            </h1>
            <div class="headerButtons">
                <button class="button" onclick="playFirstSong();">PLAY</button>
            </div>
        </div>
    </div>
</div>

<div class="tracklistContainer borderBottom">
    <h2>Songs</h2>
    <ul class="tracklist">
        <?php
        $songIdArray = $artist->getSongIds();
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
<div class="gridViewContainer">
    <h2>Albums</h2>
    <?php
    $sql = "SELECT * FROM albums WHERE artist ='$artistId'";
    $albumQuery = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_array($albumQuery)) {
        echo "<div class='gridViewItem'>
                  <span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . " \")'>
                      <img src='" . $row['artworkPath'] . "' alt=''>
                      <div class='gridViewInfo'>" . $row['title'] . "
                      </div>
                  </span>
              </div>";
    }
    ?>
</div>
<nav class="optionsMenu">
    <input type="hidden" class="songId">
    <?php
    echo Playlist::getPlaylistsDropdown($conn, $userLoggedIn->getUsername());
    ?>
</nav>
