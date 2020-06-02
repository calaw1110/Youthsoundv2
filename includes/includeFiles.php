<?php
// 判斷是否有用AJAX請求
if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    include "includes/config.php";
    //要先include Artist class 才能 include Album class
    include "includes/classes/Artist.php"; //1
    include "includes/classes/Album.php"; //2
    include "includes/classes/Song.php"; //3
    include "includes/classes/User.php"; //4
    include "includes/classes/Playlist.php"; //5

    if (isset($_GET['userLoggedIn'])) {
        //會員資訊實作化
        $userLoggedIn = new User($conn, $_GET['userLoggedIn']);
    } else {
        //username測試 保險機制
        //假如沒有抓到登入者資訊，讓所有功能停擺
        echo "username變數沒傳成功";
        exit();
    }
} else {
    include "includes/header.php";
    include "includes/footer.php";
    $url = $_SERVER['REQUEST_URI'];
    echo "<script>openPage('$url')</script>";
    exit();
}
