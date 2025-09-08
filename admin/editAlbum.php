<?php
session_start();
include("../Includes/config.php"); // Database Connection

// ✅ Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin-login.php");
    exit();
}

// ✅ Get Album ID from URL
if (!isset($_GET['id'])) {
    header("Location: manageAlbums.php");
    exit();
}
$albumId = $_GET['id'];

// ✅ Fetch Album Details
$albumQuery = mysqli_query($con, "SELECT * FROM albums WHERE id='$albumId'");
$album = mysqli_fetch_assoc($albumQuery);

if (!$album) {
    header("Location: manageAlbums.php");
    exit();
}

// ✅ Handle Album Update
if (isset($_POST['updateAlbum'])) {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $artist = mysqli_real_escape_string($con, $_POST['artist']);
    $genre = mysqli_real_escape_string($con, $_POST['genre']);

    // ✅ Handle Image Upload
    if ($_FILES['artwork']['name'] != "") {
        $imageName = time() . "_" . $_FILES['artwork']['name'];
        $imageTmp = $_FILES['artwork']['tmp_name'];
        $uploadPath = "../uploads/albums/" . $imageName;

        // Delete Old Image
        if (file_exists("../uploads/albums/" . $album['artworkPath'])) {
            unlink("../uploads/albums/" . $album['artworkPath']);
        }

        // Move New Image
        move_uploaded_file($imageTmp, $uploadPath);

        // Update Query with Image
        $updateQuery = "UPDATE albums SET title='$title', artist='$artist', genre='$genre', artworkPath='$imageName' WHERE id='$albumId'";
    } else {
        // Update Query without Image
        $updateQuery = "UPDATE albums SET title='$title', artist='$artist', genre='$genre' WHERE id='$albumId'";
    }

    // Execute Query
    if (mysqli_query($con, $updateQuery)) {
        header("Location: manageAlbums.php");
        exit();
    } else {
        $error = "Failed to update album.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Album - Admin Panel</title>
    <link rel="icon" type="image/png" href="Logo.png">
    <link rel="stylesheet" href="assets/css/admin.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #121212;
            color: white;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            width: 220px;
            background: #1DB954;
            padding: 20px;
            position: fixed;
            height: 100%;
            left: 0;
            top: 0;
        }
        .sidebar h2 {
            color: black;
            text-align: center;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            padding: 15px;
            text-align: center;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: black;
            font-size: 18px;
            display: block;
            transition: 0.3s;
        }
        .sidebar ul li a:hover {
            background: #0d8a38;
            color: white;
        }
        .main-content {
            margin-left: 270px;
            padding: 20px;
        }
        h1 {
            color: #1DB954;
        }
        form {
            background: #222;
            padding: 20px;
            border-radius: 10px;
            max-width: 500px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: #333;
            color: white;
        }
        button {
            margin-top: 15px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background: #1DB954;
            color: black;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }
        button:hover {
            background: #0d8a38;
            color: white;
        }
        img {
            margin-top: 10px;
            width: 100px;
            height: 100px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="admin.php">Dashboard</a></li>
            <li><a href="manageUsers.php">Manage Users</a></li>
            <li><a href="manageArtists.php">Manage Artists</a></li>
            <li><a href="manageAlbums.php">Manage Albums</a></li>
            <li><a href="manageSongs.php">Manage Songs</a></li>
            <li><a href="admin-logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Edit Album</h1>
        
        <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
        
        <form method="POST" enctype="multipart/form-data">
            <label>Title:</label>
            <input type="text" name="title" value="<?php echo $album['title']; ?>" required>
            
            <label>Artist:</label>
            <input type="text" name="artist" value="<?php echo $album['artist']; ?>" required>
            
            <label>Genre:</label>
            <input type="text" name="genre" value="<?php echo $album['genre']; ?>" required>

            <label>Current Artwork:</label>
            <br>
            <img src="../uploads/albums/<?php echo $album['artworkPath']; ?>" alt="Album Artwork">
            
            <label>Update Artwork:</label>
            <input type="file" name="artwork" accept="image/*">
            
            <button type="submit" name="updateAlbum">Update Album</button>
        </form>
    </div>

</body>
</html>


<script>
        function toggleMenu() {
            document.querySelector(".sidebar").classList.toggle("active");
        }
    </script>