<?php 
    include("Includes/includedFiles.php"); 

    if(isset($_GET['id'])) {
        $albumId = $_GET['id'];
    }
    else {
        header("Location: index.php");
    }

    $album = new Album($con, $albumId);

    $artist = $album->getArtist();
    $artistId = $artist->getId();
?>

<style>

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

   

    .tracklistRow:hover .play {
        transform: scale(1.2);
    }

    .trackName {
        font-size: 16px;
        font-weight: bold;
        display: block;
        transition: color 0.2s ease-in-out;
    }

    .tracklistRow:hover .trackName {
        color: #1DB954;
    }

    .optionButton {
        width: 18px;
        transition: transform 0.2s ease-in-out;
    }

    .tracklistRow:hover .optionButton {
        transform: rotate(90deg);
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInTrack {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideDown {
        from { transform: translateY(-20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    /* Playing Track Pulse Effect */
    .playing .trackName {
        animation: pulse 1.5s infinite alternate ease-in-out;
    }

    @keyframes pulse {
        from { color: white; }
        to { color: #1DB954; }
    }
</style>

<div class="entityInfo">
    <div class="leftSection">
        <img src="<?php echo $album->getArtworkPath(); ?>" alt="Album">
    </div>

    <div class="rightSection">
        <h2><?php echo $album->getTitle(); ?></h2>
        <p class="pointer" onclick="openPage('artist.php?id=<?php echo $artistId; ?>')">By <?php echo $artist->getName(); ?></p>
        <p><?php echo $album->getNumberOfSongs(); ?> songs</p>
    </div>
</div>

<div class="tracklistContainer">
    <ul class="tracklist">
        <?php
            $songIdArray = $album->getSongIds();

            $count = 1;
            foreach($songIdArray as $songId) {
                $albumSong = new Song($con, $songId);
                $albumArtist = $albumSong->getArtist();

                echo    "<li class='tracklistRow pointer' data-song-id='" . $albumSong->getId() . "'>
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
                row.addEventListener('click', function(event) {
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
