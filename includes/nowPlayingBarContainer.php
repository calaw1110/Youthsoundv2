<?php
$songQuery = mysqli_query($conn, "SELECT * FROM songs ORDER BY RAND() LIMIT 10");
$resultArray = array(); //create array
while ($row = mysqli_fetch_array($songQuery)) {
    array_push($resultArray, $row['id']);
}
$jsonArray = json_encode($resultArray);
?>
<script>
    $(function() {
        var newPlaylist = <?php echo $jsonArray; ?>; //撥放清單
        audioElement = new Audio();
        // audioElement.setAttribute();
        setTrack(newPlaylist[0], newPlaylist, false);

        updateVolumeProgressBar(audioElement.audio); //預設音量條

        //整個container 先套用事件預防 再針對需要使用的事件以及位置撰寫事件功能，事件只會在對的地方發生
        $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e) {
            e.preventDefault(); //防止事件發生相對應的行為  -> 不會被highlight 也不會觸發其他事件
        })
        //處理時間軸拖拉
        //滑鼠按下事件
        $('.playbackBar .progressBar').mousedown(function() {
            mouseDown = true;
        })
        //e 指的是事件   mousemove 滑鼠移動事件
        $('.playbackBar .progressBar').mousemove(function(e) {
            if (mouseDown == true) {
                //依據滑鼠拉的長度 來改變撥放時間
                timeFromOffest(e, this);
                //this = .playbackBar .progressBar
            }
        })
        //滑鼠放開事件
        $('.playbackBar .progressBar').mouseup(function(e) {
            timeFromOffest(e, this);
            //this = .playbackBar .progressBar
        })

        //處理拖拉音量軸
        $('.volumeBar .progressBar').mousedown(function() {
            mouseDown = true;
        })
        //e 指的是事件   mousemove 滑鼠移動事件
        $('.volumeBar .progressBar').mousemove(function(e) {
            if (mouseDown == true) {
                var percentage = e.offsetX / $(this).width();
                if (percentage >= 0 && percentage <= 1) {
                    audioElement.audio.volume = percentage
                }
            }
        })
        //滑鼠放開事件
        $('.volumeBar .progressBar').mouseup(function(e) {
            var percentage = e.offsetX / $(this).width();
            audioElement.audio.volume = percentage
        })
        $(document).mouseup(function() {
            mouseDown = false;
        })
    })
    //取得播放清單  賦予 撥放器功能
    function setTrack(trackId, newPlaylist, play) {
        if (newPlaylist != currentPlaylist) {
            currentPlaylist = newPlaylist;
            shufflePlaylist = currentPlaylist.slice(); // slice() ARRAY 存放進另外一個變數
            shuffleArray(shufflePlaylist);
        }
        if (shuffle == true) {
            // 隨機歌單
            currentIndex = shufflePlaylist.indexOf(trackId);
        } else {
            // 關閉隨機功能
            //回歸正常撥放順序
            currentIndex = currentPlaylist.indexOf(trackId);
        }
        //indexOf() 尋找(內的值)出現在的位置 沒有則回傳-1
        // ex: 1:a 2:b 3:c  where =  indexOf(c) = 3   or where =indexOf(d)=-1
        currentIndex = currentPlaylist.indexOf(trackId)
        pauseSong();
        //取得音檔位置來播放
        // $.post("URL ",{songId : trackId}, function(data){ } );
        $.post("includes/handlers/ajax/getSongJson.php", {
            songId: trackId
        }, function(data) {
            // JSON.parse 將傳進來的json格式資料轉換成js 物件形式
            var track = JSON.parse(data);
            // console.log("nowPlayingBarContainer 裡的測試");
            //data test
            // console.log(track);
            //取得歌曲名稱
            $(".trackName span").text(track.title);

            //ajax取得演唱者名稱
            $.post("includes/handlers/ajax/getArtistJson.php", {
                artistId: track.artist
            }, function(data) {
                //轉JSON格式
                var artist = JSON.parse(data);
                //將歌手名字傳進撥放器
                $(".trackInfo .artisName span").text(artist.name)
                //用歌手名字做歌手連結 展示所有歌曲 專輯
                $(".trackInfo .artisName span").attr("onclick", "openPage('artist.php?id=" +
                    artist.id + "')");
            });
            //取得專輯資訊
            $.post("includes/handlers/ajax/getAlbumJson.php", {
                albumId: track.album
            }, function(data) {
                //將專輯資訊轉換成JSON格式
                var album = JSON.parse(data);
                //check data
                // console.log(album);
                // console.log("nowPlayingBarContainer 裡的測試 結束");
                //將專輯圖片傳入撥放器
                $(".content .albumLink img").attr("src", album.artworkPath);
                //用圖片做專輯連結 use ajax
                $(".content .albumLink img").attr("onclick", "openPage('album.php?id=" +
                    album.id + "')");
                //用歌名做連結到專輯
                $(".trackInfo .trackName span").attr("onclick", "openPage('album.php?id=" +
                    album.id + "')");
            });
            audioElement.setTrack(track);
            if (play == true) {
                playSong();
            }
        });


    }

    function timeFromOffest(mouse, progressBar) {
        //取得拖拉移動的變化量
        var percentage = mouse.offsetX / $(progressBar).width() * 100;
        //根據變化量去計算對應的時間
        var seconds = audioElement.audio.duration * (percentage / 100);
        //呼叫function 來更改 目前撥放時間
        audioElement.setTime(seconds)
    }

    function playSong() {
        //呼叫撥放計數器
        if (audioElement.audio.currentTime == 0) {
            $.post("includes/handlers/ajax/updatePlay.php", {
                songId: audioElement.currentlyPlaying.id
            });
        }

        $(".controlBtn.play").hide();
        $(".controlBtn.pause").show();
        audioElement.play();
    }

    function pauseSong() {
        $(".controlBtn.pause").hide();
        $(".controlBtn.play").show();
        audioElement.pause();
    }

    function nextSong() {
        if (repeat == true) {
            audioElement.setTime(0);
            playSong();
            return
        }
        // array -1
        if (currentIndex == currentPlaylist.length - 1) {
            //最後一首歌曲的下一首回到第一首
            currentIndex = 0;
        } else {
            currentIndex++;
        }
        var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
        setTrack(trackToPlay, currentPlaylist, true);
    }

    function prevSong() {
        if (currentIndex == 0 || audioElement.audio.currentTime >= 3) {
            //第一首歌的上一首 回到最後一首
            audioElement.setTime(0);
        } else {
            currentIndex--;
            var trackToPlay = currentPlaylist[currentIndex];
            setTrack(trackToPlay, currentPlaylist, true);
        }
    }

    function setRepeat() {
        // script.js line 5
        repeat = !repeat;
        var imageName = repeat ? "repeat-active.png" : "repeat.png";
        $(".controlBtn.repeat img").attr("src", "assets/images/icons/" + imageName);
    }

    function setVolumeProgressBar(num) {

        // 不會跟著音量變動或是禁音變動
        $(".volumeBar .progress").css("width", num * 100 + "%");
    }

    function setMute() {
        var save_volume = audioElement.audio.volume;
        if (audioElement.audio.muted == false) {
            //set muted=true
            //ToDo
            setVolumeProgressBar(0);
            audioElement.audio.muted = true
        } else {
            //set muted = false
            //ToDo
            setVolumeProgressBar(save_volume)
            audioElement.audio.muted = false
        }
        var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
        $(".controlBtn.volume img").attr("src", "assets/images/icons/" + imageName);
    }
    //陣列隨機
    function shuffleArray(a) {
        var j, x, i;
        for (i = a.length - 1; i > 0; i--) {
            j = Math.floor(Math.random() * (i + 1));
            x = a[i];
            a[i] = a[j];
            a[j] = x;
        }
        return a;
    }

    function setShuffle() {
        shuffle = !shuffle;
        var imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
        $(".controlBtn.shuffle img").attr("src", "assets/images/icons/" + imageName);
        //隨機撥放功能
        if (shuffle == true) {
            // 隨機歌單
            shuffleArray(shufflePlaylist);
            currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
        } else {
            // 關閉隨機功能
            //回歸正常撥放順序
            currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
        }
        // console.log(shufflePlaylist);
        // console.log(currentPlaylist);
    }
