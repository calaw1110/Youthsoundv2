<?php
include "../../config.php";

if (isset($_POST['name']) && isset($_POST['username'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $date = date("Y-m-d");

    $addPlaylistsquery = mysqli_query($conn,
        "INSERT INTO playlists(name,owner,dateCreate)
          VALUES('$name','$username','$date')"
    );
} else {
    echo "建立失敗";
}
