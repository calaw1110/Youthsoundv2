<?php

function sanitizeFormUsername($inputText) //inputText 修正

{
    $input = strip_tags($inputText);
    //消除內容中的php or html標籤

    $input = str_replace(" ", "", $inputText);
    //第一組" "為選擇器  ,  第二組中""為替換內容 , 變數  將空白替換成沒有內容

    $input = ucfirst(strtolower($inputText));
    // ucfirst("abc") 會將字首大寫
    // strtolower("") 將所有英文字轉成小寫
    //  $@# = ucfirst(strtolower("String"))  先將英文轉換成小寫 再將字首大寫  外國人需求

    return $input;
}

if (isset($_POST['SignupBtn'])) {
    // SignupBtn btn is ok
    // $usename = sanitizeFormUsername($_POST['username']);
    $username = $_POST['username'];
    $userpwd = $_POST['userpwd'];
    $userpwd2 = $_POST['userpwd2'];
    $useremail = $_POST['useremail'];
    $nickname = $_POST['nickname'];

    $wasSuccessful = $account->register($username, $userpwd, $userpwd2, $useremail, $nickname);
    if ($wasSuccessful == true) {
        //TODO
        $_SESSION['userLoggedIn'] = $username;
        header("Location:index.php");
    }
}
