<?php
session_start();

if (!isset($_SESSION['admin_loggedin']) || !$_SESSION['admin_loggedin']) {
    header('Location: admin_login.html');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['agenceId'])) {
        $agenceId = $_POST['agenceId'];

        try {
            $base = new PDO('mysql:host=localhost;dbname=id20732448_bozudata', 'id20732448_bozu', 'C>3Gmt-4_2h3Fp)/');
            $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $base->exec("SET CHARACTER SET utf8");
        } catch (PDOException $e) {
            error_log("Error connecting to database: " . $e->getMessage());
            header('Location: 404.html');
            exit();
        }

        try {
            $stmt = $base->prepare('DELETE FROM agence WHERE id = :agenceId');
            $stmt->bindParam(':agenceId', $agenceId, PDO::PARAM_INT);
            $stmt->execute();

            header('Location: admin_panel.html');
        } catch (PDOException $e) {
            error_log("Error removing agency: " . $e->getMessage());
            header('Location: 404.html');
            exit();
        }
    }
} else {
    header('Location: admin_panel.html');
}
?>
