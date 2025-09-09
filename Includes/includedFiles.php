<?php
// If request was sent with AJAX not manually typing url
if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    include_once("Includes/config.php");
    include_once("Includes/classes/User.php");
    include_once("Includes/classes/Artist.php");
    include_once("Includes/classes/Album.php");
    include_once("Includes/classes/Song.php");
    include_once("Includes/classes/Playlist.php");

    if (isset($_GET['userLoggedIn'])) {
        $userLoggedIn = new User($con, $_GET['userLoggedIn']);
    } else if (isset($_SESSION['isGuest']) && $_SESSION['isGuest'] === true) {
        $userLoggedIn = null;
    } else {
        echo "username not passed";
        exit(); //Don't load rest of the page
    }
} else { // manually url or pressed on link
    include_once("Includes/header.php");
    include_once("Includes/footer.php");
    $url = $_SERVER['REQUEST_URI'];
    echo "<script>openPage('$url')</script>";
    // To prevent from executing the if condition again after loading content with AJAX
    exit();
}
?>