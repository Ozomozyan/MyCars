<?php
session_start();

if ($result && password_verify($password, $result['codeAcces'])) {
    $email = $_POST['email'];
    $codeAcces = $_POST['codeAcces'];

    // Connect to the database
    try {
        $base = new PDO('mysql:host=localhost;dbname=id20732448_bozudata', 'id20732448_bozu', 'C>3Gmt-4_2h3Fp)/');
        $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $base->exec("SET CHARACTER SET utf8");
    } catch (PDOException $e) {
        // Handle database connection error
        error_log("Error connecting to database: " . $e->getMessage());
        header('Location: login.php?error=2');
        exit();
    }

    // Prepare and execute the query
    try {
        $stmt = $base->prepare('SELECT * FROM client WHERE email = :email');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($codeAcces, $result['codeAcces'])) {
            // Authentication successful
            $_SESSION['loggedin'] = true;
            $_SESSION['client_id'] = $result['id'];
            $_SESSION['email'] = $result['email'];

            // Redirect to the user's account page
            header('Location: index.html');
        } else {
            // Authentication failed
            header('Location: 404.html');
        }
    } catch (PDOException $e) {
        // Handle query error
        error_log("Error executing query: " . $e->getMessage());
        header('Location: 404.html');
        exit();
    }
} else {
    header('Location: login.php');
}
?>