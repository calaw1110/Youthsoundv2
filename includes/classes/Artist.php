<?php
//將查詢歌手名稱的SQL 寫成CLASS 來呼叫
class Artist
{
    private $conn;
    private $id;
    private $artist;
    public function __construct($conn, $id)
    {
        $this->conn = $conn;
        $this->id = $id;
        $sql_artist = "SELECT name FROM artists WHERE id='$this->id'";
        $artistQuery = mysqli_query($this->conn, $sql_artist);
        $artist = mysqli_fetch_array($artistQuery);
        $this->artist = $artist['name'];
    }
    public function getArtistId()
    {
        return $this->id;
    }
    public function getArtistName()
    {
        return $this->artist;
    }
    public function getSongIds()
    {
        $query = mysqli_query($this->conn, "SELECT id FROM songs WHERE artist='$this->id' ORDER BY plays ASC");
        $array = array();
        while ($row = mysqli_fetch_array($query)) {
            array_push($array, $row['id']);
        }
        return $array;
    }
}
