<?php
class User
{
    private $conn;
    private $username;

    public function __construct($conn, $username)
    {
        $this->conn = $conn;
        $this->username = $username;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function getUserEmail()
    {
        $userEmailQuery = mysqli_query($this->conn, "SELECT mEmail FROM members  WHERE mUsername ='$this->username'");
        $row = mysqli_fetch_array($userEmailQuery);
        return $row['mEmail'];

    }
    public function getUserNickname()
    {
        $nicknameQuery = mysqli_query($this->conn, "SELECT mNickname FROM members  WHERE mUsername ='$this->username'");
        $row = mysqli_fetch_array($nicknameQuery);
        return $row['mNickname'];
    }
}
