// script.js

var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
var tempPlaylist = JSON.parse(tempSongIds);

// This function sets the song to be played
function setTrack(songId, playlist, playNow) {
    // Assuming `tempPlaylist` holds the list of song IDs, you can load the song based on songId
    var songIndex = playlist.indexOf(songId);

    if (songIndex != -1) {
        // Logic to start the song
        // Here you might want to trigger your music player to load and play the song
        console.log("Playing song:", songId);
        // e.g., if using HTML5 Audio
        var audioElement = new Audio("path_to_your_audio_files/" + songId + ".mp3");
        audioElement.play();
    }
}

function showOptionsMenu(button) {
    var menu = document.querySelector(".optionsMenu");
    var songId = button.closest('.trackOptions').querySelector('.songId').value;
    menu.style.display = 'block';
    menu.querySelector('input').value = songId;
}

// To close the menu (optional)
window.addEventListener('click', function(event) {
    if (!event.target.closest('.trackOptions')) {
        document.querySelector('.optionsMenu').style.display = 'none';
    }
});
