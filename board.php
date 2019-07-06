<?php
include("header.php");
include("classes/User.php");
include("classes/Post.php");

if(isset($_POST['post_button'])) {
    $post = new Post($connection, $user_email);
    $post->submitPost($_POST['post_textarea'], 'none', 'true');
}
?>
        <div class="wrapper">
            <div class="user_details column">
                <a href="<?php echo str_replace(" ", "_", $user_loggedIn); ?>"> <img class="profile_picture" src="<?php echo $user_info['profile_picture']; ?>" alt="user picture"></a>
                <br>
                <?php
                    echo $user_info['first_name'] . " " . $user_info['last_name'] . "<br>";
                    echo "Posts: " . $user_info['num_posts'] . "<br>" . "Likes: " . $user_info['num_likes'] . "<br>";
                ?>
            </div>
            <div class="main_column column">
                <form class="post_form" action="board.php" method="POST">
                    <label for="post_textarea"></label><textarea name="post_textarea" id="post_textarea" placeholder="Got something to post?"></textarea>
                    <input type="submit" name="post_button" id="post_button" value="Post">
                    <hr>
                </form>

                <?php
                    $user_obj = new User($connection, $user_email);
                    echo $user_obj->getFirstAndLastName();
                ?>
            </div>
        </div>

    </div>
</body>
</html>
