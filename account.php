<?php
include "includes/config.php";
include "includes/classes/Account.php";
include "includes/classes/Constants.php";
$account = new Account($conn);
include "includes/handlers/login_handler.php";
include "includes/handlers/register_handler.php";
function getInputValue($getValue)
{
    if (isset($_POST[$getValue])) {
        echo $_POST[$getValue];
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link rel="stylesheet" href="assets/css/account.css" />
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js'></script>
  <script src="assets/js/account.js"></script>

  <title>YouthSound</title>
</head>

<body id="background">
  <?php

if (isset($_POST['SignupBtn'])) {
    echo '<script>
            $(document).ready(function() {
                $("#loginForm").hide();
                $("#registerForm").show();
            });
        </script>';
} else {
    echo '<script>
            $(document).ready(function() {
                $("#loginForm").show();
                $("#registerForm").hide();
            });
        </script>';
}

?>
  <div id="">
    <div id="loginContainer">
      <div id="inputContainer">
        <!-- 登入表單 -->
        <form action="account.php" method="POST" id="loginForm">
          <H2>Login to your account</H2>
          <p>
            <?php echo $account->getError(Constants::$loginFailed); ?>

            <label for="loginUsername">帳號</label>
            <input type="text" id="loginUsername" name="loginUsername" placeholder="請輸入帳號" required />
          </p>
          <p>
            <label for="loginUserpwd">密碼 </label><input type="password" id="loginUserpwd" name="loginUserpwd" placeholder="請輸入密碼" required />
          </p>

          <button type="submit" name="loginBtn" id="loginBtn">LOG IN</button>

          <div class="hasAccountText">
            <span id="hideLogin">還沒有帳號嗎？立即註冊！</span>
          </div>
        </form>

        <!-- 註冊表單 -->
        <form id="registerForm" action="account.php" method="POST">
          <H2>Create your account</H2>
          <p>
            <?php echo $account->getError(Constants::$usernameNotLong); ?>
            <?php echo $account->getError(Constants::$usernameExists); ?>
            <label for="username">帳號</label>
            <input type="text" id="username" name="username" value="<?php getInputValue('username')?>" placeholder="請輸入帳號" required />
          </p>

          <p>
            <?php echo $account->getError(Constants::$passwordDoNotMatch); ?>
            <?php echo $account->getError(Constants::$passwordHaveBannedCharacters); ?>
            <?php echo $account->getError(Constants::$passwordNotLong); ?>
            <label for="userpwd">密碼 </label><input type="password" id="userpwd" name="userpwd" placeholder="請輸入密碼" required />
            <small>請輸入至少8個字元的密碼，特殊字元僅能使用"_"</small><br /><br />
            <label for="userpwd2">確認密碼 </label><input type="password" id="userpwd2" name="userpwd2" placeholder="請再輸入一次相同密碼" required />

          </p>
          <p>
            <?php echo $account->getError(Constants::$emailInvalid); ?>
            <?php echo $account->getError(Constants::$emailExists); ?>
            <label for="useremail">信箱</label>
            <input type="email" id="useremail" name="useremail" value="<?php getInputValue('useremail')?>" placeholder="請輸入信箱" required>
          </p>
          <p>
            <label for="nickname">暱稱 </label>
            <input type="text" name="nickname" id="nickname" placeholder="王小明" value="<?php getInputValue('nickname')?>" required />
          </p>
          <button id="SignupBtn" type="submit" name="SignupBtn">
            Sign UP
          </button>

          <div class="hasAccountText">
            <span id="hideRegister">已經有帳號了？請點此登入！</span> </div>
        </form>
      </div>
      <div id="loginText">
        <h1>Get great music, right now</h1>
        <h2>Listen to loads of songs for free</h2>
        <ul>
          <li>Discover music you'll fall in love with</li>
          <li>Create your own playlists</li>
          <li>Follow artists to keep up to date</li>
        </ul>
      </div>
    </div>
  </div>
</body>

</html>
