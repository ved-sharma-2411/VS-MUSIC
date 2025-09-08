<?php
session_start();
include("../Includes/config.php"); // Database Connection

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin-login.php");
    exit();
}

// Fetch total counts from the database
$totalUsersQuery = mysqli_query($con, "SELECT COUNT(*) as count FROM users");
$totalSongsQuery = mysqli_query($con, "SELECT COUNT(*) as count FROM songs");
$totalArtistsQuery = mysqli_query($con, "SELECT COUNT(*) as count FROM artists");
$totalAlbumsQuery = mysqli_query($con, "SELECT COUNT(*) as count FROM albums");

$totalUsers = mysqli_fetch_assoc($totalUsersQuery)['count'];
$totalSongs = mysqli_fetch_assoc($totalSongsQuery)['count'];
$totalArtists = mysqli_fetch_assoc($totalArtistsQuery)['count'];
$totalAlbums = mysqli_fetch_assoc($totalAlbumsQuery)['count'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - VS Music</title>
    <link rel="icon" type="image/png" href="Logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Icons -->
    <link rel="stylesheet" href="assets/css/admin.css"> <!-- Custom Admin CSS -->
    <link rel="icon" type="image/png" href="Logo.png">
    <style>
        /* ✅ General Styling */
        body {
            font-family: 'Poppins', sans-serif;
            background: #121212;
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            animation: fadeIn 1.5s ease-in-out;
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

        /* ✅ Enable horizontal scrolling on small screens */
        .main-content {
            margin-left: 220px;
            padding: 30px;
            width: calc(100% - 270px);
            overflow-x: auto;
            /* Enable left-right scrolling */
            white-space: nowrap;
            /* Prevent content from breaking */
            transition: 0.3s ease-in-out;
        }

        h1 {
            font-size: 2.5vw;
            /* Scales with screen width */
            color: #1DB954;
            margin-left: 50px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 20px;
            max-width: 90%;
            text-align: center;
        }

        /* ✅ Stats Cards */
        .stats {
            display: grid;
            margin-left: 50px;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .card {
            background: #222;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0px 0px 15px rgba(29, 185, 84, 0.5);
            transition: 0.3s;
            text-decoration: none;
            color: white;
        }

        .card:hover {
            box-shadow: 0px 0px 25px rgba(29, 185, 84, 1);
            transform: scale(1.05);
        }

        .card h3 {
            color: #1DB954;
            font-size: 20px;
        }

        .card p {
            font-size: 24px;
            font-weight: bold;
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
                transition: left 0.3s ease-in-out;
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
                transition: margin-left 0.3s ease-in-out;
                overflow-x: auto;
                /* ✅ Allows horizontal scrolling */
                white-space: nowrap;
            }

            h1 {
                font-size: 5vw;
                /* Bigger on small screens */
                margin-left: 0;
                text-align: center;
                /* Center-align on mobile */
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
        <h1>Welcome, Ved Sharma!</h1>
        <div class="stats">
            <a href="manageUsers.php" class="card">
                <h3>Total Users</h3>
                <p><?php echo $totalUsers; ?></p>
            </a>
            <a href="manageArtists.php" class="card">
                <h3>Total Artists</h3>
                <p><?php echo $totalArtists; ?></p>
            </a>
            <a href="manageAlbums.php" class="card">
                <h3>Total Albums</h3>
                <p><?php echo $totalAlbums; ?></p>
            </a>
            <a href="manageSongs.php" class="card">
                <h3>Total Songs</h3>
                <p><?php echo $totalSongs; ?></p>
            </a>
        </div>
    </div>

    <script>
        function toggleMenu() {
            document.querySelector(".sidebar").classList.toggle("active");
        }
    </script>

</body>

</html>