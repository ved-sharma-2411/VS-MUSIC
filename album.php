<?php
include("Includes/includedFiles.php");

if (isset($_GET['id'])) {
    $albumId = $_GET['id'];
} else {
    header("Location: index.php");
}

$album = new Album($con, $albumId);

$artist = $album->getArtist();
$artistId = $artist->getId();
?>

<button class="back-button" onclick="history.back();">← Back</button>

<style>
    /* Back Button Styles */
    .back-button {
        display: none;
        position: fixed;
        top: 15px;
        left: 60px;
        background: rgba(29, 185, 84, 0.9);
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 20px;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
        z-index: 1001;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .back-button:hover {
        background: rgba(29, 185, 84, 1);
        transform: scale(1.05);
    }

    @media screen and (max-width: 768px) {
        .back-button {
            display: block;
        }
    }

    /* Left Section Animation */
    .leftSection img {
        width: 200px;
        border-radius: 10px;
        box-shadow: 0px 0px 15px rgba(255, 255, 255, 0.2);
        transition: transform 0.3s ease-in-out;
    }

    .leftSection img:hover {
        transform: scale(1.05);
    }

    /* Right Section Animation */
    .rightSection h2 {
        font-size: 26px;
        font-weight: bold;
        opacity: 0;
        animation: slideDown 0.8s ease-in-out forwards;
    }

    .rightSection p {
        font-size: 16px;
        color: gray;
        cursor: pointer;
        transition: color 0.3s ease-in-out;
    }

    .rightSection p:hover {
        color: #1DB954;
    }

    /* Tracklist Animation */
    .tracklistContainer {
        width: 100%;
        margin: auto;
        color: white;
        opacity: 0;
        animation: fadeIn 1s ease-in-out forwards;
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

    /* Mobile responsive for track row hover */
    @media screen and (max-width: 768px) {
        .tracklistRow:hover {
            transform: scale(1.01);
        }
    }

    .tracklistRow:hover .play {
        transform: scale(1.2);
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

    .optionButton {
        width: 18px;
        transition: transform 0.2s ease-in-out;
    }

    /* Mobile responsive for option button */
    @media screen and (max-width: 480px) {
        .optionButton {
            width: 16px;
        }
    }

    .tracklistRow:hover .optionButton {
        transform: rotate(90deg);
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

    /* Playing Track Pulse Effect */
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
        .entityInfo {
            flex-direction: column;
            text-align: center;
            padding: 60px 20px 20px 20px;
        }

        .leftSection {
            width: 100% !important;
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }

        .leftSection img {
            width: 200px;
            max-width: 200px;
        }

        .rightSection {
            width: 100% !important;
            padding: 0 !important;
            text-align: center;
        }

        .rightSection h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .rightSection p {
            font-size: 16px;
            margin: 8px 0;
        }

        .tracklistContainer {
            padding: 0 15px;
        }

        .tracklistRow {
            padding: 12px 8px;
            display: flex;
            align-items: center;
        }

        .tracklistRow .trackCount {
            width: 50px;
            flex: 0 0 50px;
        }

        .tracklistRow .trackInfo {
            flex: 1;
            min-width: 0;
        }

        .tracklistRow .trackOptions {
            width: 40px;
            flex: 0 0 40px;
            text-align: center;
        }

        .tracklistRow .trackDuration {
            width: 50px;
            flex: 0 0 50px;
            text-align: right;
        }

        .trackName {
            font-size: 15px;
            line-height: 1.3;
        }

        .artistName {
            font-size: 13px;
        }

        .trackInfo .albumName {
            display: block;
            font-size: 12px;
            color: #999;
            margin-top: 2px;
        }

        /* Show album name on mobile/tablet */
        @media screen and (max-width: 768px) {
            .trackInfo .albumName {
                display: block;
            }
        }
    }

    @media screen and (max-width: 480px) {
        .entityInfo {
            padding: 55px 15px 15px 15px;
        }

        .leftSection img {
            width: 160px;
            max-width: 160px;
        }

        .rightSection h2 {
            font-size: 22px;
        }

        .rightSection p {
            font-size: 14px;
        }

        .tracklistContainer {
            padding: 0 10px;
        }

        .tracklistRow {
            padding: 10px 5px;
        }

        .tracklistRow .trackCount {
            width: 40px;
            flex: 0 0 40px;
        }

        .tracklistRow .trackDuration {
            width: 45px;
            flex: 0 0 45px;
        }

        .trackName {
            font-size: 14px;
        }

        .artistName {
            font-size: 12px;
        }

        .trackInfo .albumName {
            display: block;
            font-size: 11px;
            color: #999;
            margin-top: 2px;
        }

        /* Hide album name on desktop, show only on mobile/tablet */
        .trackInfo .albumName {
            display: none;
        }

        .optionButton {
            width: 15px;
        }

        .play img {
            width: 16px;
            height: 16px;
        }
    }
</style>

<div class="entityInfo">
    <div class="leftSection">
        <img src="<?php echo $album->getArtworkPath(); ?>" alt="Album">
    </div>

    <div class="rightSection">
        <h2><?php echo $album->getTitle(); ?></h2>
        <p class="pointer" onclick="openPage('artist.php?id=<?php echo $artistId; ?>')">By
            <?php echo $artist->getName(); ?>
        </p>
        <p><?php echo $album->getNumberOfSongs(); ?> songs</p>
    </div>
</div>

<div class="tracklistContainer">
    <ul class="tracklist">
        <?php
        $songIdArray = $album->getSongIds();

        $count = 1;
        foreach ($songIdArray as $songId) {
            $albumSong = new Song($con, $songId);
            $albumArtist = $albumSong->getArtist();

            echo "<li class='tracklistRow pointer' data-song-id='" . $albumSong->getId() . "'>
                            <div class='trackCount'>
                                <img class='play' src='assets/images/Icons/play-white.png'>
                                <span class='trackNumber'>$count.</span>
                            </div>
                            <div class='trackInfo'>
                                <span class='trackName'>" . $albumSong->getTitle() . "</span>
                                <span class='artistName'>" . $albumArtist->getName() . "</span>
                            </div>
                            <div class='trackOptions'>
                                <input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
                                <img class='optionButton' src='assets/images/Icons/more.png' onclick='showOptionsMenu(this)'>
                            </div>
                            <div class='trackDuration'>
                                <span class='duration'>" . $albumSong->getDuration() . "</span>
                            </div>  
                        </li>";

            $count++;
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