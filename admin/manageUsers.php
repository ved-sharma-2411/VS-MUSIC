<?php
session_start();
include("../Includes/config.php"); // Database Connection

// ✅ Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin-login.php");
    exit();
}

// ✅ Fetch all users
$usersQuery = mysqli_query($con, "SELECT * FROM users");

// ✅ Delete User
if (isset($_GET['delete'])) {
    $userId = $_GET['delete'];
    mysqli_query($con, "DELETE FROM users WHERE id='$userId'");
    header("Location: manageUsers.php");
    exit();
}

// ✅ Block/Unblock User
if (isset($_GET['block'])) {
    $userId = $_GET['block'];
    mysqli_query($con, "UPDATE users SET status='blocked' WHERE id='$userId'");
    header("Location: manageUsers.php");
    exit();
}

if (isset($_GET['unblock'])) {
    $userId = $_GET['unblock'];
    mysqli_query($con, "UPDATE users SET status='active' WHERE id='$userId'");
    header("Location: manageUsers.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin Panel</title>
    <link rel="icon" type="image/png" href="Logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin.css"> 
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #121212;
            color: white;
            margin: 0;
            padding: 0;
        }

        /* ✅ Enable horizontal scrolling on small screens */
.main-content {
    margin-left: 260px;
    padding: 30px;
    width: calc(100% - 270px);
    overflow-x: auto; /* Enable left-right scrolling */
    white-space: nowrap; /* Prevent content from breaking */
    transition: 0.3s ease-in-out;
}
        
        /* ✅ Sidebar (Glassmorphism + Neon Glow) */
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
        transition: margin-left 0.3s ease-in-out;
        overflow-x: auto; /* ✅ Allows horizontal scrolling */
        white-space: nowrap;
           }
      }


        h1 {
            color: #1DB954;
        }
        
        /* ✅ Table Styling */
        table {
            width: 90%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #222;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 0px 10px rgba(29, 185, 84, 0.5);
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #333;
            transition: 0.3s;
        }
        th {
            background: #1DB954;
            color: black;
        }
        td:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        
        /* ✅ Buttons */
        td a {
            padding: 8px 12px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            display: inline-block;
            transition: 0.3s;
            position: relative;
            overflow: hidden;
        }
        .delete { background: red; }
        .delete:hover { background: darkred; }
        .block { background: orange; }
        .block:hover { background: darkorange; }
        .unblock { background: green; }
        .unblock:hover { background: darkgreen; }

    </style>
</head>
<body>

<div class="menu-toggle" onclick="toggleMenu()">☰</div>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <ul>
        <li><a href="admin.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="manageUsers.php"><i class="fas fa-users"></i> Manage Users</a></li>
        <li><a href="manageArtists.php"><i class="fas fa-microphone-alt"></i> Manage Artists</a></li>
        <li><a href="manageAlbums.php"><i class="fas fa-record-vinyl"></i> Manage Albums</a></li>
        <li><a href="manageSongs.php"><i class="fas fa-music"></i> Manage Songs</a></li>
        <li><a href="admin-logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>

<div class="main-content">
    <h1>Manage Users</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($user = mysqli_fetch_assoc($usersQuery)) { ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['username']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo ucfirst($user['status'] ?? 'Unknown'); ?></td>
            <td>
                <a href="manageUsers.php?delete=<?php echo $user['id']; ?>" class="delete">Delete</a>
                <?php if ($user['status'] == 'active') { ?>
                    <a href="manageUsers.php?block=<?php echo $user['id']; ?>" class="block">Block</a>
                <?php } else { ?>
                    <a href="manageUsers.php?unblock=<?php echo $user['id']; ?>" class="unblock">Unblock</a>
                <?php } ?>
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
