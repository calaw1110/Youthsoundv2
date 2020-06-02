<?php

//將查詢專輯內容的SQL 寫成CLASS 來呼叫
class Album
{
    private $conn;
    private $id;
    private $title;
    private $artistId;
    private $genre;
    private $artworkPath;

    public function __construct($conn, $id)
    {
        $this->conn = $conn;
        $this->id = $id;

        //mysqli_fetch_row:只能返回一個一位數組，只能通過下標來顯示,$row[0];
        //mysqli_fetch_array:不只可以返回一個一維數組，還可以返回鍵值對的方式；

        //SQL查詢 album
        $sql_album = "SELECT * FROM albums WHERE id='$this->id'";
        $albumQuery = mysqli_query($this->conn, $sql_album);
        $album = mysqli_fetch_array($albumQuery);

        $this->title = $album['title'];
        $this->artistId =  $album['artist'];
        $this->genre =  $album['genre'];
        $this->artworkPath = $album['artworkPath'];
    }

    public function getAlbumTitle()
    {
        return $this->title;
    }
    public function getAlbumArtworkPath()
    {
        return $this->artworkPath;
    }
    public function getAlbumGenre()
    {
        return $this->genre;
    }
    public function getAlbumArtist()
    {
        // 回傳自身實作
        return new Artist($this->conn, $this->artistId);
    }
    public function getNumberOfSongs()
    {
        $Songsquery = mysqli_query($this->conn, "SELECT * FROM songs WHERE album ='$this->id'");
        return mysqli_num_rows($Songsquery);
    }
    public function getSongIds()
    {
        $query = mysqli_query($this->conn, "SELECT id FROM songs
        WHERE album='$this->id' ORDER BY albumOrder ASC");
        $array = array();
        while ($row = mysqli_fetch_array($query)) {
            array_push($array, $row['id']);
        }
        return $array;
    }
}
