<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_loggedin']) || !$_SESSION['admin_loggedin']) {
    header('Location: admin_login.html');
    exit();
}

// Connect to the database
try {
    $base = new PDO('mysql:host=localhost;dbname=id20732448_bozudata', 'id20732448_bozu', 'C>3Gmt-4_2h3Fp)/');
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $base->exec("SET CHARACTER SET utf8");
} catch (PDOException $e) {
    error_log("Error connecting to database: " . $e->getMessage());
    header('Location: 404.html');
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        // Get form data
        $id = $_POST['id'];

        // Remove from the database
        try {
            $stmt = $base->prepare('DELETE FROM agent WHERE id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            header('Location: admin_panel.html');
        } catch (PDOException $e) {
            error_log("Error removing agent: " . $e->getMessage());
            header('Location: 404.html');
            exit();
        }
    }
}
?>
