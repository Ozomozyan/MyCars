<?php
session_start();

if (isset($_POST['email']) && isset($_POST['codeAccess'])) {
    $email = $_POST['email'];
    $codeAccess = $_POST['codeAccess'];

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

    // Check if the admin exists
    try {
        $stmt = $base->prepare('SELECT * FROM admin WHERE email = :email');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($codeAccess, $result['codeAccess'])) {
            // Log the admin in
            $_SESSION['admin_loggedin'] = true;
            $_SESSION['admin_id'] = $result['id'];
            $_SESSION['admin_prenom'] = $result['prenom'];
            $_SESSION['admin_nom'] = $result['nom'];
            $_SESSION['admin_email'] = $result['email'];

            header('Location: admin_panel.php');
        } else {
            // Invalid email or codeAccess
            header('Location: 404.html');
        }
    } catch (PDOException $e) {
        error_log("Error checking admin: " . $e->getMessage());
        header('Location: 404.html');
        exit();
    }
} else {
    header('Location: admin_login.php');
}
?>
