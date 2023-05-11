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
    if (isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['contact']) && isset($_POST['adresse']) && isset($_POST['codeAccess']) && isset($_POST['agenceId'])) {

        // Get form data
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $contact = $_POST['contact'];
        $adresse = $_POST['adresse'];
        $codeAccess = password_hash($_POST['codeAccess'], PASSWORD_DEFAULT);
        $agenceId = $_POST['agenceId'];

        // Insert into the database
        try {
            $stmt = $base->prepare('INSERT INTO agent (prenom, nom, contact, adresse, codeAccess, agenceId) VALUES (:prenom, :nom, :contact, :adresse, :codeAccess, :agenceId)');
            $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':contact', $contact, PDO::PARAM_STR);
            $stmt->bindParam(':adresse', $adresse, PDO::PARAM_STR);
            $stmt->bindParam(':codeAccess', $codeAccess, PDO::PARAM_STR);
            $stmt->bindParam(':agenceId', $agenceId, PDO::PARAM_INT);
            $stmt->execute();

            header('Location: admin_panel.html');
        } catch (PDOException $e) {
            error_log("Error adding agent: " . $e->getMessage());
            header('Location: 404.html');
            exit();
        }
    }
}
?>
