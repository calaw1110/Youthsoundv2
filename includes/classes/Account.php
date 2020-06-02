<?php

//controller
class Account
{
    private $conn;
    //紀錄錯誤訊息
    private $errorArray;
    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->errorArray = array();
    }
    //登入相關
    public function login($un, $pw)
    {
        $pw = md5($pw);
        $sql = "SELECT * FROM members WHERE mUsername ='$un' AND mPwd ='$pw'";
        $result = mysqli_query($this->conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            return true;
        } else {
            array_push($this->errorArray, Constants::$loginFailed);
            return false;
        }
    }

    //註冊相關
    public function register($un, $pw, $pw2, $email, $nickname)
    {
        //傳進各個欄位的判斷function
        $this->validateUsername($un);
        $this->validatePasswords($pw, $pw2);
        $this->validateEmail($email);

        if (empty($this->errorArray) == true) {
            // TODO :  Insert into db
            //假如errorArray陣列為空 就可以執行 新增到資料庫

            return $this->insertUserDetails($un, $pw, $email, $nickname);
        } else {
            return false;
        }
    }
    private function insertUserDetails($un, $pw, $email, $nickname)
    {
        //使用md5加密  ->  123 = YTR$EWQRGE#WG%#
        $encryptedpw = md5($pw);
        $profilePic = "assets/images/profile-pic/test.jpg";
        $date = date("Y-m-d");
        //sql 語法
        $sql = "INSERT INTO members(mUsername,mPwd,mEmail,mSignUpDate,mProfilePic,mNickname) VALUES('$un','$encryptedpw','$email',' $date','$profilePic','$nickname')";
        $result = mysqli_query($this->conn, $sql);
        return $result;
    }
    public function getError($error)
    {
        //in_array (搜尋目標,被搜尋陣列)
        if (!in_array($error, $this->errorArray)) {
            $error = "";
        }
        return "<span class='errorMessage'>$error</span>";
    }

    private function validateUsername($username)
    { //判斷帳號長度
        // strlen() 取得字串長度;
        if (strlen($username) > 25 || strlen($username) < 6) {
            array_push($this->errorArray, Constants::$usernameNotLong);
        }
        //TODO: check  if username exists
        $checkUsernameExistQuery = "SELECT mUsername FROM members WHERE mUsername='$username'";
        $result = mysqli_query($this->conn, $checkUsernameExistQuery);
        if (mysqli_num_rows($result) != 0) {
            array_push($this->errorArray, Constants::$usernameExists);
        }
    }

    private function validatePasswords($pw, $pw2)
    { //判斷兩次輸入密碼是否一樣
        if ($pw != $pw2) {
            array_push($this->errorArray, Constants::$passwordDoNotMatch);
            return;
        } //使用正規表達式判斷密碼是否有禁止字元
        if (preg_match('/[^A-Za-z0-9_]/', $pw)) {
            array_push($this->errorArray, Constants::$passwordHaveBannedCharacters);
            return;
        } //判斷密碼長度
        if (strlen($pw) > 30 || strlen($pw) < 8) {
            array_push($this->errorArray, Constants::$passwordNotLong);
            return;
        }
    }
    private function validateEmail($email)
    { //判斷信箱輸入的格式以及網域是否正確
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailInvalid);
            return;
        }
        //TODO: check  if email exists
        $checkemailExistQuery = "SELECT mEmail FROM members WHERE mEmail='$email'";
        $result = mysqli_query($this->conn, $checkemailExistQuery);
        // mysqli_num_rows 取得結果的回傳行數
        if (mysqli_num_rows($result) != 0) {
            array_push($this->errorArray, Constants::$emailExists);
        }
    }
}
