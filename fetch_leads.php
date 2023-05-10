<?php
header('Content-Type: application/json');

// Connect to the database
try {
    $base = new PDO('mysql:host=localhost;dbname=id20732448_bozudata', 'id20732448_bozu', 'C>3Gmt-4_2h3Fp)/');
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $base->exec("SET CHARACTER SET utf8");
} catch (PDOException $e) {
    error_log("Error connecting to database: " . $e->getMessage());
    http_response_code(500);
    exit();
}

// Retrieve leads from the database
try {
    $stmt = $base->prepare('SELECT id, nomEntreprise, contact, email FROM leads');
    $stmt->execute();
    $leads = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($leads);
} catch (PDOException $e) {
    error_log("Error fetching leads: " . $e->getMessage());
    http_response_code(500);
    exit();
}
?>
