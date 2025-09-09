<?php
include("Includes/includedFiles.php");

// Check if user is not logged in (not just guest) - show popup
if (!isset($userLoggedIn) || $userLoggedIn == null) {
    echo "<script>
            if (confirm('You need to login to access this feature. Would you like to login now?')) {
                window.location.href = 'login.php?direct=1';
            } else {
                history.back();
            }
        </script>";
    exit();
}
?>

<style>
    /* Main Container */
    .playlistsContainer {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        text-align: center;
        width: 100%;
        opacity: 0;
        animation: fadeIn 1s ease-in-out forwards;
    }

    /* Playlists Grid */
    .gridViewContainer {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        width: 90%;
        margin-top: 20px;
        padding: 20px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        box-shadow: 0 0 15px rgba(0, 255, 0, 0.3);
        transition: transform 0.3s ease-in-out;
    }

    .gridViewContainer:hover {
        transform: scale(1.02);
    }

    /* Playlist Title */
    .gridViewContainer h2 {
        font-size: 26px;
        font-weight: bold;
        letter-spacing: 1.5px;
        color: #1DB954;
        margin-bottom: 15px;
        text-shadow: 0 0 10px rgba(0, 255, 0, 0.6);
    }

    /* Create Playlist Button */
    .button.green {
        background: linear-gradient(45deg, #1DB954, #16a34a);
        border: none;
        padding: 12px 25px;
        font-size: 16px;
        font-weight: bold;
        color: white;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 0 15px rgba(0, 255, 0, 0.5);
    }

    .button.green:hover {
        transform: scale(1.1);
        box-shadow: 0 0 25px rgba(0, 255, 0, 0.8);
    }

    /* Playlist Card */
    .gridViewItem {
        background: rgba(0, 0, 0, 0.6);
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease-in-out;
        cursor: pointer;
        opacity: 0;
        animation: fadeInUp 0.8s ease-in-out forwards;
    }

    .gridViewItem:hover {
        transform: scale(1.05);
        background: rgba(0, 0, 0, 0.8);
        box-shadow: 0 0 20px rgba(0, 255, 0, 0.6);
    }

    /* Playlist Image */
    .playlistImage img {
        width: 100px;
        height: 100px;
        border-radius: 10px;
        transition: transform 0.3s ease-in-out;
    }

    .gridViewItem:hover .playlistImage img {
        transform: rotate(5deg) scale(1.1);
    }

    /* Playlist Name */
    .gridViewInfo {
        margin-top: 10px;
        font-size: 16px;
        font-weight: bold;
        color: #fff;
        transition: color 0.3s ease-in-out;
    }

    .gridViewItem:hover .gridViewInfo {
        color: #1DB954;
    }

    /* No Playlists Text */
    .noResults {
        font-size: 18px;
        color: rgba(255, 255, 255, 0.8);
        margin-top: 20px;
    }

    /* Keyframe Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Mobile responsive styles */
    @media screen and (max-width: 768px) {
        .gridViewContainer {
            width: 95%;
            padding: 15px;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }

        .gridViewContainer h2 {
            font-size: 22px;
        }

        .playlistImage img {
            width: 80px;
            height: 80px;
        }

        .gridViewInfo {
            font-size: 14px;
        }
    }

    @media screen and (max-width: 480px) {
        .gridViewContainer {
            width: 100%;
            padding: 10px;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 10px;
        }

        .gridViewContainer h2 {
            font-size: 20px;
        }

        .gridViewItem {
            padding: 15px;
        }

        .playlistImage img {
            width: 60px;
            height: 60px;
        }

        .gridViewInfo {
            font-size: 12px;
            margin-top: 8px;
        }

        .button.green {
            padding: 10px 20px;
            font-size: 14px;
        }
    }
</style>

<div class="playlistsContainer">
    <div class="gridViewContainer">
        <h2>PLAYLISTS</h2>
        <div class="buttonItems">
            <button class="button green" onclick="createPlaylist('asdsadsad');">CREATE PLAYLIST</button>
        </div>

        <?php
        $username = $userLoggedIn->getUsername();
        $playlistsQuery = mysqli_query($con, "SELECT * FROM playlists WHERE owner='$username'");

        if (mysqli_num_rows($playlistsQuery) == 0) {
            echo "<p class='noResults'>You do not have any playlists.</p>";
        }

        while ($row = mysqli_fetch_array($playlistsQuery)) {
            $playlist = new Playlist($con, $row);

            echo "<div class='gridViewItem pointer' onclick='openPage(\"playlist.php?id=" . $playlist->getId() . "\")'>
                            <div class='playlistImage'>
                                <img src='assets/images/Icons/playlist2.png'>
                            </div>
                            <div class='gridViewInfo'>"
                . $playlist->getName() .
                "</div>
                        </div>";
        }
        ?>
    </div>
</div>