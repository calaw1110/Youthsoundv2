<?php
include "includes/includeFiles.php";
?>
<div class="userDetails">
    <div class="container borderBottom">
      <h2>EMAIL</h2>
      <input type="text" class="email" name="email" placeholder="修改信箱..." value="<?php echo $userLoggedIn->getUserEmail(); ?>">
      <span class="message"></span>
      <button class="button" onclick="updateEmail('email')">修改</button>
    </div>

    <div class="container">
      <h2>密碼</h2>
      <input type="password"" class="oldPassword" name="oldPassword" placeholder="目前密碼" value="">
      <input type="password"" class="newPassword1" name="newPassword1" placeholder="新密碼" value="">
      <input type="password"" class="newPassword2" name="newPassword2" placeholder="確認密碼" value="">
      <span class="message"></span>
      <button class="button" onclick="updatePassword('oldPassword','newPassword1','newPassword2')">修改</button>
    </div>

 </div>
