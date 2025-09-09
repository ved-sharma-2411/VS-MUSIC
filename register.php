<?php
session_start();
include("Includes/config.php");
include("Includes/classes/Account.php");
include("Includes/classes/Constants.php");
$account = new Account($con);
include("Includes/Handlers/register-handler.php");
include("Includes/Handlers/login-handler.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VS Music - Register</title>
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
            transition: transform 0.2s ease;
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

        .errorMessage {
            color: #ff4c4c;
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Register</h2>
        <form action="register.php" method="POST">

            <!-- Username -->
            <?php echo $account->getError(Constants::$usernameCharacters); ?>
            <?php echo $account->getError(Constants::$usernameTaken); ?>
            <div class="input-group">
                <input type="text" id="username" name="username" required>
                <label for="username">Username</label>
            </div>

            <!-- First Name -->
            <?php echo $account->getError(Constants::$firstNameCharacters); ?>
            <div class="input-group">
                <input type="text" id="firstName" name="firstName" required>
                <label for="firstName">First Name</label>
            </div>

            <!-- Last Name -->
            <?php echo $account->getError(Constants::$lastNameCharacters); ?>
            <div class="input-group">
                <input type="text" id="lastName" name="lastName" required>
                <label for="lastName">Last Name</label>
            </div>

            <!-- Email -->
            <?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
            <?php echo $account->getError(Constants::$emailInvalid); ?>
            <?php echo $account->getError(Constants::$emailTaken); ?>
            <div class="input-group">
                <input type="email" id="email" name="email" required>
                <label for="email">Email</label>
            </div>
            <div class="input-group">
                <input type="email" id="email2" name="email2" required>
                <label for="email2">Confirm Email</label>
            </div>

            <!-- Password -->
            <?php echo $account->getError(Constants::$passwordsDoNoMatch); ?>
            <?php echo $account->getError(Constants::$passwordNotAlphanumeric); ?>
            <?php echo $account->getError(Constants::$passwordCharacters); ?>
            <div class="input-group">
                <input type="password" id="password" name="password" required>
                <label for="password">Password</label>
            </div>
            <div class="input-group">
                <input type="password" id="password2" name="password2" required>
                <label for="password2">Confirm Password</label>
            </div>

            <!-- Submit -->
            <button type="submit" name="registerButton" class="btn">Sign Up</button>
            <p class="toggle-link" onclick="toggleForm()">Already have an account? Log In</p>
        </form>
    </div>

    <script>
        function toggleForm() {
            window.location.href = "login.php";
        }
    </script>
</body>

</html>