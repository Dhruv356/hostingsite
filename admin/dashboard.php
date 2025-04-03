<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include "../db.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="dashboard">
        <h2>Welcome, Admin</h2>
        <nav>
            <ul>
                <li><a href="service.php">Manage Services</a></li>
                <li><a href="manage_pricing.php">Manage Pricing</a></li>
                <li><a href="manage_about.php">Edit About Section</a></li>
                <li><a href="manage_contact.php">Edit Contact Info</a></li>
                <li><a href="manage_slider.php">edit slider</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</body>
</html>
