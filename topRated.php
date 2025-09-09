<?php
include("Includes/includedFiles.php");
include("Includes/config.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top 10 Songs</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Main Container */
        .tracklistContainer {
            width: 100%;
            margin: auto;
            color: white;
            opacity: 0;
            animation: fadeIn 1s ease-in-out forwards;
            padding: 20px;
        }

        /* Mobile responsive for main container */
        @media screen and (max-width: 768px) {
            .tracklistContainer {
                padding: 15px;
            }
        }

        @media screen and (max-width: 480px) {
            .tracklistContainer {
                padding: 10px;
            }
        }

        /* Heading Animation */
        .topRatedHeading {
            text-align: center;
            font-size: 30px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 3px;
            background: linear-gradient(90deg, #ff00ff, #00ffff, #1DB954, #ff0000);
            background-size: 400% 400%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            opacity: 0;
            animation: glowingText 5s linear infinite, slideDown 1.2s ease-in-out forwards, bounceText 2s ease-in-out infinite;
            text-shadow: 0px 0px 10px rgba(255, 255, 255, 0.4);
        }

        /* Mobile responsive for heading */
        @media screen and (max-width: 768px) {
            .topRatedHeading {
                font-size: 24px;
                letter-spacing: 2px;
            }
        }

        @media screen and (max-width: 480px) {
            .topRatedHeading {
                font-size: 20px;
                letter-spacing: 1px;
            }
        }

        /* RGB Gradient Animation */
        @keyframes glowingText {
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

        /* Slide Down Entrance */
        @keyframes slideDown {
            from {
                transform: translateY(-30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Bounce Effect */
        @keyframes bounceText {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        /* Tracklist Styling */
        .tracklist {
            list-style: none;
            padding: 0;
        }

        .tracklistRow {
            display: flex;
            align-items: center;
            padding: 15px;
            margin-right: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: transform 0.2s ease-in-out, background 0.2s ease-in-out;
            opacity: 0;
            animation: fadeInTrack 0.8s ease-in-out forwards;
        }

        .tracklistRow:hover {
            background: rgba(255, 255, 255, 0.1);
            cursor: pointer;
            transform: scale(1.02);
            box-shadow: 0px 0px 15px rgba(255, 255, 255, 0.2);
        }

        /* Play Button Animation */


        .tracklistRow:hover .play {
            transform: scale(1.2);
        }

        /* Track Count */
        .trackCount {
            display: flex;
            align-items: center;
            width: 100px;
            margin-right: -70px;
        }

        .trackNumber {
            margin-right: 10px;
            font-weight: bold;
        }

        /* Artist Image */
        .artistImageContainer {
            display: flex;
            align-items: center;
            margin-right: 15px;
        }

        /* Mobile responsive for artist image container */
        @media screen and (max-width: 768px) {
            .artistImageContainer {
                margin-right: 10px;
            }
        }

        @media screen and (max-width: 480px) {
            .artistImageContainer {
                margin-right: 8px;
            }
        }

        .artistImage {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            transition: transform 0.2s ease-in-out;
        }

        /* Mobile responsive for artist image */
        @media screen and (max-width: 768px) {
            .artistImage {
                width: 35px;
                height: 35px;
            }
        }

        @media screen and (max-width: 480px) {
            .artistImage {
                width: 30px;
                height: 30px;
            }
        }

        .tracklistRow:hover .artistImage {
            transform: rotate(5deg) scale(1.1);
        }

        /* Track Info */
        .trackInfo {
            flex: 1;
            min-width: 0;
        }

        /* Mobile responsive for track info */
        @media screen and (max-width: 768px) {
            .trackInfo {
                padding-left: 10px;
            }
        }

        @media screen and (max-width: 480px) {
            .trackInfo {
                padding-left: 15px;
            }
        }

        .trackName {
            font-size: 16px;
            font-weight: bold;
            display: block;
            transition: color 0.2s ease-in-out;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Mobile responsive for track name */
        @media screen and (max-width: 768px) {
            .trackName {
                font-size: 14px;
            }
        }

        @media screen and (max-width: 480px) {
            .trackName {
                font-size: 13px;
            }
        }

        .tracklistRow:hover .trackName {
            color: #1DB954;
        }

        .artistName {
            font-size: 14px;
            color: gray;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Mobile responsive for artist name */
        @media screen and (max-width: 768px) {
            .artistName {
                font-size: 12px;
            }
        }

        @media screen and (max-width: 480px) {
            .artistName {
                font-size: 11px;
            }
        }

        /* More Options Button */
        .trackOptions {
            margin-left: 10px;
        }

        .optionButton {
            width: 18px;
            transition: transform 0.2s ease-in-out;
        }

        .tracklistRow:hover .optionButton {
            transform: rotate(90deg);
        }

        /* Track Duration */
        .trackDuration {
            margin-left: auto;
            padding-right: 10px;
        }

        /* Animations */
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

        @keyframes fadeInTrack {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Pulse Effect for Playing Track */
        .playing .trackName {
            animation: pulse 1.5s infinite alternate ease-in-out;
        }

        @keyframes pulse {
            from {
                color: white;
            }

            to {
                color: #1DB954;
            }
        }

        /* Mobile responsive styles */
        @media screen and (max-width: 768px) {
            .tracklistContainer {
                margin: 15px;
                padding: 15px;
            }

            .topRatedHeading {
                font-size: 24px;
                margin-top: 30px;
                letter-spacing: 2px;
            }

            .tracklistRow {
                padding: 12px 8px;
                gap: 8px;
            }

            .trackCount {
                width: 15%;
            }

            .artistImageContainer {
                margin-right: 8px;
            }

            .artistImage {
                width: 35px;
                height: 35px;
            }

            .trackInfo {
                flex: 1;
            }

            .trackName {
                font-size: 14px;
            }

            .artistName {
                font-size: 12px;
            }

            .trackOptions {
                margin-left: 5px;
            }

            .optionButton {
                width: 15px;
            }

            .trackDuration {
                padding-right: 5px;
                font-size: 12px;
            }
        }

        @media screen and (max-width: 480px) {
            .tracklistContainer {
                margin: 10px;
                padding: 10px;
            }

            .topRatedHeading {
                font-size: 20px;
                margin-top: 20px;
                letter-spacing: 1px;
            }

            .tracklistRow {
                padding: 10px 5px;
                gap: 5px;
            }

            .trackCount {
                width: 18%;
            }

            .artistImage {
                width: 30px;
                height: 30px;
            }

            .trackName {
                font-size: 13px;
                margin-bottom: 3px;
            }

            .artistName {
                font-size: 11px;
            }

            .optionButton {
                width: 12px;
            }

            .trackDuration {
                font-size: 11px;
            }

            .play {
                width: 15px;
                height: 15px;
            }
        }
    </style>
</head>

<body>

    <h2 class="topRatedHeading">TOP 10 SONGS </h2>
    <div class="tracklistContainer">
        <ul class="tracklist">
            <?php
            $songsQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY plays DESC LIMIT 10");
            $songIdArray = array();
            while ($row = mysqli_fetch_array($songsQuery)) {
                array_push($songIdArray, $row['id']);
            }

            $count = 1;
            foreach ($songIdArray as $songId) {
                $albumSong = new Song($con, $songId);
                $albumArtist = $albumSong->getArtist();
                $artistName = $albumArtist->getName();

                // Construct the correct image filename
            

                echo "<li class='tracklistRow' data-song-id='" . $albumSong->getId() . "'>
                            <div class='trackCount'>
                                <img class='play' src='assets/images/Icons/play-white.png'>
                                <span class='trackNumber'>$count.</span>
                            </div>
                            <div class='artistImageContainer'>
                            </div>
                            <div class='trackInfo'>
                                <span class='trackName'>" . $albumSong->getTitle() . "</span>
                                <span class='artistName'>" . $artistName . "</span>
                            </div>
                            <div class='trackOptions'>
                                <input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
                                <img class='optionButton' src='assets/images/Icons/more.png' onclick='showOptionsMenu(this)'>
                            </div>
                            <div class='trackDuration'>
                                <span class='duration'>" . $albumSong->getDuration() . "</span>
                            </div>  
                        </li>";

                $count += 1;
            }
            ?>

            <script>
                var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
                tempPlaylist = JSON.parse(tempSongIds);

                document.querySelectorAll('.tracklistRow').forEach(row => {
                    row.addEventListener('click', function (event) {
                        if (event.target.closest('.optionButton')) return;
                        document.querySelectorAll('.tracklistRow').forEach(r => r.classList.remove('playing'));
                        this.classList.add('playing');
                        setTrack(this.getAttribute('data-song-id'), tempPlaylist, true);
                    });
                });
            </script>
        </ul>
    </div>

    <nav class="optionsMenu">
        <input type="hidden" class="songId">
        <?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
    </nav>

    <script src="script.js"></script>

</body>

</html>