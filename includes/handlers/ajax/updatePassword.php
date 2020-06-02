<?php
include "../../config.php";
if (!isset($_POST['username'])) {
    echo "失敗";
    exit();
}
if (!isset($_POST['oldPassword']) || !isset($_POST['newPassword1']) || !isset($_POST['newPassword2'])) {
    echo "有欄位沒有輸入";
    exit();
}
if ($_POST['oldPassword'] == "" || $_POST['newPassword1'] == "" || $_POST['newPassword2'] == "") {
    echo "請填寫所有欄位";
    exit();
}

$username = $_POST['username'];
$oldPassword = $_POST['oldPassword'];
$newPassword1 = $_POST['newPassword1'];
$newPassword2 = $_POST['newPassword2'];

$oldMd5 = md5($oldPassword);
$passwordCheck = mysqli_query($conn, "SELECT * FROM members WHERE mUsername='$username' AND mPwd='$oldMd5'");
if (mysqli_num_rows($passwordCheck) != 1) {
    echo "舊密碼錯誤";
}
if ($newPassword1 != $newPassword2) {
    echo "輸入的新密碼不相等";
}
if (preg_match('/[^A-Za-z0-9_]/', $newPassword1)) {
    echo "密碼只能使用大小寫英文、數字、特殊符號 '_'";
    exit();
}
if (strlen($newPassword1) > 30 || strlen($newPassword1) < 8) {
    echo "密碼長度至少8碼";
    exit();
}
$newMd5 = md5($newPassword1);
$query = mysqli_query($conn, "UPDATE members SET mPwd='$newMd5' WHERE mUsername='$username'");
echo "密碼修改成功";
