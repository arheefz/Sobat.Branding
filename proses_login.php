<?php
include 'config/db.php';
$_SESSION['user_id'] = 1;
$_SESSION['username'] = "User Google";
$_SESSION['role'] = "client";
header("Location: index.php?page=dashboard"); // Langsung ke Dashboard
?>