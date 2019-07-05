<?php
include("header.php");
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <title>Posticks Board</title>
</head>
<body>
<div class="background-image"></div>
<table class="background-container-without-color">
    <tr>
        <td class="container_with_border" style="width: fit-content">
            User info
            <div STYLE="width: fit-content; margin-left: 50%; transform: translate(-50%, -50%)">
                <img class="user_image" src="images/user_profile/user_icon.png" alt="user picture">
                <div>
                    Shiran Sofer
                </div>
            </div>
        </td>
        <td rowspan="2" style="width: 50px"></td> <!--SPACE-->
        <td colspan="2" rowspan="3">
            <div class="container_with_border" style="height: 550px; overflow: auto">
                POSTICKS board<br>
                <img src="images/posticks/pink_postick.png" style="width: 300px; height: 200px;" alt="postick"><br>
                <img src="images/posticks/blue_postick.png" style="width: 300px; height: 200px;" alt="postick"><br>
                <img src="images/posticks/white_postick.png" style="width: 300px; height: 200px;" alt="postick"><br>
                <img src="images/posticks/yellow_postick.png" style="width: 300px; height: 200px;" alt="postick"><br>
            </div>
        </td>
        <td rowspan="2" style="width: 50px"></td> <!--SPACE-->
        <td class="container_with_border">
            friends list
        </td>
    </tr>
    <tr>
        <td class="container_with_border">
            something
        </td>
        <td class="container_with_border">
            chat
        </td>
    </tr>
</table>
</body>
</html>
