<?php
include("Includes/includedFiles.php");

// Check if user is not logged in (not just guest) - show popup
if (!isset($userLoggedIn) || $userLoggedIn == null) {
    echo "<script>
            if (confirm('You need to login to access this feature. Would you like to login now?')) {
                window.location.href = 'login.php?direct=1';
            } else {
                history.back();
            }
        </script>";
    exit();
}
?>

<style>
    /* General Styles */
    .entityInfo {

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Mobile responsive styles */
        @media screen and (max-width: 768px) {
            .userDetails {
                width: 95%;
                padding: 20px;
            }

            .container {
                padding: 15px;
                margin-bottom: 15px;
            }

            h2 {
                font-size: 16px;
            }

            input {
                padding: 10px;
                font-size: 14px;
            }

            .button {
                padding: 10px;
                font-size: 14px;
            }

            .table100 {
                font-size: 13px;
            }

            .table100-body {
                max-height: 400px;
            }
        }

        @media screen and (max-width: 480px) {
            .userDetails {
                width: 100%;
                padding: 15px;
            }

            .entityInfo {
                padding: 20px;
            }

            .userInfo h1 {
                font-size: 24px;
            }

            .container {
                padding: 12px;
            }

            h2 {
                font-size: 14px;
                margin-bottom: 8px;
            }

            input {
                padding: 8px;
                font-size: 13px;
            }

            .button {
                padding: 8px;
                font-size: 13px;
            }

            .table100 th,
            .table100 td {
                padding: 8px;
                font-size: 12px;
            }
        }

        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 30px;
        border-radius: 15px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.3);
        animation: fadeIn 1s ease-in-out forwards;
    }

    .userInfo h1 {
        font-size: 28px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: white;
        text-shadow: 2px 2px 10px rgba(255, 255, 255, 0.5);
    }

    /* Buttons */
    .buttonItems {
        margin-top: 20px;
    }

    .button {
        background: linear-gradient(135deg, #1DB954, #1ED760);
        border: none;
        padding: 12px 20px;
        border-radius: 25px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
        color: white;
        box-shadow: 0px 5px 15px rgba(0, 255, 100, 0.3);
    }

    .button:hover {
        transform: scale(1.1);
        box-shadow: 0px 10px 30px rgba(0, 255, 100, 0.6);
    }

    /* Tables */
    h2 {
        font-size: 22px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: white;
        margin-top: 30px;
        text-align: center;
        animation: fadeIn 1s ease-in-out forwards;
    }

    .table100 {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(8px);
        border-radius: 10px;
        overflow: hidden;
        animation: fadeInUp 0.8s ease-in-out forwards;
    }

    .table100 th,
    .table100 td {
        padding: 12px;
        text-align: center;
        color: white;
    }

    .table100 th {
        background: rgba(255, 255, 255, 0.2);
    }

    .table100 tr {
        transition: background 0.3s ease-in-out;
    }

    .table100 tr:hover {
        background: rgba(255, 255, 255, 0.3);
        cursor: pointer;
    }

    /* Remove Icon */
    .removeIcon {
        width: 20px;
        cursor: pointer;
        transition: transform 0.2s ease-in-out;
    }

    .removeIcon:hover {
        transform: scale(1.2);
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="entityInfo">
    <div class="centerSection">
        <div class="userInfo">
            <h1><?php echo $userLoggedIn->getName(); ?></h1>
        </div>
    </div>

    <div class="buttonItems">
        <button class="button" onclick="openPage('updateDetails.php')">USER DETAILS</button>
        <button class="button" onclick="logout()">LOGOUT</button>
    </div>

    <?php
    if ($userLoggedIn->isAdmin()) {
        // USERS
        $query = mysqli_query($con, "SELECT id,username,email,admin FROM users");
        echo "<h2>Users</h2>";
        echo "<div class='table100 ver3 m-b-110'>";
        echo "<table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Admin</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>";
        while ($row = mysqli_fetch_array($query)) {
            if ($row['username'] == $userLoggedIn->getUsername()) {
                continue;
            }
            $isAdmin = $row['admin'] ? "Yes" : "No";
            echo "<tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['username'] . "</td>
                            <td>" . $row['email'] . "</td>
                            <td>" . $isAdmin . "</td>
                            <td>
                                <img src='assets/images/Icons/remove.png' class='removeIcon' onclick='deleteUser(\"" . $row['id'] . "\")'>
                            </td>
                        </tr>";
        }
        echo "</tbody>
                    </table>";
        echo "</div>";

        // SONGS
        $query = mysqli_query($con, "SELECT id,title,plays FROM songs");
        echo "<h2>Songs</h2>";
        echo "<div class='table100 ver3 m-b-110'>";
        echo "<table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th># Plays</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>";
        while ($row = mysqli_fetch_array($query)) {
            echo "<tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['title'] . "</td>
                            <td>" . $row['plays'] . "</td>
                            <td>
                                <img src='assets/images/Icons/remove.png' class='removeIcon' onclick='deleteSong(\"" . $row['id'] . "\")'>
                            </td>
                        </tr>";
        }
        echo "</tbody>
                    </table>";
        echo "</div>";
    }
    ?>
</div>

<script src="assets/js/perfect-scrollbar.min.js"></script>
<script>
    $('.js-pscroll').each(function () {
        var ps = new PerfectScrollbar(this);
        $(window).on('resize', function () {
            ps.update();
        })
    });
</script>