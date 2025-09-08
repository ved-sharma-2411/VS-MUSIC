<div id="navBarContainer">
    <nav class="navBar">
        <span onclick="openPage('aboutUs.php');" class="logo">
            <img class="Hello" src="assets/images/Icons/Logo.png" alt="Logo">
            <span class="logoText">VS MUSIC</span>
        </span>

        <div class="group">
            <div class="navItem" id="navItemSearch">
                <span onclick="openPage('search.php');" class="navItemLink">
                    <span class="clickableArea">Search
                        <img src="assets/images/Icons/search.png" alt="Search" class="icon">
                    </span>
                </span>
            </div>
        </div>

        <div class="group">
            <div class="navItem">
                <span onclick="openPage('browse.php');" class="navItemLink">Browse</span>
            </div>

            <div class="navItem">
                <span onclick="openPage('topRated.php');" class="navItemLink">Top 10</span>
            </div>

            <div class="navItem">
                <span onclick="openPage('yourMusic.php');" class="navItemLink">Your Music</span>
            </div>

            <div class="navItem">
                <span onclick="openPage('settings.php');" class="navItemLink">
                    <?php echo $userLoggedIn->getName(); ?>
                </span>
            </div>
        </div>
    </nav>
</div>

<style>
    .logo {
        display: flex;
        align-items: center;
        gap: 10px;
        /* Adjust spacing */
    }

    /* RGB Flow Effect on VS MUSIC */
    .logoText {
        font-size: 18px;
        /* Kept original size */
        font-weight: bold;
        color: white;
        /* Kept original color */
        background-image: linear-gradient(90deg, red, orange, yellow, green, blue, indigo, violet);
        background-size: 300% 300%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: rgbFlow 3s infinite linear;
    }

    @keyframes rgbFlow {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    /* Hover Animations for Menu Items */
    .navItemLink {
        transition: color 0.3s ease, text-shadow 0.3s ease, transform 0.3s ease;
    }

    .navItemLink:hover {
        color: #1DB954;
        /* Spotify green (same as search) */
        text-shadow: 0 0 10px rgba(29, 185, 84, 0.8);
        /* Green glow effect */
        transform: scale(1.05);
        /* Subtle zoom effect */
    }

    /* Search Icon Animation */
    .icon {
        transition: transform 0.3s ease, filter 0.3s ease;
    }

    .navItemLink:hover .icon {
        transform: rotate(15deg) scale(1.1);
        /* Rotates & enlarges slightly */
        filter: drop-shadow(0 0 5px rgba(255, 255, 255, 0.8));
        /* Adds glow */
    }

    .clickableArea {
        display: flex;
        align-items: center;
        gap: 10px;
        /* Ensures space between text and icon is part of the clickable area */
        padding: 5px 10px;
        /* Adds extra space for easier clicking */
    }
</style>