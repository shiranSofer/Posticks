<?php
include("header.php");
include("classes/User.php");
include("classes/Post.php");
include("handlers/follow_friend.php");

$error_message = "";
if(isset($_POST['post_button'])) {

    $upload_image_status = 1; //1 - ok, 0 - error
    $image_name = $_FILES['file_to_upload']['name'];

    $post_privacy = "true";

    if($image_name != "") {
        $target_dir = "images/user_posts/";
        $image_name = $target_dir . uniqid() . basename($image_name); //images/user_posts/hsdj213hdpostick.png
        $image_type = pathinfo($image_name, PATHINFO_EXTENSION);

        if($_FILES['file_to_upload']['size'] > 5000000) {
            $error_message = "Your image is too large";
            $upload_image_status = 0;
        }

        if(strtolower($image_type) != "jpeg" &&
            strtolower($image_type) != "png" &&
            strtolower($image_type) != "jpg" &&
            strtolower($image_type) != "gif") {

            $error_message = "You only can upload jpeg, png, jpg and gif";
            $upload_image_status = 0;
        }

        if($upload_image_status) {
            if(move_uploaded_file($_FILES['file_to_upload']['tmp_name'], $image_name)) {
                //image upload ok
            } else {
                $upload_image_status = 0;
            }
        }
    }

    if(isset($_POST['post_privacy'])) {
        $post_privacy = $_POST['post_privacy'];
    }

    if($upload_image_status) {
        $post = new Post($connection, $user_email);
        $post->submitPost($_POST['post_textarea'], 'none', $post_privacy, $image_name);
    }
}
?>
        <div class="wrapper">
            <div class="user_details column">
                <a href="<?php echo str_replace(" ", "_", $user_loggedIn); ?>">
                    <img class="profile_picture" src="<?php echo $user_info['profile_picture']; ?>" alt="user picture">
                </a>
                <br>
                <?php
                echo $user_info['first_name'] . " " . $user_info['last_name'] . "<br>";
                echo "Posts: " . $user_info['num_posts'] . "<br>" . "Likes: " . $user_info['num_likes'] . "<br>";
                ?>
            </div>
            <div class="main_column column">
                <form class="post_form" action="board.php" method="POST" enctype="multipart/form-data">
                    <input type="file" name="file_to_upload" multiple id="file_to_upload">
                    Private<label><input name="post_privacy" type="checkbox" value="false"></label>
                    <label for="post_textarea"></label><textarea name="post_textarea" id="post_textarea" placeholder="Got something to post?"></textarea>
                    <input type="submit" name="post_button" id="post_button" value="Post">
                    <div class="error_message"><?php echo $error_message; ?></div>
                    <hr>
                </form>

                <?php
                $post = new Post($connection, $user_email);
                $post->loadPostsOfFriends();
                ?>
            </div>
            <div style="margin-left: 10px">
                <div class="friends_list column">
                    <div class="friends_list_title">Add Friends</div><br>
                    <div class="messages">Enter email to start follow your person</div>
                    <form action="board.php" method="POST">
                        <label>
                            <input type="text" name="email_to_add" placeholder="Enter email">
                        </label>
                        <input type="submit" name="add_email" value="Add"><br>
                        <div style="font-size: 12px"><?php echo $add_friend_message ?></div>
                    </form>
                </div>
                <div class="play_zone column">
                    <div class="friends_list_title">Play Zone</div><br>
                    <div class="messages">Click 'Play' to start play Flappy Bird</div>
                    <form>
                        <input type="button" onclick="play_game()" value="Play">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
