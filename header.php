<?php
require 'config/config.php';

if (isset($_SESSION['username'])) {
    $user_loggedIn = $_SESSION['username'];
    $user_email = $_SESSION['email'];
    $user_info_query = mysqli_query($connection, "SELECT * FROM users WHERE email='$user_email'");
    $user_info = mysqli_fetch_array($user_info_query);
} else {
    header("Location: index.php");
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <script src="javaScript/handler.js"></script>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/header.css">
    <link rel="stylesheet" type="text/css" href="css/wall.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <title>Posticks Board</title>
</head>
<body>
<div class="top_bar">
    <div class="logo">
        <a href="board.php">POSTICKS</a>
    </div>

    <div class="search">
        <form action="search.php" method="GET" name="search_form">
            <label>
                <input type="text" onkeyup="getLiveSearchUsers(this.value, '<?php echo $user_loggedIn; ?>')" name="q" placeholder="Search..." autocomplete="off" id="search_text_input">
            </label>
            <div class="search_button">
                <img src="images/magnifying_glass_icon.png" alt="search_icon">
            </div>
        </form>
        <div class="search_results"></div>

        <div class="search_results_footer_empty"></div>
    </div>
    <nav>
        <a href="#">
            <?php echo $user_info['first_name']; ?>
        </a>
        <a href="#">
            <i class="material-icons">message</i>
        </a>
        <a href="#">
            <i class="material-icons">notification_important</i>
        </a>
        <a href="<?php echo str_replace(" ", "_", $user_loggedIn); ?>">
            <i class="material-icons">account_circle</i>
        </a>
        <a href="#">
            <i class="material-icons">settings</i>
        </a>
        <a href="handlers/logout.php">Logout</a>
    </nav>
</div>
<div class="wall_container">