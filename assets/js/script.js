var currentPlaylist = [];
var shufflePlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseDown = false; //呼滑鼠"按住"事件
var currentIndex = 0;
var repeat = false;//重複狀態
var shuffle = false;//隨機狀態
var userLoggedIn;//登入記錄
var timer;//設定執行時間
var playlistId;//記錄歌單id


$(document).click(function(click){
    var target=$(click.target);

    //hasClass("") 檢測元素是否有被分配到這個class
    if(!target.hasClass("item")  &&  !target.hasClass("optionsBtn")){
        hideOptionsMenu();
    }
})
$(window).scroll(function(){
    hideOptionsMenu();
});
//監聽select.playlist 是否有變化
$(document).on("change","select.playlist",function(){
    var select=$(this);
    var playlistId =select.val();

    //取得songId
    // 做法:
    //  由於是在歌曲資訊呼叫選單 選單元素會是在該歌曲的後一位 所以往前找指定的class 就可以取得songID
    var songId=select.prev(".songId").val()
    //取值測試
    // console.log("playlistId:"+ playlistId);
    // console.log("songId:"+ songId);

    $.post("includes/handlers/ajax/addToPlaylist.php", { playlistId: playlistId,songId:songId}).done(function(error){
        if (error != "") {
            alert(error);
            return;
        }
        hideOptionsMenu();
        select.val("");
    });
})
function updateEmail(emailClass){
    var emailValue=$("."+emailClass).val();

    $.post("includes/handlers/ajax/updateEmail.php",{email:emailValue,username:userLoggedIn}).done(function(response){
        $("."+emailClass).nextAll(".message").text(response);
    })
}
function updatePassword(oldPasswordClass, newPasswordClass1, newPasswordClass2){
    var oldPassword = $("." + oldPasswordClass).val();
    var newPassword1 = $("." + newPasswordClass1).val();
    var newPassword2 = $("." + newPasswordClass2).val();

    $.post("includes/handlers/ajax/updatePassword.php", { oldPassword: oldPassword, newPassword1: newPassword1, newPassword2: newPassword2, username: userLoggedIn}).done(function(response){
        $("." + oldPasswordClass).nextAll(".message").text(response);
    })
}

function logout() {
    $.post("includes/handlers/ajax/logout.php",function(){
        location.reload();
    });

}
function openPage(url){
    if(timer != null){
        clearTimeout(timer);
    }
    if(url.indexOf("?") == -1 ){
        url = url + "?";
    }
    //將傳進去的內容 進行URI 編碼
    var encodeUrl =encodeURI(url + "&userLoggedIn=" + userLoggedIn );
    console.log(encodeUrl);
    $("#mainContent").load(encodeUrl);
    $("body").scrollTop(0);//垂直移動量
    history.pushState(null,null,url);
}
function removeFromPlaylist(button,playlist) {
    var songId= $(button).prevAll(".songId").val();
    $.post("includes/handlers/ajax/removeFromPlaylist.php", {playlistId:playlistId,songId:songId}).done(function(error){
        if (error != "") {
            alert(error);
            return;
        }
        // ajax 回傳成功則執行done()
        openPage("playlist.php?id="+playlistId);
    });
}

//建立歌單
function createPlaylist(){
    var promptTxt =prompt("請輸入歌單名稱");//顯示 可輸入 對話框

    if(promptTxt != null){
        $.post("includes/handlers/ajax/createPlaylist.php",{name:promptTxt, username:userLoggedIn}).done(function(error){

            if(error !=""){
                alert(error);
                return;
            }
                // ajax 回傳成功則執行done()
                openPage("yourMusic.php");
        })
    }
}
//刪除歌單 id=$playlistId
function deletePlaylist(){
    var prompt =confirm("確定要刪除它?");
    if(prompt == true){
        $.post("includes/handlers/ajax/deletePlaylist.php", {playlistId:playlistId}).done(function(error){
            if (error != "") {
                alert(error);
                return;
            }
            // ajax 回傳成功則執行done()
            openPage("yourMusic.php");
        });
    }

}
//
function hideOptionsMenu() {
    var menu=$(".optionsMenu");
    if(menu.css("diplay") !="none"){
        menu.css("display","none");
    }
}

//按鈕觸發事件  顯示選單
function showOptionsMunu(button){
    var songId= $(button).prevAll(".songId").val();
    var menu=$('.optionsMenu');
    var menuWidth=menu.width();//return width to calculate
menu.find(".songId").val(songId);
    var scrollTop =$(window).scrollTop();
    var elementOffset =$(button).offset().top;//從上往下的偏移量

    var top= elementOffset-scrollTop;
    var left =$(button).position().left;

    menu.css({"top":top+"px","left":left-menuWidth+"px","display":"inline"});
}

//將傳入的時間 轉換格式
function formatTime(seconds) {
    //Math.round(seconds)  四捨五入   0.5 ->1  0.4->0
    var time = Math.round(seconds);
    //Math.floor(數字)   會回傳小於數字的最大整數 ex 5.5 -> 5   -5.5->-6
    var minites = Math.floor(time / 60);
    var seconds = time - (minites * 60);
    //秒數只有 個位 時，十位 補零
    var extraZero;
    if (seconds < 10) {
        extraZero = "0";
    } else {
        extraZero = "";
    }
    return minites + ":" + extraZero + seconds;
}

function updateTimeProgressBar(audio) {
    //更新目前播放秒數
    $(".progressTime.current").text(formatTime(audio.currentTime));

    //Version 1  顯示歌曲 "總" 秒數
    $(".progressTime.remaining").text(formatTime(audio.duration));
    //Version 2 顯示歌曲 "剩餘" 秒數
    // $(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));
    //畫目前時間軸
    var progress = (audio.currentTime / audio.duration) * 100;
    $("#timeBar").css("width", progress + "%");
}

function updateVolumeProgressBar(audio) {
    var volume = audio.volume * 100;
    $(".volumeBar .progress").css("width", volume + "%");
}

function playFirstSong(){
setTrack(tempPlaylist[0],tempPlaylist,true);
}

function Audio() {

    this.currentlyPlaying;
    this.audio = document.createElement('audio'); //build a audio tag
    this.audio.addEventListener("ended",function(){
        //nowPlayingBarContainer.php  line 154
        nextSong();
    })

    //監聽是否可以撥放->可以就觸發匿名函示
    this.audio.addEventListener("canplay", function() {

        // 將歌曲時間轉成標準格式輸出
        var duration = formatTime(this.duration);
        //顯示歌曲時間長度
        $(".progressTime.remaining").text(duration);

    });
    //監聽時間改變
    this.audio.addEventListener("timeupdate", function() {
        //if have duration
        if (this.duration) {
            updateTimeProgressBar(this);
        }
    })
    //監聽音量改變
    this.audio.addEventListener("volumechange", function() {
        if (this.volume) {

            updateVolumeProgressBar(this);
        }
    })
    //音樂路徑
    this.setTrack = function(track) {
        //取得 "現在"歌曲資訊
        //call nowPlayingBarContainer 的 setTrack  ajax 的回傳值
        this.currentlyPlaying = track;
        //連結同步
        this.audio.src = track.src;
    }
    this.play = function() {
        this.audio.play();
    }
    this.pause = function() {
        this.audio.pause();
    }
    // this.setAttribute=function(){
    //     this.audio.setAttribute('crossorigin', 'anonymous');
    // }

    this.setTime = function(seconds) {
        this.audio.currentTime = seconds;
    }
}
