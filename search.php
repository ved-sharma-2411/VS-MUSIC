<?php
include("Includes/includedFiles.php");

if (isset($_GET['query'])) {
    $query = urldecode($_GET['query']);
} else {
    $query = "";
}

// Get popular songs for suggestions
$suggestionsQuery = mysqli_query($con, "SELECT * FROM songs ORDER BY plays DESC LIMIT 8");
$suggestions = [];
while ($row = mysqli_fetch_array($suggestionsQuery)) {
    $suggestions[] = $row;
}
?>

<div class="searchPageContainer">
    <div class="searchHeader">
        <h1>Search</h1>
        <div class="searchBox">
            <div class="searchIcon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                </svg>
            </div>
            <input type="text" class="searchInput" value="<?php echo $query; ?>"
                placeholder="What do you want to listen to?" autofocus>
        </div>
    </div>

    <?php if ($query == ""): ?>
        <div class="suggestionsContainer">
            <section class="suggestionsSection">
                <h2>Popular right now</h2>
                <div class="songsList">
                    <?php
                    $index = 1;
                    foreach ($suggestions as $suggestion):
                        $song = new Song($con, $suggestion['id']);
                        $artist = $song->getArtist();
                        $album = $song->getAlbum();
                        ?>
                        <div class="songItem"
                            onclick="setTrack(<?php echo $song->getId(); ?>, [<?php echo $song->getId(); ?>], true)">
                            <div class="songIndex"><?php echo $index; ?></div>
                            <div class="songImage">
                                <img src="<?php echo $album->getArtworkPath(); ?>" alt="<?php echo $song->getTitle(); ?>">
                                <div class="playButton">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="songDetails">
                                <div class="songTitle"><?php echo $song->getTitle(); ?></div>
                                <div class="songArtist"><?php echo $artist->getName(); ?></div>
                            </div>
                            <div class="songAlbum"><?php echo $album->getTitle(); ?></div>
                            <div class="songDuration"><?php echo $song->getDuration(); ?></div>
                        </div>
                        <?php
                        $index++;
                    endforeach; ?>
                </div>
            </section>
        </div>
    <?php else: ?>
        <div class="searchResults">
            <?php
            $songsQuery = mysqli_query($con, "SELECT * FROM songs WHERE title LIKE '%$query%' OR album IN (SELECT id FROM albums WHERE title LIKE '%$query%') OR artist IN (SELECT id FROM artists WHERE name LIKE '%$query%') LIMIT 20");

            if (mysqli_num_rows($songsQuery) > 0):
                $songIdArray = array();
                while ($row = mysqli_fetch_array($songsQuery)) {
                    array_push($songIdArray, $row['id']);
                }
                mysqli_data_seek($songsQuery, 0);
                ?>
                <section class="resultsSection">
                    <h2>Songs</h2>
                    <div class="songsList">
                        <?php
                        $index = 1;
                        while ($row = mysqli_fetch_array($songsQuery)):
                            $song = new Song($con, $row['id']);
                            $artist = $song->getArtist();
                            $album = $song->getAlbum();
                            ?>
                            <div class="songItem" onclick="setTrack(<?php echo $song->getId(); ?>, tempPlaylist, true)">
                                <div class="songIndex"><?php echo $index; ?></div>
                                <div class="songImage">
                                    <img src="<?php echo $album->getArtworkPath(); ?>" alt="<?php echo $song->getTitle(); ?>">
                                    <div class="playButton">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M8 5v14l11-7z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="songDetails">
                                    <div class="songTitle"><?php echo $song->getTitle(); ?></div>
                                    <div class="songArtist"><?php echo $artist->getName(); ?></div>
                                </div>
                                <div class="songAlbum"><?php echo $album->getTitle(); ?></div>
                                <div class="songDuration"><?php echo $song->getDuration(); ?></div>
                            </div>
                            <?php
                            $index++;
                        endwhile; ?>
                    </div>
                </section>
                <script>
                    var tempSongIds = <?php echo json_encode($songIdArray); ?>;
                    tempPlaylist = tempSongIds;
                </script>
            <?php else: ?>
                <div class="noResults">
                    <div class="noResultsIcon">🔍</div>
                    <h3>No results found for "<?php echo htmlspecialchars($query); ?>"</h3>
                    <p>Please make sure your words are spelled correctly or use less or different keywords.</p>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<script>
    $(document).ready(function () {
        let timer;
        $(".searchInput").on("keyup", function () {
            clearTimeout(timer);
            let val = $(this).val();
            timer = setTimeout(() => {
                if (val.length > 0) {
                    openPage("search.php?query=" + encodeURIComponent(val));
                } else {
                    openPage("search.php");
                }
            }, 500);
        });
    });
