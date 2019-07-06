<?php
class Post {
    private $user_obj;
    private $connection;

    public function __construct($connection, $user_email){
        $this->connection = $connection;
        $this->user_obj = new User($connection, $user_email);
    }

    public function submitPost($body, $user_to, $public) {
        $body = strip_tags($body);
        $body = mysqli_real_escape_string($this->connection, $body);
        $check_if_empty = preg_replace('/\s+/', '', $body);

        if($check_if_empty != "") {
            $date_created = date("Y-m-d H:i:s");
            $posted_by = $this->user_obj->getEmail();

            //provide from user to post himself
            if($user_to == $posted_by) {
                $user_to = "none";
            }

            //insert post
            $user_active = $this->user_obj->getActive();
            if(!$insert_post_query = mysqli_query($this->connection, "INSERT INTO posts VALUES (NULL , '$body', '$posted_by', '$user_to', '$date_created', '$public', '$user_active', 'false', '0')"))
                echo "insert post error: ". mysqli_error($this->connection);
            $returned_id = mysqli_insert_id($this->connection);

            //insert notification

            //update number of posts
            $this->user_obj->increaseNumberOfPosts();
        }
    }

    public function loadPostsOfFriends() {
        $str = "";
        $data = mysqli_query($this->connection, "SELECT * FROM posts WHERE deleted='false' ORDER BY id DESC");

        while($row=mysqli_fetch_array($data)) {
            $id = $row['id'];
            $body = $row['body'];
            $posted_by = $row['posted_by'];
            $date_time = $row['date_created'];

            if($row['posted_to'] == "none") {
                $user_to = "";
            } else {
                $user_to_obj = new User($this->connection, $row['posted_to']);
                $user_to_name = $user_to_obj->getFirstAndLastName();
                $user_to = "<a href='" . $row['posted_to'] . "'>" . $user_to_name . "</a>";
            }

            //check if the posted user has an active account
            $added_by_obj = new User($this->connection, $posted_by);
            if($added_by_obj->getActive() == 'true') {
                continue;
            }
            $user_details_query = mysqli_query($this->connection, "SELECT first_name, last_name, profile_picture FROM users WHERE email='$posted_by'");
            $user_details_row = mysqli_fetch_array($user_details_query);
        }
    }
}
