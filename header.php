<?php
require 'config/config.php';

if(isset($_SESSION['username'])) {
    $user_loggedIn = $_SESSION['username'];
} else {
    header("Location: index.php");
}
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
