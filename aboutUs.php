<?php
include("Includes/includedFiles.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - VS Music</title>
    <style>
        /* 🌑 Dark Spotify Theme */
        body {
            background: #121212;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            padding: 20px;
            overflow-x: hidden;
        }

        /* Ensure only About Us content is centered */
        .about-content {
            text-align: center;
        }

        /* 💎 Glassmorphism Card */
        .container {
            max-width: 900px;
            margin: auto;
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 0 20px rgba(0, 255, 0, 0.5);
            animation: fadeIn 1s ease-in-out;
            position: relative;
            overflow: hidden;
        }

        /* 🎵 Title with Neon Glow */
        h1 {
            font-size: 36px;
            color: #1db954;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0px 0px 10px #1db954;
            animation: neonGlow 1.5s infinite alternate;
        }

        /* ⏳ Timeline Animation */
        .timeline {
            margin-top: 30px;
            position: relative;
        }

        .timeline::before {
            content: "";
            position: absolute;
            width: 4px;
            background: #1db954;
            top: 0;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        .event {
            position: relative;
            width: 50%;
            padding: 12px;
            background: rgba(0, 255, 0, 0.2);
            margin: 15px 0;
            border-radius: 10px;
            backdrop-filter: blur(5px);
            transition: transform 0.3s ease-in-out;
            font-size: 18px;
        }

        .event:hover {
            transform: scale(1.1);
            background: rgba(0, 255, 0, 0.4);
            box-shadow: 0px 0px 20px rgba(0, 255, 0, 0.8);
        }

        .left {
            left: 0;
            text-align: left;
        }

        .right {
            left: 48%;
            text-align: right;
        }

        /* 🔥 Neon Buttons */
        .btn {
            background: #1db954;
            color: black;
            padding: 12px 25px;
            font-weight: bold;
            border-radius: 50px;
            text-transform: uppercase;
            transition: 0.3s ease-in-out;
            border: none;
            box-shadow: 0px 0px 15px #1db954;
            cursor: pointer;
            margin-bottom: 100px;
        }

        .btn:hover {
            background: #0f0;
            box-shadow: 0px 0px 30px #0f0;
            transform: scale(1.1);
        }

        /* ❄️ Snow Effect */
        .snow {
            position: absolute;
            width: 8px;
            height: 8px;
            background: white;
            opacity: 0.8;
            border-radius: 50%;
            top: -20px;
        }

        /* ✨ Keyframe Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes neonGlow {
            from {
                text-shadow: 0px 0px 10px #1db954;
            }

            to {
                text-shadow: 0px 0px 25px #1db954;
            }
        }

        /* 🔗 Contact Section */
        .contact {
            margin-top: 20px;
        }

        .contact a {
            color: #1db954;
            text-decoration: none;
            font-size: 18px;
            transition: color 0.3s, text-shadow 0.3s;
        }

        .contact a:hover {
            color: #0f0;
            text-shadow: 0px 0px 10px #0f0;
        }
    </style>
</head>

<body>

    <!-- 🎼 About Us Content -->
    <div class="about-content">
        <div class="container">
            <h1>Welcome to VS Music 🎶</h1>
            <p>This project, VS MUSIC, was created strictly for academic survival purposes.<br><br>
                In other words: my college asked for a small PHP + MySQL project to award some internal marks, so here
                it is.<br><br>
                You are free to look, fork, or laugh at the code — but please understand this was never meant to be a
                production-ready masterpiece.</p>

            <!-- 🌟 Legendary Timeline -->
            <div class="timeline">
                <div class="event left">🎵 <strong>Inception:</strong> "What if I created my own Spotify?"</div>
                <div class="event right">🛠 <strong>Game On:</strong> PHP & MySQL – The blueprint takes shape!</div>
                <div class="event left">🎨 <strong>Design Unleashed:</strong> Crafting a stunning, immersive UI.</div>
                <div class="event right">💾 <strong>Bringing It to Life:</strong> Building the engine under the hood.
                </div>
                <div class="event left">🚀 <strong>Polish & Perfection:</strong> Debugging, fine-tuning, making it
                    smooth!</div>
                <div class="event right">🎉 <strong>The Grand Finale:</strong> VS Music goes live—time to vibe! 🔥</div>
            </div>
        </div>

        <!-- 📧 Contact Information -->
        <div class="contact">
            <h2>Contact Me</h2>
            <p>Gmail - <a href="mailto:vedsh24y4@gmail.com">vedsh24y4@gmail.com</a></p>
            <p>GitHub - <a href="https://github.com/ved-sharma-2411"
                    target="_blank">https://github.com/ved-sharma-2411</a></p>
            <p>LinkedIn - <a href="https://www.linkedin.com/in/ved-sharma-24y4"
                    target="_blank">www.linkedin.com/in/ved-sharma-24y4</a></p>
        </div>

        <!-- 🚀 Interactive Button -->
        <button class="btn" onclick="window.location.href='browse.php'">Explore More</button>
    </div>
    </div>

    <!-- 🎵 Snow Effect -->
    <script>
        function createSnow() {
            if (document.querySelectorAll('.snow').length > 200) return; // Increased snow limit to 200

            const snow = document.createElement('div');
            snow.classList.add('snow');
            document.body.appendChild(snow);

            // Random size and opacity
            const size = Math.random() * 6 + 4; // Smaller for better effect
            snow.style.width = snow.style.height = `${size}px`;
            snow.style.opacity = Math.random() * 0.8 + 0.2;

            // Random starting position
            snow.style.left = Math.random() * window.innerWidth + 'px';

            // Set faster fall animation
            const fallDuration = Math.random() * 2 + 1; // ⏩ Faster snow speed (1s - 3s)
            snow.style.position = 'fixed'; // Prevents affecting scroll
            snow.style.transition = `transform ${fallDuration}s linear, opacity ${fallDuration}s`;

            // Animate fall
            setTimeout(() => {
                snow.style.transform = `translateY(${window.innerHeight}px)`;
                snow.style.opacity = '0';
            }, 50);

            // Remove after animation
            setTimeout(() => {
                snow.remove();
            }, fallDuration * 1000);
        }

        // Faster snow creation (every 100ms)
        if (window.location.pathname.includes("about")) {
            setInterval(createSnow, 100); // ⏩ More snowflakes
        }

    </script>

</body>

</html>