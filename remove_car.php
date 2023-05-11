<?php
// Include your database connection file here...

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];  // Car ID
    
    $stmt = $base->prepare('DELETE FROM car WHERE id = :id');
    $stmt->bindParam(':id', $id);
    
    $stmt->execute();
}
?>
