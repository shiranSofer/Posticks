<?php
require 'config/config.php';
require 'form_handlers/login_handler.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <title>Posticks</title>
</head>
<body>
<div class="background-image"></div>
<table class="background-container">
    <tr>
        <td colspan="2">
            <h1>POSTICKS</h1>
            <!--                <img src="images/posticks_logo_t.png" alt="POSTICKS LOGO" style="height: 50px; width: 220px">-->
        </td>
    </tr>
    <tr>
        <td class="container" style="width: 70%">
            <div class="container">
                <img src="images/posticks/pink_postick.png" style="width: 60%;" alt="postick">
                <div class="information_bullet1">
                    <i class="material-icons">bubble_chart</i>Post your thoughts.
                </div>
                <div class="information_bullet2">
                    <i class="material-icons">bubble_chart</i>Tick your friends.
                </div>
                <div class="information_bullet3">
                    <i class="material-icons">bubble_chart</i>Enjoy POSTICKS!
                </div>
            </div>

        </td>
        <td class="container">
            <p>login/register</p>
            <form name="login_form" action="index.php" method="POST">
                <label><input type="email" name="login_email" placeholder="Email"
                              value="<?php if(isset($_SESSION['login_email'])) echo $_SESSION['login_email']?>" required></label><br>
                <label><input type="password" name="login_password" placeholder="Password"></label><br>
                <label class="error_message">
                    <?php if (in_array("Email or password was incorrect<br>", $error_array))
                        echo "Email or password was incorrect<br>"; ?>
                </label>
                <input type="submit" name="login_button" value="Login"><br><br>
                <p style="font-size: 15px">If you don't have an account, <a href="register.php">click here</a></p>
            </form>

        </td>
    </tr>
</table>

</body>
</html>

