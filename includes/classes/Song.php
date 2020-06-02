<?php

//將查詢專輯內容的SQL 寫成CLASS 來呼叫
class Song
{
    private $conn;
    private $id;
    private $mysqliData;
    private $title;
    private $artistId;
    private $albumId;
    private $genre;
    private $duration;
    private $src;

    public function __construct($conn, $id)
    {
        $this->conn = $conn;
        $this->id = $id;
        //mysqli_fetch_row:只能返回一個一位數組，只能通過下標來顯示,$row[0];
        //mysqli_fetch_array:不只可以返回一個一維數組，還可以返回鍵值對的方式；

        $sql_song = mysqli_query($this->conn, "SELECT * FROM songs WHERE id='$this->id'");
        $this->mysqliData = mysqli_fetch_array($sql_song);
        $this->title = $this->mysqliData['title'];
        $this->artistId = $this->mysqliData['artist'];
        $this->albumId = $this->mysqliData['album'];
        $this->genre = $this->mysqliData['genre'];
        $this->duration = $this->mysqliData['duration'];
        $this->src = $this->mysqliData['src'];
    }
    public function getSongTitle()
    {
        return $this->title;
    }
    public function getSongId()
    {
        return $this->id;
    }
    public function getSongArtistId()
    {
        return new Artist($this->conn, $this->artistId);
    }
    public function getSongAlbum()
    {
        return new Album($this->conn, $this->albumId);
    }
    public function getSongSrc()
    {
        return $this->src;
    }
    public function getSongDuration()
    {
        return $this->duration;
    }
    public function getSongMysqliData()
    {
        return $this->mysqliData;
    }
    public function getSongGenre()
    {
        return $this->genre;
    }
}
