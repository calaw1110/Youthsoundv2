<?php
include("includes/includeFiles.php");
?>
<h1 class="pageHeadingBig">Album test</h1>
<div class="gridViewContainer">
    <?php
    $sql = "SELECT * FROM albums ORDER BY rand() LIMIT 10";
    $albumQuery = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_array($albumQuery)) {
        echo "<div class='gridViewItem'>
                  <span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . " \")'>
                      <img src='" . $row['artworkPath'] . "' alt=''>
                      <div class='gridViewInfo'>" . $row['title'] . "
                      </div>
                  </span>
              </div>";
    }
    ?>
