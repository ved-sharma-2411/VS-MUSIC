<?php
include("Includes/includedFiles.php");
?>

<style>
    /* Glassmorphism Container */
    .userDetails {
        width: 90%;
        max-width: 500px;
        margin: auto;
        padding: 30px;
        background: rgba(20, 20, 20, 0.8);
        /* Darker background */
        border-radius: 15px;
        box-shadow: 0px 8px 32px rgba(0, 255, 0, 0.1);
        /* Subtle glow */
        backdrop-filter: blur(10px);
        text-align: center;
        color: #ddd;
        animation: fadeIn 1s ease-in-out;
    }

    /* Section Styling */
    .container {
        margin-bottom: 20px;
        padding: 20px;
        border-radius: 10px;
        background: rgba(30, 30, 30, 0.6);
        /* Darker background */
        box-shadow: 0 5px 15px rgba(0, 255, 0, 0.1);
        /* Softer glow */
        transition: 0.3s ease-in-out;
    }

    .container:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 20px rgba(0, 255, 0, 0.2);
        /* Slight glow effect */
    }

    /* Headings */
    h2 {
        font-size: 18px;
        font-weight: bold;
        text-transform: uppercase;
        color: #00ff7f;
        letter-spacing: 1.2px;
        margin-bottom: 10px;
        opacity: 0.9;
    }

    /* Input Fields */
    input {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        color: white;
        background: rgba(0, 0, 0, 0.5);
        /* Dark input background */
        border: 1px solid rgba(0, 255, 0, 0.3);
        border-radius: 8px;
        outline: none;
        transition: 0.3s ease-in-out;
    }

    input::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }

    input:focus {
        border-color: #00ff7f;
        box-shadow: 0px 0px 8px rgba(0, 255, 0, 0.5);
    }

    /* Buttons */
    .button {
        width: 100%;
        padding: 12px;
        margin-top: 10px;
        font-size: 16px;
        font-weight: bold;
        color: white;
        background: linear-gradient(90deg, #006400, #00ff7f);
        border: none;
        border-radius: 25px;
        cursor: pointer;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .button:hover {
        transform: scale(1.05);
        box-shadow: 0px 5px 15px rgba(0, 255, 0, 0.3);
    }

    /* Message Styling */
    .message {
        display: block;
        font-size: 14px;
        margin-top: 5px;
        color: #00ff7f;
        opacity: 0.8;
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Mobile responsive styles */
    @media screen and (max-width: 768px) {
        .userDetails {
            width: 95%;
            padding: 25px;
        }

        .container {
            padding: 15px;
            margin-bottom: 15px;
        }

        h2 {
            font-size: 16px;
        }

        input {
            padding: 10px;
            font-size: 14px;
        }

        .button {
            padding: 10px;
            font-size: 14px;
        }
    }

    @media screen and (max-width: 480px) {
        .userDetails {
            width: 100%;
            padding: 20px;
        }

        .container {
            padding: 12px;
            margin-bottom: 12px;
        }

        h2 {
            font-size: 14px;
            margin-bottom: 8px;
        }

        input {
            padding: 8px;
            font-size: 13px;
        }

        .button {
            padding: 8px;
            font-size: 13px;
        }

        .message {
            font-size: 12px;
        }
    }
</style>

<div class="userDetails">
    <div class="container">
        <h2>EMAIL</h2>
        <input type="email" class="email" name="email" placeholder="Email address..."
            value="<?php echo $userLoggedIn->getEmail(); ?>">
        <span class="message"></span>
        <button class="button" onclick="updateEmail('email')">SAVE</button>
    </div>

    <div class="container">
        <h2>PASSWORD</h2>
        <input type="password" class="oldPassword" name="oldPassword" placeholder="Current password">
        <input type="password" class="newPassword1" name="newPassword1" placeholder="New password">
        <input type="password" class="newPassword2" name="newPassword2" placeholder="Confirm password">
        <span class="message"></span>
        <button class="button" onclick="updatePassword('oldPassword','newPassword1','newPassword2')">SAVE</button>
    </div>
</div>