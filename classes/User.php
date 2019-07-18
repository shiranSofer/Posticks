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
}
