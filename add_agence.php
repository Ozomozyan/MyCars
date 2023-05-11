<?php
session_start();

if (!isset($_SESSION['admin_loggedin']) || !$_SESSION['admin_loggedin']) {
    header('Location: admin_login.html');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nom']) && isset($_POST['adresse']) && isset($_POST['horaires']) && isset($_POST['leadId'])) {
        $nom = $_POST['nom'];
        $adresse = $_POST['adresse'];
        $horaires = $_POST['horaires'];
        $leadId = $_POST['leadId'];

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
            $stmt = $base->prepare('INSERT INTO agence (nom, adresse, horaires, leadId) VALUES (:nom, :adresse, :horaires, :leadId)');
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':adresse', $adresse, PDO::PARAM_STR);
            $stmt->bindParam(':horaires', $horaires, PDO::PARAM_STR);
            $stmt->bindParam(':leadId', $leadId, PDO::PARAM_INT);
            $stmt->execute();

            header('Location: admin_panel.html');
        } catch (PDOException $e) {
            error_log("Error adding agency: " . $e->getMessage());
            header('Location: 404.html');
            exit();
        }
    }
} else {
    header('Location: admin_panel.html');
}
?>
