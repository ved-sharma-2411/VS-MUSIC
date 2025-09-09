<?php
include("Includes/includedFiles.php");

if (isset($_GET['id'])) {
    $playlistId = $_GET['id'];
} else {
    header("Location: index.php");
}

$playlist = new Playlist($con, $playlistId);
$owner = new User($con, $playlist->getOwner());
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

    /* 🔥 Playlist Image Animation */
    .playlistImage img {
        width: 150px;
        height: 150px;
        border-radius: 15px;
        transition: transform 0.5s ease-in-out, box-shadow 0.4s ease-in-out;
        box-shadow: 0 0 15px rgba(0, 255, 0, 0.5);
        animation: fadeIn 1s ease-in-out;
    }

    .playlistImage img:hover {
        transform: scale(1.1) rotate(3deg);
        box-shadow: 0 0 35px rgba(0, 255, 0, 1);
    }

    /* 🔥 Playlist Title & Owner */
    .rightSection h2 {
        font-size: 26px;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        animation: slideUp 0.8s ease-in-out;
    }

    .rightSection p {
        font-size: 16px;
        color: #bbb;
        transition: color 0.3s ease-in-out;
    }

    .rightSection p:hover {
        color: #0f0;
    }

    /* 🟢 Delete Playlist Button */
    .button {
        background-color: #0f0;
        color: black;
        font-weight: bold;
        padding: 10px 20px;
        border-radius: 25px;
        text-transform: uppercase;
        transition: transform 0.3s ease-in-out, background-color 0.3s ease-in-out;
        animation: fadeIn 1.5s ease-in-out;
    }

    .button:hover {
        transform: scale(1.1);
        background-color: #080;
        color: white;
    }

    /* 🎭 Tracklist Animation */
    .tracklistRow {
        opacity: 0;
        transform: translateY(20px);
        animation: slideUp 0.6s ease-in-out forwards;
        cursor: pointer;
    }

    .tracklistRow:nth-child(odd) {
        animation-delay: 0.2s;
    }

    .tracklistRow:nth-child(even) {
        animation-delay: 0.4s;
    }

    /* 🟢 Track Hover Effect */
    .tracklistRow:hover {
        background: rgba(0, 255, 0, 0.2);
        transition: background 0.3s ease-in-out;
    }

    /* Mobile responsive for track row hover */
    @media screen and (max-width: 768px) {
        .tracklistRow:hover {
            background: rgba(0, 255, 0, 0.15);
        }
    }

    /* 🎵 Play Button Enhancement */
    .play {
        transition: transform 0.3s ease-in-out;
    }

    .tracklistRow:hover .play {
        transform: scale(1.2);
    }

    /* Mobile responsive for play button */
    @media screen and (max-width: 768px) {
        .tracklistRow:hover .play {
            transform: scale(1.1);
        }
    }

    /* 📜 Song Name Hover Effect */
    .trackName {
        transition: color 0.3s ease-in-out;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .trackName:hover {
        color: #0f0;
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

    /* 🔄 Keyframe Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Mobile responsive styles */
    @media screen and (max-width: 768px) {
        .entityInfo {
            padding: 60px 20px 20px 20px;
            flex-direction: column;
            text-align: center;
        }

        .leftSection {
            width: 100% !important;
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }

        .playlistImage img {
            width: 140px;
            height: 140px;
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

        .button {
            padding: 12px 25px;
            font-size: 16px;
            margin-top: 15px;
        }

        .tracklistContainer {
            padding: 0 15px;
        }

        .tracklistRow {
            padding: 12px 8px;
            display: flex;
            align-items: center;
        }

        .trackCount {
            width: 50px;
            flex: 0 0 50px;
        }

        .trackInfo {
            flex: 1;
            min-width: 0;
        }

        .trackOptions {
            width: 40px;
            flex: 0 0 40px;
            text-align: center;
        }

        .trackDuration {
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
    }

    @media screen and (max-width: 480px) {
        .entityInfo {
            padding: 55px 15px 15px 15px;
        }

        .playlistImage img {
            width: 120px;
            height: 120px;
        }

        .rightSection h2 {
            font-size: 22px;
        }

        .rightSection p {
            font-size: 14px;
        }

        .button {
            padding: 10px 20px;
            font-size: 14px;
            margin-top: 10px;
        }

        .tracklistContainer {
            padding: 0 10px;
        }

        .tracklistRow {
            padding: 10px 5px;
        }

        .trackCount {
            width: 40px;
            flex: 0 0 40px;
        }

        .trackDuration {
            width: 45px;
            flex: 0 0 45px;
        }

        .trackName {
            font-size: 14px;
        }

        .artistName {
            font-size: 12px;
        }

        .play {
            width: 16px;
            height: 16px;
        }
    }
</style>

<div class="entityInfo">
    <div class="leftSection">
        <div class="playlistImage">
            <img src="assets/images/Icons/playlist2.png" alt="Playlist">
        </div>
    </div>

    <div class="rightSection">
        <h2><?php echo $playlist->getName(); ?></h2>
        <p>By <?php echo $playlist->getOwner(); ?></p>
        <p><?php echo $playlist->getNumberOfSongs(); ?> songs</p>
        <button class="button" onclick="deletePlaylist('<?php echo $playlistId; ?>');">DELETE PLAYLIST</button>
    </div>
</div>

<div class="tracklistContainer">
    <ul class="tracklist">
        <?php
        $songIdArray = $playlist->getSongIds();
        $count = 1;

        foreach ($songIdArray as $songId) {
            $playlistSong = new Song($con, $songId);
            $songArtist = $playlistSong->getArtist();

            echo "<li class='tracklistRow' onclick='setTrack(\"" . $playlistSong->getId() . "\", tempPlaylist, true)'>
                            <div class='trackCount'>
                                <img class='play' src='assets/images/Icons/play-white.png'>
                                <span class='trackNumber'>$count.</span>
                            </div>
                            <div class='trackInfo'>
                                <span class='trackName'>" . $playlistSong->getTitle() . "</span>
                                <span class='artistName'>" . $songArtist->getName() . "</span>
                            </div>
                            <div class='trackOptions'>
                                <input type='hidden' class='songId' value='" . $playlistSong->getId() . "'>
                                <img class='optionButton' src='assets/images/Icons/more.png' onclick='showOptionsMenu(this); event.stopPropagation();'>
                            </div>
                            <div class='trackDuration'>
                                <span class='duration'>" . $playlistSong->getDuration() . "</span>
                            </div>  
                        </li>";
            $count++;
        }
        ?>
    </ul>
</div>

<script>
    var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
    tempPlaylist = JSON.parse(tempSongIds);

    // Add event listener for all song rows
    document.querySelectorAll(".tracklistRow").forEach(row => {
        row.addEventListener("click", function () {
            let songId = this.querySelector(".songId").value;
            setTrack(songId, tempPlaylist, true);
        });
    });
</script>

<nav class="optionsMenu">
    <input type="hidden" class="songId">
    <?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
    <div class="item" onclick="removeFromPlaylist(this, '<?php echo $playlistId; ?>')">Remove from playlist</div>
</nav>