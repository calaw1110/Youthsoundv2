<?php
if (isset($_POST['loginBtn'])) {
    //login button press
    $username = $_POST['loginUsername'];
    $password = $_POST['loginUserpwd'];

    //login function
    $result = $account->login($username, $password);

    if ($result == true) {
        $_SESSION['userLoggedIn']=$username;
        header("Location: index.php");
    }
}
