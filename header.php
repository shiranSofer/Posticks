<?php
require 'config/config.php';

if (isset($_SESSION['username'])) {
    $user_loggedIn = $_SESSION['username'];
    $user_email = $_SESSION['email'];
    $user_info_query = mysqli_query($connection, "SELECT * FROM users WHERE email='$user_email'");
    $user_test = mysqli_fetch_array($user_info_query);
} else {
    header("Location: index.php");
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <title>Posticks Board</title>
</head>
<body>
    <div class="top_bar">
        <div class="logo">
            <a href="board.php">POSTICKS</a>
        </div>
        <nav>
            <a href="#">
               <?php echo $user_test['first_name'] ?>
            </a>
            <a href="#">
                <i class="material-icons">message</i>
            </a>
            <a href="#">
                <i class="material-icons">notification_important</i>
            </a>
            <a href="#">
                <i class="material-icons">account_circle</i>
            </a>

        </nav>
    </div>