</script>

<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    .searchPageContainer {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1.5rem;
        color: #ffffff;
    }

    /* Mobile responsive for search page */
    @media screen and (max-width: 768px) {
        .searchPageContainer {
            padding: 1.5rem 1rem;
        }
    }

    @media screen and (max-width: 480px) {
        .searchPageContainer {
            padding: 1rem 0.5rem;
        }
    }

    .searchHeader {
        margin-bottom: 2rem;
    }

    .searchHeader h1 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 1.5rem;
    }

    .searchBox {
        position: relative;
        width: 100%;
        max-width: 100%;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 25px;
        padding: 0 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        height: 48px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }

    .searchBox:focus-within {
        background: rgba(255, 255, 255, 0.15);
        border-color: #1db954;
        box-shadow: 0 0 0 2px rgba(29, 185, 84, 0.2);
    }

    .searchIcon {
        color: #b3b3b3;
        transition: color 0.3s ease;
    }

    .searchBox:focus-within .searchIcon {
        color: #ffffff;
    }

    .searchInput {
        flex: 1;
        border: none;
        outline: none;
        background: transparent;
        color: #ffffff;
        font-size: 0.95rem;
        font-weight: 400;
        height: 100%;
    }

    .searchInput::placeholder {
        color: #b3b3b3;
    }

    .suggestionsContainer {
        margin-top: 2rem;
    }

    .suggestionsSection,
    .resultsSection {
        margin-bottom: 3rem;
    }

    .suggestionsSection h2,
    .resultsSection h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 1rem;
    }

    /* Mobile responsive for section headers */
    @media screen and (max-width: 768px) {

        .suggestionsSection h2,
        .resultsSection h2 {
            font-size: 1.3rem;
        }
    }

    @media screen and (max-width: 480px) {

        .suggestionsSection h2,
        .resultsSection h2 {
            font-size: 1.1rem;
        }
    }

    .browseGrid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
    }

    /* Mobile responsive for browse grid */
    @media screen and (max-width: 768px) {
        .browseGrid {
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 0.8rem;
        }
    }

    @media screen and (max-width: 480px) {
        .browseGrid {
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 0.6rem;
        }
    }

    .browseCard {
        height: 100px;
        border-radius: 8px;
        padding: 1rem;
        display: flex;
        align-items: flex-end;
        cursor: pointer;
        transition: transform 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .browseCard:hover {
        transform: scale(1.05);
    }

    .browseCard h3 {
        font-size: 1rem;
        font-weight: 700;
        color: #ffffff;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    }

    .browseGrid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
    }

    .browseCard {
        height: 100px;
        border-radius: 8px;
        padding: 1rem;
        display: flex;
        align-items: flex-end;
        cursor: pointer;
        transition: transform 0.2s ease;
        position: relative;
        overflow: hidden;
    }

    .browseCard:hover {
        transform: scale(1.05);
    }

    .browseCard h3 {
        font-size: 1rem;
        font-weight: 700;
        color: #ffffff;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    }

    .suggestionsGrid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 1rem;
    }

    /* Mobile responsive for suggestions grid */
    @media screen and (max-width: 768px) {
        .suggestionsGrid {
            grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
            gap: 0.8rem;
        }
    }

    @media screen and (max-width: 480px) {
        .suggestionsGrid {
            grid-template-columns: repeat(auto-fit, minmax(110px, 1fr));
            gap: 0.6rem;
        }
    }

    .suggestionCard {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
    }

    /* Mobile responsive for suggestion cards */
    @media screen and (max-width: 768px) {
        .suggestionCard {
            padding: 0.8rem;
        }
    }

    @media screen and (max-width: 480px) {
        .suggestionCard {
            padding: 0.6rem;
        }
    }

    .suggestionCard:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-4px);
    }

    .suggestionImage {
        position: relative;
        margin-bottom: 0.75rem;
    }

    .suggestionImage img {
        width: 100%;
        aspect-ratio: 1;
        object-fit: cover;
        border-radius: 6px;
    }

    .playOverlay {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.6);
        opacity: 0;
        transition: opacity 0.3s ease;
        border-radius: 6px;
        color: #ffffff;
    }

    .suggestionCard:hover .playOverlay {
        opacity: 1;
    }

    .suggestionInfo h4 {
        font-size: 0.9rem;
        font-weight: 600;
        color: #ffffff;
        margin-bottom: 0.25rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .suggestionInfo p {
        font-size: 0.8rem;
        color: #b3b3b3;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }



    .searchResults {
        margin-top: 2rem;
    }

    .songsList {
        background: transparent;
        border-radius: 0;
        overflow: hidden;
        border: none;
    }

    .songItem {
        display: flex;
        align-items: center;
        padding: 15px;
        margin-right: 10px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        transition: transform 0.2s ease-in-out, background 0.2s ease-in-out;
        cursor: pointer;
        position: relative;
        border-radius: 5px;
    }

    /* Mobile responsive for song items */
    @media screen and (max-width: 768px) {
        .songItem {
            padding: 12px 8px;
            flex-wrap: wrap;
        }
    }

    @media screen and (max-width: 480px) {
        .songItem {
            padding: 10px 5px;
        }
    }

    .songItem:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: scale(1.02);
        box-shadow: 0px 0px 15px rgba(255, 255, 255, 0.2);
    }

    @media screen and (max-width: 768px) {
        .songItem:hover {
            transform: scale(1.01);
        }
    }

    .songItem:last-child {
        border-bottom: none;
    }

    .songIndex {
        font-size: 16px;
        color: #b3b3b3;
        margin-right: 15px;
        width: 30px;
        text-align: center;
    }

    .songImage {
        position: relative;
        margin-right: 15px;
    }

    .songImage img {
        width: 50px;
        height: 50px;
        border-radius: 4px;
        object-fit: cover;
    }

    .playButton {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(0, 0, 0, 0.8);
        opacity: 0;
        transition: opacity 0.2s ease;
        border-radius: 4px;
        color: #ffffff;
    }

    .songItem:hover .playButton {
        opacity: 1;
    }

    .songDetails {
        flex: 1;
        min-width: 0;
        margin-right: 15px;
    }

    .songTitle {
        font-size: 16px;
        font-weight: bold;
        color: #ffffff;
        margin-bottom: 5px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        transition: color 0.2s ease-in-out;
    }

    .songArtist {
        font-size: 14px;
        color: #b3b3b3;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .songItem:hover .songTitle {
        color: #1DB954;
    }

    .songAlbum {
        font-size: 14px;
        color: #b3b3b3;
        flex: 1;
        margin-right: 15px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .songDuration {
        font-size: 14px;
        color: #b3b3b3;
        text-align: right;
        margin-right: 15px;
    }

    .play {
        width: 14px;
        transition: transform 0.2s ease-in-out;
    }

    .songItem:hover .play {
        transform: scale(1.2);
    }

    .noResults {
        text-align: center;
        padding: 3rem 1rem;
        background: rgba(255, 255, 255, 0.02);
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .noResultsIcon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.6;
    }

    .noResults h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #ffffff;
        margin-bottom: 0.5rem;
    }

    .noResults p {
        color: #b3b3b3;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .searchPageContainer {
            padding: 1rem;
        }

        .searchHeader h1 {
            font-size: 2rem;
        }

        .browseGrid {
            grid-template-columns: repeat(2, 1fr);
        }

        .suggestionsGrid {
            grid-template-columns: repeat(2, 1fr);
        }

        .songItem {
            grid-template-columns: 25px 50px 1fr 60px;
            gap: 0.75rem;
            padding: 0.5rem 0.75rem;
        }

        .songAlbum {
            display: none;
        }

        .searchBox {
            height: 42px;
        }
    }

    @media (max-width: 480px) {
        .searchPageContainer {
            padding: 0.5rem;
        }

        .searchHeader h1 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .searchBox {
            height: 40px;
            padding: 0 0.75rem;
        }

        .browseGrid {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        .browseCard {
            height: 80px;
            padding: 0.75rem;
        }

        .browseCard h3 {
            font-size: 0.875rem;
        }

        .suggestionsGrid {
            grid-template-columns: 1fr;
        }

        .songItem {
            grid-template-columns: 40px 1fr 50px;
            gap: 0.5rem;
        }

        .songIndex {
            display: none;
        }

        .songTitle {
            font-size: 14px;
        }

        .songArtist {
            font-size: 12px;
        }
    }

    .content.playerControls {
        gap: 15px !important;
    }

    .content.playerControls .controlButton {
        margin: 0 8px !important;
    }

    .content.playerControls .controlButton img {
        position: relative !important;
        top: 0 !important;
        left: 0 !important;
        transform: none !important;
    }

    .content.playerControls .play,
    .content.playerControls .pause {
        width: 40px !important;
        height: 40px !important;
    }
</style>

<script>
    function showPlayButton(element) {
        const playButton = element.querySelector('.playButton');
        const songIndex = element.querySelector('.songIndex');
        if (playButton) playButton.style.display = 'flex';
        if (songIndex) songIndex.style.opacity = '0';
    }

    function hidePlayButton(element) {
        const playButton = element.querySelector('.playButton');
        const songIndex = element.querySelector('.songIndex');
        if (playButton) playButton.style.display = 'none';
        if (songIndex) songIndex.style.opacity = '1';
    }
</script>