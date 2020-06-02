<?php
ob_start();
session_start();



//設定時區
$timezone = date_default_timezone_set("Asia/Taipei");

//mysqli_connect("網址或本機","使用者帳號","密碼","連線資料庫名稱");
$conn = mysqli_connect("localhost", "root", "", "musicweb") or die("connect fail");

if (mysqli_connect_errno()) {
    echo "資料庫連線失敗" . mysqli_connect_errno();
}
if ($conn) {
    mysqli_query($conn, "SET NAMES utf8mb4");
}
