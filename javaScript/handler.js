$(document).ready(function () {
    //Animate search input
    $('#search_text_input').focus(function () {
        if(window.matchMedia("(min-width: 800px)").matches) {
            $(this).animate({width: '250px'}, 250);
        }
    });

    //Click on search button
    $('.search_button').on('click', function () {
        document.search_form.submit();
    });
});

//close search window after clicking other page
$(document).click(function (e) {
    if(e.target.class != "search_results") {
        $(".search_results").html("");
        $('.search_results_footer').toggleClass("search_results_footer_empty");
        $('.search_results_footer').toggleClass("search_results_footer");
    }
});

function getLiveSearchUsers(value, user) {
    $.post("handlers/ajax_search.php", {query:value, user_loggedIn: user}, function (data) {
        if($(".search_results_footer_empty")[0]) {
            $(".search_results_footer_empty").toggleClass("search_results_footer");
            $(".search_results_footer_empty").toggleClass("search_results_footer_empty");
        }
        $('.search_results').html(data);
        //$('.search_results_footer').html("<a href='search.php?q=" + value + "'>See All Results</a>")

        /*if(data = "") {
            $('.search_results_footer').html("");
            $('.search_results_footer').toggleClass("search_results_footer_empty");
            $('.search_results_footer').toggleClass("search_results_footer");
        }*/
    });
}
function play_game() {
    window.open('http://localhost:5000', '_blank');
}

function addOrDeleteFriend(current_email, friend_email) {
    url_controller = "../handlers/follow_friend.php";
    parameters = {
        current_email_p: current_email,
        friend_email_p: friend_email
    };
    $.post(url_controller, parameters, function () {
        var userNameDiv = document.createElement('div');
        userNameDiv.setAttribute('id', "addedFriendCongrats");
        var congratsMsg = document.createElement('p');
        congratsMsg.innerHTML = "Congrats! you and " + friend_email + ",\nare friends now!";
        userNameDiv.appendChild(congratsMsg);
        $("#friendsResult").append(userNameDiv);
    });
}