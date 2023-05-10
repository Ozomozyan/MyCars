<?php
session_start();

// Destroy the admin session
unset($_SESSION['admin_loggedin']);
unset($_SESSION['admin_id']);
unset($_SESSION['admin_prenom']);
unset($_SESSION['admin_nom']);
unset($_SESSION['admin_email']);

header('Location: admin_login.php');
?>