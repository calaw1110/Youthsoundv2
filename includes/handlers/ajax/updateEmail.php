<?php
include "../../config.php";
if (!isset($_POST['username'])) {
    echo "失敗";
    exit();
}
if (isset($_POST['email']) && $_POST['username'] != "") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "EMAIL格式不對";
        exit();
    }
    $emailCheck = mysqli_query($conn, "SELECT mEmail FROM members WHERE mEmail='$email' AND mUsername!='$username'");
    if (mysqli_num_rows($emailCheck) > 0) {
        echo "這個信箱已被使用";
        exit();
    }

    $updateEmailQuery = mysqli_query($conn, "UPDATE members SET mEmail='$email' WHERE mUsername='$username'");
    echo "更新成功";
} else {
    echo "更新失敗";
}
