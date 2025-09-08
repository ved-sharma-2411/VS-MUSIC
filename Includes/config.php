<?php
// Prevent session_start() error by checking if a session is already active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$timezone = date_default_timezone_set("Asia/Kolkata");

$con = mysqli_connect("localhost", "root", "", "VG_MUSIC");

// Check if database connection is successful
if (mysqli_connect_errno()) {
    echo "Failed to connect: " . mysqli_connect_error();
    exit(); // Stop execution if there's a connection error
}
?>