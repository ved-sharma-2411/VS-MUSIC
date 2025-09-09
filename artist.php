<?php
include("Includes/includedFiles.php");

if (isset($_GET['id'])) {
    $artistId = $_GET['id'];
} else {
    header("Location: index.php");
}

$artist = new Artist($con, $artistId);
?>

<button class="back-button" onclick="history.back();">← Back</button>

<div class="entityInfo borderBottom">
    <div class="centerSection">
        <div class="artistInfo">
            <h1 class="artistName"><?php echo $artist->getName(); ?></h1>
            <div class="headerButtons">
                <button class="button green" onclick="playArtistFirstSong();">PLAY</button>
            </div>
        </div>
    </div>
</div>

<div class="tracklistContainer borderBottom">
    <h2>TOP 5 SONGS</h2>
    <ul class="tracklist">
        <?php
        $songIdArray = $artist->getSongIds();

        $count = 1;
        foreach ($songIdArray as $songId) {
            // ONLY GET TOP 5 SONGS FOR THIS ARTIST
            if ($count > 5) {
                break;
            }

            $albumSong = new Song($con, $songId);
            $albumArtist = $albumSong->getArtist();

            echo "<li class='tracklistRow'>
                            <div class='trackCount'>
                                <img class='play' src='assets/images/Icons/play-white.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
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
        </script>
    </ul>
</div>

<div class="gridViewContainer">
    <h2>ALBUMS</h2>
    <?php
    $albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE artist='$artistId'");

    while ($row = mysqli_fetch_array($albumQuery)) {
        echo "<div class='gridViewItem'>
                        <span onclick='openPage(\"album.php?id=" . $row['id'] . "\");'>
                            <img src='" . $row['artworkPath'] . "'>
                            <div class='gridViewInfo'>"
            . $row['title'] .
            "</div>
                        </span>
                    </div>";
    }
    ?>
</div>

<nav class="optionsMenu">
    <input type="hidden" class="songId">
    <?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUsername()); ?>
</nav>

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

    /* Mobile responsive styles */
    @media screen and (max-width: 768px) {
        .entityInfo {
            padding: 60px 20px 20px 20px;
            text-align: center;
        }

        .artistName {
            font-size: 32px;
            margin-bottom: 20px;
        }

        .button.green {
            padding: 12px 25px;
            font-size: 16px;
            margin-bottom: 20px;
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
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .artistName {
            font-size: 13px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .gridViewContainer {
            padding: 20px 15px;
        }

        .gridViewItem {
            width: 45%;
            margin: 2.5%;
            display: inline-block;
            vertical-align: top;
        }

        .gridViewItem img {
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
    }

    @media screen and (max-width: 480px) {
        .entityInfo {
            padding: 40px 15px 15px 15px;
        }

        .artistName {
            font-size: 28px;
            margin-bottom: 15px;
        }

        .button.green {
            padding: 10px 20px;
            font-size: 14px;
        }

        .tracklistRow {
            padding: 10px 5px;
        }

        .trackCount {
            width: 40px;
            flex: 0 0 40px;
        }

        .trackInfo .trackName {
            font-size: 13px;
        }

        .trackInfo .artistName {
            font-size: 11px;
        }

        .trackOptions {
            width: 35px;
            flex: 0 0 35px;
        }

        .trackDuration {
            width: 45px;
            flex: 0 0 45px;
            font-size: 12px;
        }

        .gridViewItem {
            width: 90%;
            margin: 5%;
        }
    }

    @media screen and (max-width: 480px) {
        .entityInfo {
            padding: 55px 15px 15px 15px;
        }

        .artistInfo .artistName {
            font-size: 28px;
            margin-bottom: 15px;
        }

        .button.green {
            padding: 10px 20px;
            font-size: 14px;
            min-width: 120px;
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

        .optionButton {
            width: 15px;
        }

        .play {
            width: 16px;
            height: 16px;
        }

        .gridViewContainer {
            padding: 15px 10px;
        }

        .gridViewItem {
            width: 90%;
            margin: 5%;
            min-width: auto;
        }
    }
</style>