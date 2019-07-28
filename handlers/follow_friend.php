<?php
$add_friend_message = "";

if(isset($_POST['add_email'])) {
    $email_input = ucfirst($_POST['email_to_add']);
    $current_user_obj = new User($connection, $user_email);

    if($current_user_obj->isFriend($email_input)) {
        $add_friend_message = "The user is already your friend.";
    } else {
        $current_user_obj->addFriend($email_input);
        $add_friend_message = "The user added to your friends.";
    }
}

