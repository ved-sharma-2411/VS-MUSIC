<?php
        // Create random playlist of 10 songs
        $songQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");
        $resultArray = array();
        while ($row = mysqli_fetch_array($songQuery)) {
            array_push($resultArray, $row['id']);
        }

        // Convert to JSON to pass to javascript
        $jsonArray = json_encode($resultArray);
    ?>

    <script>
        $(document).ready(function() {
            var newPlaylist = <?php echo $jsonArray; ?>;
            audioElement = new Audio();
            // Dont play when page reloads
            setTrack(newPlaylist[0], newPlaylist, false);
            // Set volume progress bar initially
            updateVolumeProgressBar(audioElement.audio);
            
            // Prevent playingBar controls from getting highlighted when dragging
            $("#nowPlayingBar").on("mousedown touchstart mousemove touchmove", function(e) {
                e.preventDefault();
            });

            // Dragging progress bar
            $('.playbackBar .progressBar').mousedown(function() {
                mouseDown = true;
            });
            $('.playbackBar .progressBar').mousemove(function(e) {
                if(mouseDown) {
                    // Set time of song depending on mouse position
                    timeFromOffset(e, this);
                }
            });
            $('.playbackBar .progressBar').mouseup(function(e) {
                timeFromOffset(e, this);
            });


            // Dragging volume bar
            $('.volumeBar .progressBar').mousedown(function() {
                mouseDown = true;
            });
            $('.volumeBar .progressBar').mousemove(function(e) {
                if(mouseDown) {
                    var percentage = e.offsetX / $(this).width();
                    if(percentage >=0 && percentage <=1) {
                        audioElement.audio.volume = percentage;
                    }
                }
            });
            $('.volumeBar .progressBar').mouseup(function(e) {
                var percentage = e.offsetX / $(this).width();
                if(percentage >=0 && percentage <=1) {
                    audioElement.audio.volume = percentage;
                }
            });


            $(document).mouseup(function() {
                mouseDown = false;
            });
        });

        // Get time of song from mouse offset (Start offset)
        function timeFromOffset(mouse, progressBar) {
            // get offset of mouse in X direction
            var percentage = ( mouse.offsetX / $(progressBar).width() ) * 100;
            var seconds = audioElement.audio.duration * (percentage / 100);
            audioElement.setTime(seconds);
        }

        function previousSong() {
            // If current time > 3 seconds or first song , restart song
            if(audioElement.audio.currentTime >= 3 || currentIndex == 0) {
                audioElement.setTime(0);
            }
            // go to previous song
            else {
                currentIndex--;
                setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
            }
        }

        function nextSong() {
            if(repeat) {
                audioElement.setTime(0);
                playSong();
                return;
            }

            if(currentIndex == currentPlaylist.length - 1) {
                // if last song in playlist
                currentIndex = 0; //go back to start
            }
            else {
                currentIndex++;
            }

            var track = shuffle ? shuffledPlaylist[currentIndex] : currentPlaylist[currentIndex];
            setTrack(track, currentPlaylist, true);
        }

        function setRepeat() {
            // toggle repeat
            repeat = !repeat;

            var image = repeat ? "repeat-active.png" : "repeat.png";

            $(".controlButton.repeat img").attr("src", "assets/images/Icons/" + image);
        }

        function setMute() {
            audioElement.audio.muted = !audioElement.audio.muted;

            var image = audioElement.audio.muted ? "volume-mute.png" : "volume.png";

            $(".controlButton.volume img").attr("src", "assets/images/Icons/" + image);
        }

        function setShuffle() {
            shuffle = !shuffle;

            var image = shuffle ? "shuffle-active.png" : "shuffle.png";

            $(".controlButton.shuffle img").attr("src", "assets/images/Icons/" + image);

            if(shuffle) {
                // Shuffle playlist
                shuffleArray(shuffledPlaylist);
                // Get the correct currentIndex after shuffling
                currentIndex = shuffledPlaylist.indexOf(audioElement.currentlyPlaying.id);
            }
            else {
                currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
            }
        }

        // Shuffle Helper function
        function shuffleArray(arr) {
            var j, x, i;
            for (i = arr.length - 1; i > 0; i--) {
                // Get random index within array
                j = Math.floor(Math.random() * (i + 1));
                // Swap the two elements
                x = arr[i];
                arr[i] = arr[j];
                arr[j] = x;
            }
            // Return shuffled array
            return arr;
        }

        
        function setTrack(trackId, newPlaylist, play) {
            // To maintain a copy of the original playlist and shuffled playlist
            // newPlaylist != currentPlaylist in case of switching albums
            if(newPlaylist != currentPlaylist) {
                currentPlaylist = newPlaylist;
                // Take a copy of the currentPlaylist
                shuffledPlaylist = currentPlaylist.slice();
                shuffleArray(shuffledPlaylist);
            }
            
            if(shuffle) {
                currentIndex = shuffledPlaylist.indexOf(trackId);
            }
            else {
                // Get currentIndex of currentlyPlaying song
                currentIndex = currentPlaylist.indexOf(trackId);
            }
            
            pauseSong();

            // Get song from db using AJAX
            $.post("Includes/Handlers/ajax/getSongJson.php", { songId: trackId }, function(data) {
                // Parse returned string array into json
                var track = JSON.parse(data);

                $('.trackName span').text(track.title);
                
                // AJAX call to get artist
                $.post("Includes/Handlers/ajax/getArtistJson.php", { artistId: track.artist }, function(data) {
                    var artist = JSON.parse(data);
                    $('.artistName span').text(artist.name);
                    // Set link on artist name
                    $('.artistName span').attr("onclick", "openPage('artist.php?id=" + artist.id + "')");
                });

                // AJAX call to get album
                $.post("Includes/Handlers/ajax/getAlbumJson.php", { albumId: track.album }, function(data) {
                    var album = JSON.parse(data);
                    $('.albumLink img').attr("src", album.artworkPath);
                    // Set link on album image
                    $('.albumLink img').attr("onclick", "openPage('album.php?id=" + album.id + "')");
                    // Set link on song name
                    $('.trackName span').attr("onclick", "openPage('album.php?id=" + album.id + "')");
                });

                audioElement.setTrack(track);

                if(play) {
                    playSong();
                }
            });
        }

        // Functions to play/pause and toggle buttons
        function playSong() {
            // Update song count only if currentTime = 0 (just played not paused then played)
            if(audioElement.audio.currentTime == 0) {
                // AJAX call to update song play count
                $.post("Includes/Handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });
            }


            $('.controlButton.play').hide();
            $('.controlButton.pause').show();
            audioElement.play();
        }

        function pauseSong() {
            $('.controlButton.play').show();
            $('.controlButton.pause').hide();
            audioElement.pause();
        }
    </script>

    <div id="nowPlayingBarContainer">
        <div id="nowPlayingBar">
            <div id="nowPlayingLeft">
                <div class="content">
                    <span class="albumLink pointer">
                        <img src="" alt="album" class="albumArtwork">
                    </span>
                    <div class="trackInfo">
                        <span class="trackName pointer">
                            <span></span>
                        </span>
                        <span class="artistName pointer">
                            <span></span>
                        </span>
                    </div>
                </div>
            </div>
            <div id="nowPlayingCenter">
                <div class="content playerControls">
                    <div class="buttons">
                        <button class="controlButton shuffle" title="Shuffle" onclick="setShuffle();">
                            <img src="assets/images/Icons/shuffle.png" alt="Shuffle">
                        </button>
                        <button class="controlButton previous" title="Previous" onclick="previousSong();">
                            <img src="assets/images/Icons/previous.png" alt="Previous">
                        </button>
                        <button class="controlButton play" title="Play" onclick="playSong();">
                            <img src="assets/images/Icons/play.png" alt="Play">
                        </button>
                        <button class="controlButton pause" title="Pause" onclick="pauseSong();">
                            <img src="assets/images/Icons/pause.png" alt="Pause">
                        </button>
                        <button class="controlButton next" title="Next" onclick="nextSong();">
                            <img src="assets/images/Icons/next.png" alt="Next">
                        </button>
                        <button class="controlButton repeat" title="Repeat" onclick="setRepeat();">
                            <img src="assets/images/Icons/repeat.png" alt="Repeat">
                        </button>
                    </div>

                    <div class="playbackBar">
                        <span class="progressTime current">0.00</span>
                        <div class="progressBar">
                            <div class="progressBarBG">
                                <div class="progress"></div>
                            </div>
                        </div>
                        <span class="progressTime remaining">0.00</span>
                    </div>
                </div>
            </div>
            <div id="nowPlayingRight">
                <div class="volumeBar">
                    <button class="controlButton volume" title="Volume" onclick="setMute();">
                        <img src="assets/images/Icons/volume.png" alt="Volume">
                    </button>
                    <div class="progressBar">
                        <div class="progressBarBG">
                            <div class="progress"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
 /* Now Playing Bar: Glowing Effect */
 /* Smooth Now Playing Bar Styling */
/* Now Playing Bar: Glowing Effect */
#nowPlayingBar {
    background: linear-gradient(45deg, #1e1e1e, #111);
    box-shadow: 0px 0px 20px rgba(0, 255, 150, 0.4);
    padding: 15px;
    border-radius: 10px;
    transition: background 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}
#nowPlayingBar:hover {
    box-shadow: 0px 0px 25px rgba(0, 255, 150, 0.7);
}

