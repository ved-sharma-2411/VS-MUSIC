<?php
session_start();
include("../Includes/config.php"); // Database connection

// ✅ Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin-login.php");
    exit();
}

// ✅ Handle Artist Addition
if (isset($_POST['addArtist'])) {
    $artistId = mysqli_real_escape_string($con, $_POST['artistId']);
    $artistName = mysqli_real_escape_string($con, $_POST['artistName']);

    if (empty($artistId) || empty($artistName)) {
        $error = "Both fields are required!";
    } else {
        // ✅ Insert into database
        $query = mysqli_query($con, "INSERT INTO artists (id, name) VALUES ('$artistId', '$artistName')");
        if ($query) {
            header("Location: manageArtists.php?success=Artist Added Successfully!");
            exit();
        } else {
            $error = "Error adding artist!";
        }
    }
}

// ✅ Handle Artist Deletion
if (isset($_GET['delete'])) {
    $artistId = $_GET['delete'];
    mysqli_query($con, "DELETE FROM artists WHERE id='$artistId'");
    header("Location: manageArtists.php?success=Artist Deleted!");
    exit();
}

// ✅ Fetch all artists
$artistsQuery = mysqli_query($con, "SELECT * FROM artists");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Artists - Admin Panel</title>
    <link rel="icon" type="image/png" href="Logo.png">
    <link rel="stylesheet" href="assets/css/admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"> <!-- Icons -->
   
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
        <h1>Manage Artists</h1>

        <!-- ✅ Display Success/Error Messages -->
        <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
        <?php if (isset($_GET['success'])) { echo "<p style='color:green;'>" . $_GET['success'] . "</p>"; } ?>

        <!-- ✅ Add New Artist Form -->
        <form method="POST">
            <h2>Add New Artist</h2>
            <input type="text" name="artistId" placeholder="Artist ID" required>
            <input type="text" name="artistName" placeholder="Artist Name" required>
            <button type="submit" name="addArtist">Add Artist</button>
        </form>

        <h2>Existing Artists</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            <?php while ($artist = mysqli_fetch_assoc($artistsQuery)) { ?>
            <tr>
                <td><?php echo $artist['id']; ?></td>
                <td><?php echo $artist['name']; ?></td>
                <td>
                    <a href="editArtist.php?id=<?php echo $artist['id']; ?>" class="edit">Edit</a>
                    <a href="manageArtists.php?delete=<?php echo $artist['id']; ?>" class="delete" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>

</body>
</html>

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
}   .main-content {
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
        margin-bottom: 20px;
        width: 50%;
    }
    form input, form button {
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
    th, td {
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
        background: blue;
    }
    .edit:hover {
        background: darkblue;
    }

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

</style>

<script>
        function toggleMenu() {
            document.querySelector(".sidebar").classList.toggle("active");
        }
    </script>