<?php
// Include your database connection file here...

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];  // Car ID
    $marque = $_POST["marque"];
    $modele = $_POST["modele"];
    $annee = $_POST["annee"];
    $prix = $_POST["prix"];
    
    $stmt = $base->prepare('UPDATE car SET marque = :marque, modele = :modele, annee = :annee, prix = :prix WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':marque', $marque);
    $stmt->bindParam(':modele', $modele);
    $stmt->bindParam(':annee', $annee);
    $stmt->bindParam(':prix', $prix);
    
    $stmt->execute();
}
?>
