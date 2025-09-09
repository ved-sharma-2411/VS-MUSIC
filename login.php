<?php
session_start();
include("Includes/config.php");
include("Includes/classes/Account.php");
include("Includes/classes/Constants.php");

// Check if coming from popup
$showPopup = !isset($_SESSION['userLoggedIn']) && !isset($_SESSION['isGuest']) && !isset($_GET['direct']);

// ✅ Initialize the Account object before including login-handler.php
$account = new Account($con);

include("Includes/Handlers/register-handler.php");
include("Includes/Handlers/login-handler.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VS Music - Login</title>
    <link rel="stylesheet" href="assets/css/register.css">
    <link rel="icon" type="image/png" href="assets/images/Icons/Logo.png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1DB954, #191414);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .container {
            width: 400px;
            background: rgba(0, 0, 0, 0.9);
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            animation: slideIn 0.5s ease-in-out;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        h2 {
            color: #1DB954;
            margin-bottom: 20px;
        }

        .input-group {
            position: relative;
            margin: 20px 0;
        }

        input {
            width: 100%;
            padding: 12px;
            background: transparent;
            border: 2px solid #1DB954;
            border-radius: 8px;
            color: #fff;
            outline: none;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        input:focus {
            border-color: #1ed760;
            box-shadow: 0 0 10px #1ed760;
        }

        .input-group label {
            position: absolute;
            top: 12px;
            left: 12px;
            color: rgba(255, 255, 255, 0.5);
            transition: 0.3s ease;
        }

        input:focus+label,
        input:valid+label {
            top: -17px;
            font-size: 14px;
            color: #1DB954;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(45deg, #1DB954, #1ed760);
            border: none;
            border-radius: 8px;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            transition: transform 0.2s ease, background 0.3s ease;
        }

        .btn:hover {
            background: linear-gradient(45deg, #1ed760, #1DB954);
            transform: scale(1.05);
        }

        .toggle-link {
            color: #1DB954;
            cursor: pointer;
            margin-top: 10px;
            display: inline-block;
            transition: 0.3s ease;
        }

        .toggle-link:hover {
            color: #1ed760;
        }

        .social-icons {
            margin-top: 20px;
        }

        .social-icons a {
            color: #fff;
            margin: 0 10px;
            font-size: 24px;
            transition: transform 0.3s ease, color 0.3s ease;
        }

        .social-icons a:hover {
            transform: scale(1.2);
            color: #1ed760;
        }

        /* Mobile responsive styles */
        @media screen and (max-width: 768px) {
            .container {
                width: 350px;
                padding: 25px;
            }

            h2 {
                font-size: 24px;
                margin-bottom: 15px;
            }

            input {
                padding: 10px;
                font-size: 14px;
            }

            .btn {
                padding: 10px;
                font-size: 16px;
            }
        }

        @media screen and (max-width: 480px) {
            body {
                padding: 10px;
            }

            .container {
                width: 90%;
                max-width: 320px;
                padding: 20px;
            }

            h2 {
                font-size: 22px;
            }

            input {
                padding: 8px;
                font-size: 13px;
            }

            .btn {
                padding: 8px;
                font-size: 14px;
            }

            .toggle-link {
                font-size: 14px;
            }

            .social-icons a {
                font-size: 20px;
                margin: 0 8px;
            }
        }

        /* Popup Styles */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .popup-content {
            background: linear-gradient(135deg, #1DB954, #191414);
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 0 30px rgba(29, 185, 84, 0.3);
            animation: popupSlideIn 0.5s ease-out;
        }

        @keyframes popupSlideIn {
            from {
                transform: scale(0.8) translateY(-30px);
                opacity: 0;
            }

            to {
                transform: scale(1) translateY(0);
                opacity: 1;
            }
        }

        .popup-content h2 {
            color: #fff;
            margin-bottom: 15px;
            font-size: 24px;
        }

        .popup-content p {
            color: #fff;
            margin-bottom: 25px;
            font-size: 16px;
            line-height: 1.5;
        }

        .popup-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .btn-yes,
        .btn-no {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .btn-yes {
            background: #fff;
            color: #1DB954;
        }

        .btn-yes:hover {
            background: #f0f0f0;
            transform: scale(1.05);
        }

        .btn-no {
            background: transparent;
            color: #fff;
            border: 2px solid #fff;
        }

        .btn-no:hover {
            background: #fff;
            color: #1DB954;
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <!-- Login Popup Modal -->
    <?php if ($showPopup): ?>
        <div id="loginPopup" class="popup-overlay">
            <div class="popup-content">
                <h2>Welcome to VS MUSIC</h2>
                <p>Login to store history, create playlists, and enhance your music experience!</p>
                <div class="popup-buttons">
                    <button onclick="proceedToLogin()" class="btn-yes">Yes, Login</button>
                    <button onclick="continueAsGuest()" class="btn-no">No Thanks</button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="container">
        <h2>Login</h2>
        <?php if (!empty($loginError)) { ?>
            <p style="color: red; margin-bottom: 15px;"><?php echo $loginError; ?></p>
        <?php } ?>

        <form action="" method="POST" id="loginForm">
            <div class="input-group">
                <input type="text" id="loginUsername" name="loginUsername" required>
                <label for="loginUsername">Username</label>
            </div>
            <div class="input-group">
                <input type="password" id="loginPassword" name="loginPassword" required>
                <label for="loginPassword">Password</label>
            </div>
            <button type="submit" name="loginButton" class="btn">Log In</button>
            <p class="toggle-link" onclick="toggleForm()">Don't have an account? Sign Up</p>
        </form>
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-google"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
        </div>
    </div>

    <script>
        function toggleForm() {
            window.location.href = "register.php";
        }

        function proceedToLogin() {
            document.getElementById('loginPopup').style.display = 'none';
        }

        function continueAsGuest() {
            window.location.href = 'guest.php';
        }

        <?php if ($showPopup): ?>
            // Show popup on page load
            window.onload = function () {
                document.getElementById('loginPopup').style.display = 'flex';
            };
        <?php endif; ?>
    </script>
</body>

</html>