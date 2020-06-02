<?php
//將查詢曲風名稱的SQL 寫成CLASS 來呼叫
class Genre
{
    private $conn;
    private $id;
    private $genre;
    public function __construct($conn, $id)
    {
        $this->conn = $conn;
        $this->id = $id;
        $genreQuery = mysqli_query($this->conn, "SELECT name FROM genres WHERE id='$this->id'");
        $genre = mysqli_fetch_array($genreQuery);
        $this->genre = $genre['name'];
    }

    public function getGenreName()
    {
        return  $this->genre;
    }
}
