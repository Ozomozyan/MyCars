<?php
// Include your database connection file here...

// Fetch all cars from the database
$stmt = $base->prepare('SELECT id, marque, modele, annee, prix FROM car WHERE agenceId = :agenceId');
$stmt->bindParam(':agenceId', $_SESSION['agenceId']);  // Or wherever you're storing the logged-in agent's agenceId
$stmt->execute();

$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($cars);
?>
