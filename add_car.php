<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // You need to get agentId from session or somewhere safe...
    if(isset($_SESSION["agent_id"])) {
        $agentId = $_SESSION["agent_id"];
        $marque = $_POST["marque"];
        $modele = $_POST["modele"];
        $annee = $_POST["annee"];
        $prix = $_POST["prix"];

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

        $stmt = $base->prepare('SELECT agenceId FROM agent WHERE id = :agentId');
        $stmt->bindParam(':agentId', $agentId);
        $stmt->execute();

        $agenceId = $stmt->fetchColumn();

        if ($agenceId !== false) {
            $stmt = $base->prepare('INSERT INTO car (marque, modele, annee, prix, agenceId) VALUES (:marque, :modele, :annee, :prix, :agenceId)');
            $stmt->bindParam(':marque', $marque);
            $stmt->bindParam(':modele', $modele);
            $stmt->bindParam(':annee', $annee);
            $stmt->bindParam(':prix', $prix);
            $stmt->bindParam(':agenceId', $agenceId);

            $stmt->execute();
        } else {
            // Error: agent not found
        }
    }
}
?>
