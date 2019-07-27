<?php
/*Form variables*/
$first_name = "";
$last_name = "";
$email = "";
$password = "";
$confirm_password = "";
$gender = "";
$date = "";
$error_array = array();
$profile_pic_array = [  "user_pink.png", "user_orange.png",
                        "user_green.png", "user_red.png",
                        "user_blue.png", "user_yellow.png",
                        "user_purple.png"];

if (isset($_POST['register_button'])) {
    $first_name = strip_tags($_POST['reg_first_name']); //Remove html tags
    $first_name = str_replace(' ', '', $first_name); //Remove spaces
    $first_name = ucfirst(strtolower($first_name)); //Uppercase first latter
    $_SESSION['reg_first_name'] = $first_name; //stores first name into session

    $last_name = strip_tags($_POST['reg_last_name']); //Remove html tags
    $last_name = str_replace(' ', '', $last_name); //Remove spaces
    $last_name = ucfirst(strtolower($last_name)); //Uppercase first latter
    $_SESSION['reg_last_name'] = $last_name; //stores last name into session

    $email = strip_tags($_POST['reg_email']); //Remove html tags
    $email = str_replace(' ', '', $email); //Remove spaces
    $email = ucfirst(strtolower($email)); //Uppercase first latter
    $_SESSION['reg_email'] = $email; //stores email into session

    $password = strip_tags($_POST['reg_password']); //Remove html tags
    $confirm_password = strip_tags($_POST['reg_confirm_password']); //Remove html tags

    $date = date("Y-m-d");

    $gender = $_POST['reg_gender'];

    /*Validate password*/
    if ($password != $confirm_password) {
        array_push($error_array, "Passwords don't match2<br>");
    } else {
        if (strlen($password) > 30 || strlen($password) < 5) {
            array_push($error_array, "Password must be between 5 and 30 characters<br>");
        }
        if (preg_match('/[^A-Za-z0-9]/', $password)) {
            array_push($error_array, "Your password can only contain english characters or numbers<br>");
        }
    }

    /*Validate email*/
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        $email_check = mysqli_query($connection, "SELECT email FROM users WHERE email='$email'");
        $num_email_check = mysqli_num_rows($email_check);

        if ($num_email_check > 0) {
            array_push($error_array, "Email already in use<br>");
        }
    } else {
        array_push($error_array, "Invalid email format<br>");
    }

    /*validate first name*/
    if (strlen($first_name) > 25 || strlen($first_name) < 2) {
        array_push($error_array, "First name must be between 2 and 25 characters<br>");
    }

    /*validate last name*/
    if (strlen($last_name) > 25 || strlen($last_name) < 2) {
        array_push($error_array, "Last name must be between 2 and 25 characters<br>");
    }

    /*Form completed*/
    if (empty($error_array)) {
        $password = md5($password);
        $random_pic = rand(0, 6);
        $profile_pic = "images/user_profile/" . $profile_pic_array[$random_pic];
        if (!mysqli_query($connection, "INSERT INTO users VALUES (NULL, '$first_name', '$last_name', '$email', 
                '$password', '$gender', '$date', '$profile_pic', '0', '0', 'true' , 'true', ',')")) {
            echo "error description: " . mysqli_error($connection);
        } else {
            header("Location: index.php");
        }
    }
}