<?php
header('Content-Type: application/json');

// Connect to the database
try {
    $base = new PDO('mysql:host=localhost;dbname=id20732448_bozudata', 'id20732448_bozu', 'C>3Gmt-4_2h3Fp)/');
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $base->exec("SET CHARACTER SET utf8");
} catch (PDOException $e) {
    error_log("Error connecting to database: " . $e->getMessage());
    echo json_encode(["error" => "Error connecting to database"]);
    exit();
}

// Fetch all agents from the database
try {
    $stmt = $base->prepare('SELECT id, prenom, nom FROM agent');
    $stmt->execute();

    $agents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($agents);
} catch (PDOException $e) {
    error_log("Error fetching agents: " . $e->getMessage());
    echo json_encode(["error" => "Error fetching agents"]);
    exit();
}
?>