</script>
<div id="nowPlayingBarContainer">
    <!-- 音樂撥放器 -->
    <div id="nowPlayingBar">
        <!-- 左區塊 放專輯圖片 歌名跟演唱者 -->
        <div id="nowPlayingLeft">
            <div class="content">
                <!-- 專輯圖片 -->
                <span class="albumLink"><img role="link" tabindex="0" src="" alt="" /></span>

                <!-- 歌名 -->
                <div class="trackInfo">
                    <span class="trackName">
                        <!-- name of song -->
                        <span role="link" tabindex="0"></span>
                    </span>
                    <!-- 演唱者 -->
                    <span class="artisName">
                        <span role="link" tabindex="0"></span>
                    </span>
                </div>
            </div>
        </div>
        <div id="nowPlayingCenter">
            <!-- 面板控制項 -->
            <div class="content playerControls">
                <div class="buttons">
                    <!-- 控制面板的按鈕 -->
                    <button class="controlBtn shuffle" title="Shuffle button" onclick="setShuffle()">
                        <img src="assets/images/icons/shuffle.png" alt="ShuffleBtn" />
                    </button>
                    <button class="controlBtn previous" title="Previous button" onclick="prevSong()">
                        <img src="assets/images/icons/previous.png" alt="PreviousBtn" />
                    </button>
                    <button class="controlBtn play" title="Play button" onclick="playSong()">
                        <img src="assets/images/icons/play.png" alt="PlayBtn" />
                    </button>
                    <button class="controlBtn pause" title="Pause button" onclick="pauseSong()" style="display: none;">
                        <img src="assets/images/icons/pause.png" alt="PauseBtn" />
                    </button>
                    <button class="controlBtn next" title="Next button" onclick="nextSong()">
                        <img src="assets/images/icons/next.png" alt="NextBtn" />
                    </button>
                    <button class="controlBtn repeat" title="Repeat button" onclick="setRepeat()">
                        <img src="assets/images/icons/repeat.png" alt="RepeatBtn" />
                    </button>
                </div>
                <!-- 撥放器時間軸 -->
                <div class="playbackBar">
                    <!-- 目前時間 -->
                    <span class="progressTime current">0:00</span>
                    <div class="progressBar">
                        <div class="progressBarBg">
                            <div class="progress" id="timeBar"></div>
                        </div>
                    </div>
                    <!-- 剩餘時間 or 總時間 -->
                    <span class="progressTime remaining">0:00</span>
                </div>
            </div>
        </div>
        <div id="nowPlayingRight">
            <!-- 音量相關 -->
            <div class="volumeBar">
                <button class="controlBtn volume" title="Volume Btn
        " onclick="setMute()">
                    <img src="assets/images/icons/volume.png" alt="VolumeBtn" />
                </button>
                <div class="progressBar">
                    <div class="progressBarBg">
                        <div class="progress" id="volumBar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
