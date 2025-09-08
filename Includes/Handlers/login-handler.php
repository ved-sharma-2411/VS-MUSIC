<?php 
if (!isset($account)) {
    die("Error: Account class is not initialized.");
}
if (isset($_POST["loginButton"])) {
    $username = isset($_POST['loginUsername']) ? $_POST['loginUsername'] : '';
    $password = isset($_POST['loginPassword']) ? $_POST['loginPassword'] : '';

    if (!empty($username) && !empty($password)) {
        $result = $account->login($username, $password);

        if ($result) {
            global $con;
            $query = mysqli_query($con, "SELECT status FROM users WHERE username='$username'");
            $userData = mysqli_fetch_assoc($query);

            if ($userData && $userData['status'] == 'blocked') {
                $loginError = "Your account is blocked. Please contact support.";
            } else {
                $_SESSION['userLoggedIn'] = $username;
                header("Location: index.php");
                exit();
            }
        } else {
            // Separate error messages
            $userCheckQuery = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
            if (mysqli_num_rows($userCheckQuery) == 0) {
                $loginError = "Username not found. Please check your username.";
            } else {
                $loginError = "Incorrect password. Please try again.";
            }
        }
    } else {
        $loginError = "Please fill in all fields.";
    }
}

?>
