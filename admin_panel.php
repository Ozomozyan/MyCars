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

<form method="POST" action="add_lead.php">
  <label for="nomEntreprise">Nom Entreprise:</label>
  <input type="text" name="nomEntreprise" id="nomEntreprise" required>
  <br>
  <label for="contact">Contact:</label>
  <input type="text" name="contact" id="contact" required>
  <br>
  <label for="email">Email:</label>
  <input type="email" name="email" id="email" required>
  <br>
  <label for="codeAccess">Code Access:</label>
  <input type="password" name="codeAccess" id="codeAccess" required>
  <br>
  <input type="submit" value="Add Lead">
</form>
