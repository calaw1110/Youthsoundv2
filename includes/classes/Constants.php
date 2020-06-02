<?php

//記錄使用常數的class
class Constants
{
    //密碼錯誤訊息常數
    public static $passwordDoNotMatch = "密碼不相同";
    public static $passwordHaveBannedCharacters = "密碼只能使用大小寫英文、數字、特殊符號 '_'";
    public static $passwordNotLong = "密碼長度至少8碼";
    //帳號錯誤訊息常數
    public static $usernameNotLong = "帳號長度必須介於6到25個字元之間";
    public static $usernameExists = "帳號已存在";
    //信箱錯誤訊息常數
    public static $emailInvalid = "請輸入信箱正確格式";
    public static $emailExists = "信箱已使用過";

    //登入錯誤訊息常數
    public static $loginFailed = "帳號或密碼錯誤";
}
