<?php
// Include your database connection file here...

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $agentId = $_POST["agentId"];  // You need to get agentId from session or somewhere safe...
    $marque = $_POST["marque"];
    $modele = $_POST["modele"];
    $annee = $_POST["annee"];
    $prix = $_POST["prix"];
    
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
?>
