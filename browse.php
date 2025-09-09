<?php
include("Includes/includedFiles.php");

// Fetch albums from the database
$albumQuery = mysqli_query($con, "SELECT * FROM albums");
$albums = [];

while ($row = mysqli_fetch_assoc($albumQuery)) {
    $albums[] = $row;
}

// Array of unique music-related symbols
$symbols = ["🎼", "🎶", "🎧", "🎤", "🎙️", "🎚️", "🎛️", "📀", "💿", "🔊", "🎸", "🎻", "🎷", "🎺", "🥁", "🎹"];
?>

<h1 class="pageHeadingBig">🔥 Top Albums 2025 🔥</h1>

<style>
    .gridViewContainer {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        padding: 20px;
        justify-content: center;
        max-width: 95%;
        margin: auto;
    }

    /* Mobile responsive for browse page */
    @media screen and (max-width: 768px) {
        .gridViewContainer {
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 12px;
            padding: 15px;
            max-width: 100%;
        }
    }

    @media screen and (max-width: 480px) {
        .gridViewContainer {
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 10px;
            padding: 10px;
        }
    }

    .gridViewItem {
        position: relative;
        cursor: pointer;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .gridViewItem:hover {
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 8px 20px rgba(255, 75, 43, 0.3);
    }

    @media screen and (max-width: 768px) {
        .gridViewItem:hover {
            transform: translateY(-2px) scale(1.02);
        }
    }

    .gridViewItem img {
        width: 100%;
        height: auto;
        border-radius: 10px;
        display: block;
        transition: opacity 0.3s ease-in-out;
    }

    .gridViewItem:hover img {
        opacity: 0.8;
    }

    .gridViewInfo {
        position: absolute;
        bottom: 0;
        width: 100%;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        text-align: center;
        padding: 10px;
        font-weight: bold;
        font-size: 14px;
        opacity: 0;
        transform: translateY(10px);
        transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
    }

    .gridViewItem:hover .gridViewInfo {
        opacity: 1;
        transform: translateY(0);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .gridViewContainer {
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 10px;
            padding: 15px;
        }

        .gridViewInfo {
            font-size: 12px;
            padding: 8px;
            opacity: 1 !important;
            transform: translateY(0) !important;
        }

        .pageHeadingBig {
            font-size: 20px;
            padding: 15px;
        }
    }

    @media (max-width: 480px) {
        .gridViewContainer {
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            padding: 10px;
        }

        .gridViewItem {
            border-radius: 8px;
        }

        .gridViewInfo {
            font-size: 11px;
            padding: 6px;
            opacity: 1 !important;
            transform: translateY(0) !important;
        }

        .pageHeadingBig {
            font-size: 18px;
            padding: 10px;
        }
    }
</style>

<head>
    <link rel="icon" type="image/png" href="assets/images/Icons/Logo.png">
</head>

<div class="gridViewContainer">
    <?php foreach ($albums as $album): ?>
        <?php $randomSymbol = $symbols[array_rand($symbols)]; ?>
        <div class='gridViewItem' onclick='openPage("album.php?id=<?= $album["id"] ?>");'>
            <img src='<?= $album["artworkPath"] ?>' alt='<?= htmlspecialchars($album["title"], ENT_QUOTES, "UTF-8") ?>'>
            <div class='gridViewInfo'><?= $randomSymbol . " " . htmlspecialchars($album["title"], ENT_QUOTES, "UTF-8") ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>