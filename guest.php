<?php
session_start();
$_SESSION['isGuest'] = true;
header("Location: index.php");
?>