/* Hover Effects on Controls */
.controlButton img {
    transition: transform 0.2s ease, filter 0.2s ease;
}
.controlButton img:hover {
    transform: scale(1.2);
    filter: drop-shadow(0px 0px 10px rgba(0, 255, 150, 0.6));
}

/* Play/Pause Animation */
.controlButton.play img, .controlButton.pause img {
    transition: transform 0.3s ease;
}
.controlButton.play img:active, .controlButton.pause img:active {
    transform: scale(1.4);
}

/* Smooth Progress Bar */
.progressBarBG {
    background: rgba(0, 255, 0, 0.2); /* Greenish background */
    height: 6px;
    border-radius: 5px;
    position: relative;
    overflow: hidden;
}
.progress {
    background: linear-gradient(to right, #00ff00, #33cc33); /* Green gradient */
    height: 100%;
    width: 0%;
    transition: width 0.3s ease-in-out;
}

/* Volume Bar Styling */
.volumeBar .progress {
    background: linear-gradient(to right, #00ff00, #33cc33); /* Green gradient */
}

/* Ripple Effect on Button Click */
@keyframes ripple {
    0% { transform: scale(0); opacity: 1; }
    100% { transform: scale(2); opacity: 0; }
}
.ripple {
    position: absolute;
    width: 20px;
    height: 20px;
    background: rgba(0, 255, 0, 0.5); /* Green ripple */
    border-radius: 50%;
    animation: ripple 0.6s linear;
}

/* Album Artwork Animation */
.albumLink img {
    transition: transform 0.6s ease-in-out;
}
.playing .albumLink img {
    animation: rotate 5s linear infinite;
}
@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Progress Bar Smooth Animation */
.progressBarBG {
    background: rgba(0, 255, 0, 0.2);
    height: 6px;
    border-radius: 5px;
    position: relative;
    overflow: hidden;
}
.progress {
    background: linear-gradient(to right, #00ff00, #33cc33);
    height: 100%;
    width: 0%;
    transition: width 0.3s ease-in-out;
}

/* Wave Animation on Progress Bar */
@keyframes wave {
    0% { box-shadow: 0px 0px 5px rgba(0, 255, 0, 0.3); }
    50% { box-shadow: 0px 0px 15px rgba(0, 255, 0, 0.8); }
    100% { box-shadow: 0px 0px 5px rgba(0, 255, 0, 0.3); }
}
.playing .progress {
    animation: wave 1.5s infinite ease-in-out;
}

/* Volume Bar Animation */
.volumeBar .progress {
    background: linear-gradient(to right, #00ff00, #33cc33);
    transition: width 0.3s ease-in-out;
}
.volumeBar .progressBar:hover {
    animation: bounce 0.5s ease-in-out;
}
@keyframes bounce {
    0% { transform: scaleY(1); }
    50% { transform: scaleY(1.2); }
    100% { transform: scaleY(1); }
}


</style>

