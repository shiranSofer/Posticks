<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/wall.css">

<!--        <link rel="stylesheet" type="text/css" href="css/style.css">-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <title>Posticks</title>
</head>
<body>
<style>
    body {
        color: yellow;
        font-family: "Segoe Print", fantasy;
        font-weight: bold;
        font-size: 12px;
    }
    #like_form input[type=submit] {
        background-color: transparent;
        border: 0;
        cursor: pointer;
        margin: 0;
        padding: 0;
        position: absolute;
        color: yellow;
        font-family: "Segoe Print", fantasy;
        font-weight: bold;
        font-size: 12px;
    }
    .like_value {
        float: right;
    }
</style>
<?php
require('config/config.php');
include("classes/User.php");
include("classes/Post.php");

if (isset($_SESSION['username'])) {
    $user_loggedIn = $_SESSION['username'];
    $user_email = $_SESSION['email'];
    $user_info_query = mysqli_query($connection, "SELECT * FROM users WHERE email='$user_email'");
    $user_info = mysqli_fetch_array($user_info_query);
} else {
    header("Location: index.php");
}

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
}

$get_likes = mysqli_query($connection, "SELECT likes, posted_by FROM posts WHERE id='$post_id'");
$likes_row = mysqli_fetch_array($get_likes);
$number_of_likes = $likes_row['likes'];
$posted_by = $likes_row['posted_by'];

$user_details_query = mysqli_query($connection, "SELECT * FROM users WHERE email='$posted_by'");
$user_details_row = mysqli_fetch_array($user_details_query);
$total_user_likes = $user_details_row['num_likes'];


//Like button pressed
if(isset($_POST['like_button'])) {
    $number_of_likes++;
    $update_number_of_likes_query = mysqli_query($connection, "UPDATE posts SET likes='$number_of_likes' WHERE id='$post_id'");
    $total_user_likes++;
    if(!mysqli_query($connection, "UPDATE users SET num_likes='$total_user_likes' WHERE email='$user_email'"))
        echo "UPDATE total_user_likes error: " . mysqli_error($connection);
    $update_user_likes_query = mysqli_query($connection, "UPDATE users SET num_likes='$total_user_likes' WHERE email='$user_email'");

    if(!mysqli_query($connection, "INSERT INTO likes VALUES (NULL, '$posted_by', '$post_id')"))
        echo "INSERT like error: " . mysqli_error($connection);

}

//Unlike button pressed
if(isset($_POST['unlike_button'])) {
    if ($number_of_likes > 0) {
        $number_of_likes--;
        $update_number_of_likes_query = mysqli_query($connection, "UPDATE posts SET likes='$number_of_likes' WHERE id='$post_id'");
        $total_user_likes--;
        $update_user_likes_query = mysqli_query($connection, "UPDATE users SET num_likes='$total_user_likes' WHERE email='$user_email'");
        $delete_like_query = mysqli_query($connection, "DELETE FROM likes WHERE posted_by='$posted_by' AND post_id='$post_id'");
    }
}

$check_query = mysqli_query($connection, "SELECT * FROM likes WHERE posted_by='$user_email' AND post_id='$post_id'");
$num_of_rows = mysqli_num_rows($check_query);

if($num_of_rows > 0) {
    echo    '<form action="like.php?post_id=' . $post_id . '" method="POST" id="like_form">
                <input type="submit" class="post_likes" name="unlike_button" value="Unlike">
                <i class="material-icons" style="color: #ff0052; margin: 0 0 0 38px;">favorite</i>
                <div class="like_value">
                    ' . $number_of_likes . ' Likes
                </div>
             </form>
    ';
} else {
    echo    '<form action="like.php?post_id=' . $post_id . '" method="POST" id="like_form">
                <input type="submit" class="post_likes" name="like_button" value="Like"">
                <i class="material-icons" style="color: white; margin: 0 0 0 34px;" >favorite</i>
                <div class="like_value">
                    ' . $number_of_likes . ' Likes
                </div>
             </form>
    ';
}
?>
</body>
</html>

