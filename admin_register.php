<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['contact']) && isset($_POST['email']) && isset($_POST['codeAccess'])) {
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];
        $codeAccess = $_POST['codeAccess'];

        // Hash the codeAccess
        $hashed_codeAccess = password_hash($codeAccess, PASSWORD_DEFAULT);

        // Connect to the database
        try {
            // Replace with your database connection details
            $base = new PDO('mysql:host=localhost;dbname=id20732448_bozudata', 'id20732448_bozu', 'C>3Gmt-4_2h3Fp)/');
            $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $base->exec("SET CHARACTER SET utf8");
        } catch (PDOException $e) {
            error_log("Error connecting to database: " . $e->getMessage());
            header('Location: 404.html');
            exit();
        }

        // Insert the admin into the database
        try {
            $stmt = $base->prepare('INSERT INTO admin (prenom, nom, contact, email, codeAccess) VALUES (:prenom, :nom, :contact, :email, :codeAccess)');
            $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':contact', $contact, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':codeAccess', $hashed_codeAccess, PDO::PARAM_STR);
            $stmt->execute();

            header('Location: admin_login.html');
        } catch (PDOException $e) {
            error_log("Error inserting admin: " . $e->getMessage());
            header('Location: 404.html');
            exit();
        }
    }
} else {
    header('Location: admin_register.php');
}
?>
