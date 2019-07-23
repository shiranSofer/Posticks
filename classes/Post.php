<?php

class Post
{
    private $user_obj;
    private $connection;

    public function __construct($connection, $user_email){
        $this->connection = $connection;
        $this->user_obj = new User($connection, $user_email);
    }

    public function submitPost($body, $user_to, $public)
    {
        $body = strip_tags($body);
        $body = mysqli_real_escape_string($this->connection, $body);
        $check_if_empty = preg_replace('/\s+/', '', $body);

        if ($check_if_empty != "") {
            $date_created = date("Y-m-d H:i:s");
            $posted_by = $this->user_obj->getEmail();

            //provide from user to post himself
            if ($user_to == $posted_by) {
                $user_to = "none";
            }

            //insert post
            $user_active = $this->user_obj->getActive();
            if (!$insert_post_query = mysqli_query($this->connection, "INSERT INTO posts VALUES (NULL , '$body', 
                    '$posted_by', '$user_to', '$date_created', '$public', '$user_active', 'false', '0')"))
                echo "insert post error: " . mysqli_error($this->connection);
            $returned_id = mysqli_insert_id($this->connection);

            //insert notification

            //update number of posts
            $this->user_obj->increaseNumberOfPosts();
        }
    }

    public function loadPostsOfFriends()
    {
        $str = "";
        if (!mysqli_query($this->connection, "SELECT * FROM posts WHERE deleted='false' ORDER BY id DESC"))
            echo "select post error: " . mysqli_error($this->connection);
        $data = mysqli_query($this->connection, "SELECT * FROM posts WHERE deleted='false' ORDER BY id DESC");

        while ($row = mysqli_fetch_array($data)) {
            $id = $row['id'];
            $body = $row['body'];
            $posted_by = $row['posted_by'];
            $date_time = $row['date_created'];

            if ($row['posted_to'] == "none") {
                $user_to = "";
            } else {
                $user_to_obj = new User($this->connection, $row['posted_to']);
                $user_to_name = $user_to_obj->getFirstAndLastName();
                $user_to = "to <a href='" . $row['posted_to'] . "'>" . $user_to_name . "</a>";
            }

            //check if the posted user has an active account
            $added_by_obj = new User($this->connection, $posted_by);
            if ($added_by_obj->getActive() == false) {
                continue;
            }

            //check if the posted user is friend of logged user
            if ($this->user_obj->isFriend($posted_by)) {

                if (!mysqli_query($this->connection, "SELECT first_name, last_name, profile_picture FROM users WHERE email='$posted_by'"))
                    echo "user details error: " . mysqli_error($this->connection);
                $user_details_query = mysqli_query($this->connection, "SELECT first_name, last_name, profile_picture, email FROM users WHERE email='$posted_by'");

                $user_details_row = mysqli_fetch_array($user_details_query);
                $user_first_name = $user_details_row['first_name'];
                $user_last_name = $user_details_row['last_name'];
                $user_profile_pic = $user_details_row['profile_picture'];
                $posted_by_username = $user_first_name . "_" . $user_last_name;

                ?>
                <script>
                    //show or hide comment area
                    function toggle<?php echo $id; ?>() {
                        let element = document.getElementById("toggleComment<?php echo $id; ?>");
                        if (element.style.display === "block") {
                            element.style.display = "none";
                        } else {
                            element.style.display = "block";
                        }
                    }
                </script>
                <?php
                //number of comments
                if(!mysqli_query($this->connection, "SELECT * FROM comments WHERE post_id='$id'"))
                    echo "number of comments query error: " . mysqli_error($this->connection);
                $comments_check_query = mysqli_query($this->connection, "SELECT * FROM comments WHERE post_id='$id'");
                $number_of_comments = mysqli_num_rows($comments_check_query);

                $date_message = $this->printPostTime($date_time);

                /*Display delete friend button*/
                if($this->user_obj->getEmail() !== $user_details_row['email']) {
                    $button_friend_request = "<input type='submit' name='" . $posted_by_username . "' class='friends_button' value='remove friend'>";
                } else {
                    $button_friend_request = "<input type='submit' name='" . $posted_by_username . "' class='friends_button' value='remove friend' style='display: none'>";
                }
                if(isset($_POST[$posted_by_username])) {
                    $this->user_obj->removeFriend($user_details_row['email']);
                }

                $str .= "<div class='status_post' onclick='toggle$id()' >
                            <div class='post_profile_pic'>
                                <img src='$user_profile_pic' alt='user_profile_pic' style='width: 50px'>
                            </div>
                            <div class='posted_by'>
                                <a href='$posted_by_username'> $user_first_name $user_last_name</a> $user_to &nbsp;&nbsp;&nbsp;&nbsp;
                                $date_message
                            </div>
                            <div id='post_body'>$body<br></div>
                            <div class='post_newsfeed_options'>
                                Comments($number_of_comments)&nbsp;&nbsp;&nbsp;
                                <iframe src='like.php/?post_id=$id'></iframe>
                             </div>
                             <form action='board.php' method='POST'>
                                " . $button_friend_request ."
                            </form>
                        </div>
                        <div class='post_comment' id='toggleComment$id' style='display: none;'>
                            <iframe src='comment_frame.php?post_id=$id' id='comment_iframe' name='comment_frame'></iframe>
                        </div>
                        <hr>";
            }
        }
        echo $str;
    }

    private function printPostTime($date_time)
    {
        $current_date_time = date("Y-m-d H:i:s");
        $message = "error";
        try {
            $posted_time = new DateTime($date_time);
            $current_time = new DateTime($current_date_time);
            $delta_time = $posted_time->diff($current_time);

            if ($delta_time->y > 0) { //delta more then year : "2 years ago"
                if ($delta_time->y == 1) {
                    $message = $delta_time->y . " year ago";
                } else {
                    $message = $delta_time->y . " years ago";
                }
            } else if ($delta_time->m > 0) { //delta more then month and less then 1 year : "2 months 5 days ago"
                //days message
                if ($delta_time->d == 0) {
                    $days_message = $delta_time->d . " ago";
                } else if ($delta_time->d == 1) {
                    $days_message = $delta_time->d . " day ago";
                } else {
                    $days_message = $delta_time->d . " days ago";
                }
                //month message
                if ($delta_time->m == 1) {
                    $message = $delta_time->m . " month" . $days_message;
                } else {
                    $message = $delta_time->m . " months" . $days_message;
                }
            } else if ($delta_time->d > 0) {
                if ($delta_time->d == 1) {
                    $message = "Yesterday";
                } else {
                    $message = $delta_time->d . " days ago";
                }
            } else if ($delta_time->h > 0) {
                if ($delta_time->h == 1) {
                    $message = $delta_time->h . " hour ago";
                } else {
                    $message = $delta_time->h . " hours ago";
                }
            } else if ($delta_time->i > 0) {
                if ($delta_time->i == 1) {
                    $message = $delta_time->i . " minute ago";
                } else {
                    $message = $delta_time->i . " minutes ago";
                }
            } else {
                if ($delta_time->s < 30) {
                    $message = "Just now";
                } else {
                    $message = $delta_time->s . " seconds ago";
                }
            }
            return $message;
        } catch (Exception $e) {
            return $message;
        }
    }
}
