<?php
include("../config/config.php");
include("../classes/User.php");

$query = $_POST['query'];
$user_name = $_POST['user_loggedIn'];
$user_email = $_SESSION['email'];

$current_user_obj = new User($connection, $user_email);

$names = explode(" ", $query); //names is an array of the data of $query

//if query contains two words, assume they are first name and last name
if(count($names) == 2) {
    $search_users_returned_query = mysqli_query($connection, "SELECT * FROM users WHERE (first_name LIKE '%$names[0]%' AND last_name LIKE '%$names[1]%') AND active = 'true' LIMIT 8");
} else if($names[0] == "*") {
    if(!mysqli_query($connection, "SELECT * FROM users WHERE active = 'true'"))
        echo "users_returned_query error: " . mysqli_error($connection);
    $search_users_returned_query = mysqli_query($connection, "SELECT * FROM users WHERE active = 'true'");
} else { //if query contains one word only, search first name or last name
    if(!mysqli_query($connection, "SELECT * FROM users WHERE (first_name LIKE '%$names[0]%' OR last_name LIKE '%$names[0]%') AND active = 'true' LIMIT 8"))
        echo "users_returned_query error: " . mysqli_error($connection);
    $search_users_returned_query = mysqli_query($connection, "SELECT * FROM users WHERE (first_name LIKE '%$names[0]%' OR last_name LIKE '%$names[0]%') AND active = 'true' LIMIT 8");
}

if($query != "") {
    while($row = mysqli_fetch_array($search_users_returned_query)) {
        $user = new User($connection, $row['email']);
        $email_to_check = $row['email'];
        $username_temp = str_replace(" ", "", $user->getFirstAndLastName());

        echo "<div class='result_display'>
                <a href='" .str_replace(" ", "", $user->getFirstAndLastName()) ."'>
                    <div class='live_search_profile_pic'>
                        <img src=" . $user->getProfilePicture() ." alt='user_profile_picture'>
                    </div>
                    <div class='live_search_text'>
                        " .$user->getFirstAndLastName() ."<br>" .$user->getEmail() ."
                    </div>           
                </a>
             </div>";

    }
}