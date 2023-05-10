<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_loggedin']) || !$_SESSION['admin_loggedin']) {
    header('Location: admin_login.php');
    exit();
}

// Get the admin's full name
$admin_full_name = $_SESSION['admin_prenom'] . ' ' . $_SESSION['admin_nom'];

// Load the admin_panel.html file
$admin_panel_html = file_get_contents('admin_panel.html');

// Replace the placeholder with the admin's full name
$admin_panel_html = str_replace('{{admin_full_name}}', $admin_full_name, $admin_panel_html);

// Output the final HTML
echo $admin_panel_html;
?>
