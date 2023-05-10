<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_loggedin']) || !$_SESSION['admin_loggedin']) {
    header('Location: admin_login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>

<body>
    <h1>Welcome, <?= $_SESSION['admin_prenom'] . ' ' . $_SESSION['admin_nom'] ?>!</h1>
    <h2>Admin Panel</h2>

    <!-- Add your admin panel features here -->

    <a href="admin_logout.php">Logout</a>
</body>

</html>
