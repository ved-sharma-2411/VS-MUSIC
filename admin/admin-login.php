<?php
session_start();

// ✅ Admin credentials
$admin_username = "vedadmin";
$admin_password = "vedadmin24y4@";

// ✅ Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['loginUsername'];
    $password = $_POST['loginPassword'];

    // ✅ Verify admin credentials
    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header("Location: admin.php");
        exit();
    } else {
        $error = "Invalid Admin Credentials!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Login</title>
    <link rel="icon" type="image/png" href="Logo.png">
    <link rel="stylesheet" href="assets/css/register.css">

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

        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Admin Login</h2>
        <?php if (isset($error)) {
            echo "<p class='error'>$error</p>";
        } ?>
        <form action="" method="POST">
            <div class="input-group">
                <input type="text" id="loginUsername" name="loginUsername" required>
                <label for="loginUsername">Username</label>
            </div>
            <div class="input-group">
                <input type="password" id="loginPassword" name="loginPassword" required>
                <label for="loginPassword">Password</label>
            </div>
            <button type="submit" name="loginButton" class="btn">Log In</button>
        </form>
    </div>
</body>

</html>