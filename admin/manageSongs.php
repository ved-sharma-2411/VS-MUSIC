<?php
session_start();
include("../Includes/config.php"); // Database Connection

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin-login.php");
    exit();
}

// ✅ Fetch all songs from the database
$songsQuery = mysqli_query($con, "SELECT * FROM songs");

// ✅ Delete Song
if (isset($_GET['delete'])) {
    $songId = $_GET['delete'];

    // Fetch song file path before deleting
    $fetchQuery = mysqli_query($con, "SELECT path FROM songs WHERE id='$songId'");
    $songData = mysqli_fetch_assoc($fetchQuery);

    if ($songData) {
        // Delete the song file from the server
        unlink("../" . $songData['path']);
    }

    // Delete song from the database
    mysqli_query($con, "DELETE FROM songs WHERE id='$songId'");
    header("Location: manageSongs.php");
}

// ✅ Edit Song
$editMode = false;
$editSongData = null;
if (isset($_GET['edit'])) {
    $editMode = true;
    $editSongId = $_GET['edit'];
    $editQuery = mysqli_query($con, "SELECT * FROM songs WHERE id='$editSongId'");
    $editSongData = mysqli_fetch_assoc($editQuery);
}

// ✅ Upload New Song
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $songId = mysqli_real_escape_string($con, $_POST['songId']);
    $songTitle = mysqli_real_escape_string($con, $_POST['songTitle']);
    $artist = mysqli_real_escape_string($con, $_POST['artist']);
    $album = mysqli_real_escape_string($con, $_POST['album']);
    $genre = mysqli_real_escape_string($con, $_POST['genre']);
    $duration = mysqli_real_escape_string($con, $_POST['duration']);
    $albumOrder = mysqli_real_escape_string($con, $_POST['albumOrder']);
    $isEdit = isset($_POST['editMode']) && $_POST['editMode'] == 'true';

    // Handle file upload
    $targetDir = "../uploads/";
    $fileName = basename($_FILES['songFile']['name']);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    $allowedTypes = ['mp3', 'wav', 'ogg'];

    if ($isEdit) {
        // Update existing song
        if (!empty($fileName) && in_array($fileType, $allowedTypes)) {
            // Delete old file
            $oldFileQuery = mysqli_query($con, "SELECT path FROM songs WHERE id='$songId'");
            $oldFileData = mysqli_fetch_assoc($oldFileQuery);
            if ($oldFileData) {
                unlink("../" . $oldFileData['path']);
            }

            // Upload new file
            if (move_uploaded_file($_FILES['songFile']['tmp_name'], $targetFilePath)) {
                $relativePath = "uploads/" . $fileName;
                mysqli_query($con, "UPDATE songs SET title='$songTitle', artist='$artist', album='$album', genre='$genre', duration='$duration', path='$relativePath', albumOrder='$albumOrder' WHERE id='$songId'");
            }
        } else {
            // Update without file change
            mysqli_query($con, "UPDATE songs SET title='$songTitle', artist='$artist', album='$album', genre='$genre', duration='$duration', albumOrder='$albumOrder' WHERE id='$songId'");
        }
        header("Location: manageSongs.php");
    } else {
        // Add new song
        if (in_array($fileType, $allowedTypes)) {
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            if (move_uploaded_file($_FILES['songFile']['tmp_name'], $targetFilePath)) {
                $relativePath = "uploads/" . $fileName;
                mysqli_query($con, "INSERT INTO songs (id, title, artist, album, genre, duration, path, albumOrder) 
                                    VALUES ('$songId', '$songTitle', '$artist', '$album', '$genre', '$duration', '$relativePath', '$albumOrder')");
                header("Location: manageSongs.php");
            } else {
                echo "<script>alert('File upload failed: Cannot move file!');</script>";
            }
        } else {
            echo "<script>alert('Invalid file type! Only MP3, WAV, OGG allowed.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Songs - Admin Panel</title>
    <link rel="icon" type="image/png" href="Logo.png">
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Icons -->

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #121212;
            color: white;
            margin: 0;
            padding: 0;
        }

        /* ✅ Sidebar (Glassmorphism + Icons) */
        .sidebar {
            width: 220px;
            height: 100vh;
            background: rgba(29, 185, 84, 0.1);
            backdrop-filter: blur(15px);
            position: fixed;
            left: 0;
            top: 0;
            padding: 20px;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            box-shadow: 5px 0px 20px rgba(29, 185, 84, 0.5);
            border-right: 2px solid rgba(255, 255, 255, 0.1);
            z-index: 1000;
        }

        .sidebar h2 {
            color: #1DB954;
            text-align: center;
            text-transform: uppercase;
            font-size: 22px;
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 12px;
            margin: 10px 0;
            text-align: left;
            transition: 0.3s;
            border-radius: 10px;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: white;
            font-size: 18px;
            display: flex;
            align-items: center;
            transition: 0.3s;
            padding: 10px;
            border-radius: 10px;
            position: relative;
        }

        .sidebar ul li a i {
            margin-right: 15px;
            font-size: 20px;
        }

        .sidebar ul li a:hover {
            background: rgba(29, 185, 84, 0.3);
            color: #1DB954;
            box-shadow: 0px 0px 15px rgba(29, 185, 84, 0.8);
            border: 1px solid #1DB954;
            transform: scale(1.05);
        }

        .main-content {
            margin-left: 270px;
            padding: 20px;
            overflow-x: auto;
            /* ✅ Allows horizontal scrolling */
            transition: margin-left 0.3s ease-in-out;
        }

        h1 {
            color: #1DB954;
        }

        form {
            background: #222;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            width: 50%;
        }

        form input,
        form button {
            padding: 10px;
            margin: 10px 0;
            width: 100%;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }

        form input {
            background: #333;
            color: white;
        }

        form button {
            background: #1DB954;
            color: black;
            cursor: pointer;
            transition: 0.3s;
        }

        form button:hover {
            background: #0d8a38;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #222;
            border-radius: 10px;
            overflow: hidden;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #333;
        }

        th {
            background: #1DB954;
            color: black;
        }

        td a {
            padding: 8px 12px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            display: inline-block;
        }

        .delete {
            background: red;
        }

        .delete:hover {
            background: darkred;
        }

        .edit {
            background: #1DB954;
            margin-right: 5px;
        }

        .edit:hover {
            background: #0d8a38;
        }

        /* ✅ Sidebar Toggle */
        .menu-toggle {
            display: none;
            cursor: pointer;
            font-size: 24px;
            position: fixed;
            top: 15px;
            left: 20px;
            color: white;
            z-index: 1100;
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -270px;
                width: 250px;
            }

            .sidebar.active {
                left: 0;
            }

            .menu-toggle {
                display: block;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .stats {
                grid-template-columns: 1fr;
            }
        }

        .main-content::-webkit-scrollbar {
            height: 5px;
        }

        .main-content::-webkit-scrollbar-thumb {
            background: #1DB954;
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <div class="menu-toggle" onclick="toggleMenu()">☰</div>

    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="admin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="manageUsers.php"><i class="fas fa-users"></i> Manage Users</a></li>
            <li><a href="manageArtists.php"><i class="fas fa-microphone"></i> Manage Artists</a></li>
            <li><a href="manageAlbums.php"><i class="fas fa-compact-disc"></i> Manage Albums</a></li>
            <li><a href="manageSongs.php"><i class="fas fa-music"></i> Manage Songs</a></li>
            <li><a href="admin-logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1><?php echo $editMode ? 'Edit Song' : 'Manage Songs'; ?></h1>

        <!-- Upload/Edit Song Form -->
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="editMode" value="<?php echo $editMode ? 'true' : 'false'; ?>">
            <input type="text" name="songId" placeholder="Song ID"
                value="<?php echo $editMode ? $editSongData['id'] : ''; ?>" <?php echo $editMode ? 'readonly' : ''; ?>
                required>
            <input type="text" name="songTitle" placeholder="Song Title"
                value="<?php echo $editMode ? $editSongData['title'] : ''; ?>" required>
            <input type="text" name="artist" placeholder="Artist Name"
                value="<?php echo $editMode ? $editSongData['artist'] : ''; ?>" required>
            <input type="text" name="album" placeholder="Album Name"
                value="<?php echo $editMode ? $editSongData['album'] : ''; ?>" required>
            <input type="text" name="genre" placeholder="Genre"
                value="<?php echo $editMode ? $editSongData['genre'] : ''; ?>" required>
            <input type="text" name="duration" placeholder="Duration (e.g. 03:45)"
                value="<?php echo $editMode ? $editSongData['duration'] : ''; ?>" required>
            <input type="number" name="albumOrder" placeholder="Album Order"
                value="<?php echo $editMode ? $editSongData['albumOrder'] : ''; ?>" required>
            <input type="file" name="songFile" accept=".mp3,.wav,.ogg" <?php echo $editMode ? '' : 'required'; ?>>
            <?php if ($editMode): ?>
                <p style="color: #1DB954;">Leave file empty to keep current song file</p>
            <?php endif; ?>
            <button type="submit"><?php echo $editMode ? 'Update Song' : 'Upload Song'; ?></button>
            <?php if ($editMode): ?>
                <a href="manageSongs.php"
                    style="background: #666; color: white; padding: 10px; text-decoration: none; border-radius: 5px; display: inline-block; margin-left: 10px;">Cancel</a>
            <?php endif; ?>
        </form>

        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Artist</th>
                <th>Album</th>
                <th>Genre</th>
                <th>Duration</th>
                <th>File</th>
                <th>Actions</th>
            </tr>
            <?php while ($song = mysqli_fetch_assoc($songsQuery)) { ?>
                <tr>
                    <td><?php echo $song['id']; ?></td>
                    <td><?php echo $song['title']; ?></td>
                    <td><?php echo $song['artist']; ?></td>
                    <td><?php echo $song['album']; ?></td>
                    <td><?php echo $song['genre']; ?></td>
                    <td><?php echo $song['duration']; ?></td>
                    <td><audio controls>
                            <source src="../<?php echo $song['path']; ?>" type="audio/mpeg">
                        </audio></td>
                    <td>
                        <a href="manageSongs.php?edit=<?php echo $song['id']; ?>" class="edit">Edit</a>
                        <a href="manageSongs.php?delete=<?php echo $song['id']; ?>" class="delete"
                            onclick="return confirm('Are you sure you want to delete this song?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <script>
        function toggleMenu() {
            document.querySelector(".sidebar").classList.toggle("active");
        }
    </script>
</body>

</html>