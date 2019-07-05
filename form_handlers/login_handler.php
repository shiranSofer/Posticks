<?php

$error_array = array();

if(isset($_POST['login_button'])) {
    $email = filter_var($_POST['login_email'], FILTER_SANITIZE_EMAIL);
    $_SESSION['login_email'] = $email; //Store email into session variable
    $password = md5($_POST['login_password']);

    $check_database_query = mysqli_query($connection, "SELECT * FROM users WHERE email='$email' AND password='$password'");
    $check_login_query = mysqli_num_rows($check_database_query);

    if($check_login_query == 1) {
        $user_info = mysqli_fetch_array($check_database_query);
        $_SESSION['username'] = $user_info['first_name'] . " " . $user_info['last_name'];
        $check_user_active = $user_info['active'];
        if($check_user_active == 'false') {
            $reactive_account_query = mysqli_query($connection, "UPDATE users SET active='true' WHERE email='$email'");
        }
        header("Location: board.php");
    } else {
        array_push($error_array, "Email or password was incorrect<br>");
    }
}
