<?php
ob_start(); //Turns on output buffering
session_start();
/*Connecting to database*/
$connection = mysqli_connect("localhost", "root", "", "posticks_network");
if (mysqli_connect_errno()) {
    echo "Failed to connect to database: " . mysqli_connect_errno();
}
