<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['contact']) && isset($_POST['codeAccess'])) {
        $contact = $_POST['contact'];
        $codeAccess = $_POST['codeAccess'];

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

        // Check the credentials
        try {
            $stmt = $base->prepare('SELECT id, codeAccess FROM agent WHERE contact = :contact');
            $stmt->bindParam(':contact', $contact, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result && password_verify($codeAccess, $result['codeAccess'])) {
                // Credentials are correct, log the user in
                $_SESSION['agent_loggedin'] = true;
                $_SESSION['agent_id'] = $result['id'];
                header('Location: agent_panel.html');
                exit();
            } else {
                // Credentials are not correct, redirect back to the login page
                header('Location: agent_login.html');
                exit();
            }
        } catch (PDOException $e) {
            error_log("Error checking credentials: " . $e->getMessage());
            header('Location: 404.html');
            exit();
        }
    }
} else {
    header('Location: agent_login.html');
}
?>
