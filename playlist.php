<?php 
    include("Includes/includedFiles.php"); 

    if(isset($_GET['id'])) {
        $playlistId = $_GET['id'];
    }
    else {
        header("Location: index.php");
    }

    $playlist = new Playlist($con, $playlistId);
    $owner = new User($con, $playlist->getOwner());
?>

<style>
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

/* 🎵 Play Button Enhancement */
.play {
    transition: transform 0.3s ease-in-out;
}

.tracklistRow:hover .play {
    transform: scale(1.2);
}

/* 📜 Song Name Hover Effect */
.trackName {
    transition: color 0.3s ease-in-out;
}

.trackName:hover {
    color: #0f0;
}

/* 🔄 Keyframe Animations */
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

@keyframes slideUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
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

            foreach($songIdArray as $songId) {
                $playlistSong = new Song($con, $songId);
                $songArtist = $playlistSong->getArtist();

                echo    "<li class='tracklistRow' onclick='setTrack(\"" . $playlistSong->getId() . "\", tempPlaylist, true)'>
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
        row.addEventListener("click", function() {
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
