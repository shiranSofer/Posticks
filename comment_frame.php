<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/wall.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <title>Posticks</title>
</head>
<body>

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
?>

<script>
    //show or hide comment area
    function toggle() {
        let element = document.getElementById("comment_section");
        if (element.style.display === "block") {
            element.style.display = "none";
        } else {
            element.style.display = "block";
        }
    }
</script>

<?php
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
}
if (!mysqli_query($connection, "SELECT posted_by, posted_to FROM posts WHERE id='$post_id'"))
    echo "post query error: " . mysqli_error($connection);
$post_query = mysqli_query($connection, "SELECT posted_by, posted_to FROM posts WHERE id='$post_id'");
$post_query_row = mysqli_fetch_array($post_query);

$posted_to = $post_query_row['posted_by'];
if (isset($_POST['postComment' . $post_id])) {
    $comment_body = $_POST['comment_body'];
    $comment_body = mysqli_escape_string($connection, $comment_body);
    $date_time_now = date("Y-m-d H:i:s");
    $insert_comment_query = mysqli_query($connection, "INSERT INTO comments VALUES (NULL, '$comment_body', '$user_email', '$posted_to', '$date_time_now', 'false', '$post_id')");
    echo "<p>Comment posted!</p>";
}
?>

<form action="comment_frame.php?post_id=<?php echo $post_id; ?>" id="comment_form"
      name="postComment<?php echo $post_id; ?>" method="POST">
    <label><textarea name="comment_body"></textarea></label>
    <input type="submit" name="postComment<?php echo $post_id; ?>" value="Comment">
</form>

<?php
$get_comments = mysqli_query($connection, "SELECT * FROM comments WHERE post_id='$post_id' ORDER BY id ASC");
$count_comments = mysqli_num_rows($get_comments);
if ($count_comments != 0) {
    while ($comment = mysqli_fetch_array($get_comments)) {
        $comment_body = $comment['comment_body'];
        $commented_to = $comment['commented_to'];
        $commented_by = $comment['commented_by'];
        $comment_date_added = $comment['date_added'];
        $comment_deleted = $comment['deleted'];

        $date_message = printPostTime($comment_date_added);

        $user_obj = new User($connection, $commented_by);
        ?>

        <div class="comment_section">
            <a href="<?php echo str_replace(" ", "", $user_obj->getFirstAndLastName()); ?>" target="_parent">
                <img src="<?php echo $user_obj->getProfilePicture(); ?>" alt="profile_pic">
            </a>
            <a href="<?php echo $user_obj->getFirstAndLastName(); ?>"><b><?php echo $user_obj->getFirstAndLastName(); ?>
            </a>
            &nbsp;&nbsp;&nbsp;&nbsp; <span class="date_time_span"><?php echo $date_message ?></span> <br>
            <span class="body_comment_span"><?php echo $comment_body; ?></span>
            <hr>
        </div>

        <?php
    }
} else {
    echo "<div style=\"text-align: center;\">No comments to show...";
}
?>

</body>
</html>

<?php
function printPostTime($date_time)
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

?>

