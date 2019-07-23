<?php

include("../config/config.php");
include("../classes/User.php");

$c_mali = $_POST['current_email_p'];
$f_mail = $_POST['friend_email_p'];

$user_obj_c = new User($connection, $c_mali);

$user_obj_c->removeFriend($f_mail);

