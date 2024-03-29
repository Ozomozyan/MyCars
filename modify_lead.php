<?php
session_start();

if (!isset($_SESSION['admin_loggedin']) || !$_SESSION['admin_loggedin']) {
    header('Location: admin_login.html');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['leadId']) && isset($_POST['nomEntreprise']) && isset($_POST['contact']) && isset($_POST['email']) && isset($_POST['codeAccess'])) {
        $leadId = $_POST['leadId'];
        $nomEntreprise = $_POST['nomEntreprise'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];
        $codeAccess = $_POST['codeAccess'];

        // Hash the codeAccess
        $hashed_codeAccess = password_hash($codeAccess, PASSWORD_DEFAULT);

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

        // Update the lead in the database
        try {
            $stmt = $base->prepare('UPDATE leads SET nomEntreprise = :nomEntreprise, contact = :contact, email = :email, codeAccess = :codeAccess WHERE id = :leadId');
            $stmt->bindParam(':leadId', $leadId, PDO::PARAM_INT);
            $stmt->bindParam(':nomEntreprise', $nomEntreprise, PDO::PARAM_STR);
            $stmt->bindParam(':contact', $contact, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':codeAccess', $hashed_codeAccess, PDO::PARAM_STR);
            $stmt->execute();

            header('Location: admin_panel.html');
        } catch (PDOException $e) {
            error_log("Error updating lead: " . $e->getMessage());
            header('Location: 404.html');
            exit();
        }
    }
} else {
    header('Location: admin_panel.html');
}
?>
