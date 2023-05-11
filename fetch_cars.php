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

// Fetch agenceId for the logged-in agent
$stmt = $base->prepare('SELECT agenceId FROM agent WHERE id = :agentId');
$stmt->bindParam(':agentId', $_SESSION['agent_id']);  // Assuming you're storing the logged-in agent's ID in the session under 'agent_id'
$stmt->execute();

$agenceId = $stmt->fetchColumn();

if ($agenceId === false) {
    // Handle error: agent not found
    echo json_encode(['error' => 'Agent not found']);
    exit();
}

// Fetch all cars from the database for the agency
$stmt = $base->prepare('SELECT id, marque, modele, annee, prix FROM voiture WHERE agenceId = :agenceId');
$stmt->bindParam(':agenceId', $agenceId);
$stmt->execute();

$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($cars);
?>
