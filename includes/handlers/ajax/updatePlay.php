<?php
include "../../config.php";
if (isset($_POST['songId'])) {
    $songId = $_POST['songId'];
    //播放次數計數器
    //撥放一次就呼叫一次  數值 n = n+1 累加上去
    $query = mysqli_query($conn, "UPDATE songs SET plays =plays + 1 WHERE id='$songId'");
}
