<?php
session_start();

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

// Fetch all cars from the database
$stmt = $base->prepare('SELECT id, marque, modele, annee, prix FROM voiture WHERE agenceId = :agenceId');
$stmt->bindParam(':agenceId', $_SESSION['agenceId']);  // Or wherever you're storing the logged-in agent's agenceId
$stmt->execute();

$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($cars);
?>
