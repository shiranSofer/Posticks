<?php
class User {
    private $user;
    private $connection;

    public function __construct($connection, $user_email){
        $this->connection = $connection;
        $user_details_query = mysqli_query($connection, "SELECT * FROM users WHERE email='$user_email'");
        $this->user = mysqli_fetch_array($user_details_query);
    }

    public function getFirstAndLastName() {
        $user_email = $this->user['email'];
        $user_query = mysqli_query($this->connection, "SELECT first_name, last_name FROM users WHERE email='$user_email'");
        $row = mysqli_fetch_array($user_query);
        return $row['first_name'] . " " . $row['last_name'];
    }

    public function getEmail() {
        return $this->user['email'];
    }

    public function getNumberOfPosts() {
        return $this->user['num_posts'];
    }

    public function getNumberOfLikes() {
        return $this->user['num_likes'];
    }

    public function getActive() {
        return $this->user['active'];
    }

    public function getAvailable() {
        return $this->user['available'];
    }

    public function getProfilePicture() {
        $user_email = $this->user['email'];
        $user_query = mysqli_query($this->connection, "SELECT profile_picture FROM users WHERE email='$user_email'");
        $row = mysqli_fetch_array($user_query);
        return $row['profile_picture'];
    }

    public function increaseNumberOfPosts() {
        $user_email = $this->user['email'];
        $num_posts = $this->getNumberOfPosts();
        $num_posts++;
        $update_query = mysqli_query($this->connection, "UPDATE users SET num_posts='$num_posts' WHERE email='$user_email'");
    }

    public function isFriend($user_email_to_check) {
        $user_email_with_comma = "," . $user_email_to_check . ",";
        if(strstr($this->user['friends_array'], $user_email_with_comma) || $user_email_to_check == $this->user['email']) {
            return true;
        } else {return false;}
    }

    public function removeFriend($user_email_to_remove) {
        $logged_in_user = $this->user['email'];

        $query = mysqli_query($this->connection, "SELECT friends_array FROM users WHERE email='$user_email_to_remove'");
        $row = mysqli_fetch_array($query);
        $friend_array_email = $row['friends_array'];

        $new_friend_array = str_replace($user_email_to_remove . ",", "", $this->user['friends_array']);
        if(!mysqli_query($this->connection, "UPDATE users SET friends_array='$new_friend_array' WHERE email='$logged_in_user'"))
            echo "update friends array query (1) error: " . mysqli_error($this->connection);
        $remove_friend = mysqli_query($this->connection, "UPDATE users SET friends_array='$new_friend_array' WHERE email='$logged_in_user'");

        $new_friend_array = str_replace($this->user['email'] . ",", "", $friend_array_email);
        if(!mysqli_query($this->connection, "UPDATE users SET friends_array='$new_friend_array' WHERE email='$user_email_to_remove'"))
            echo "update friends array query (2) error: " . mysqli_error($this->connection);
        $remove_friend = mysqli_query($this->connection, "UPDATE users SET friends_array='$new_friend_array' WHERE email='$user_email_to_remove'");
    }
}
