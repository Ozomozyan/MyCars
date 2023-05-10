<html>
<body>
<h1>Reception des données du formulaire</h1>

<?php
// Get form data
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$contact = $_POST['contact'];
$adresse = $_POST['adresse'];
$email = $_POST['email'];
$codeAcces = password_hash($_POST['codeAcces'], PASSWORD_DEFAULT);

// Connect to the database
$base = new PDO('mysql:host=localhost;dbname=id20732448_bozudata', 'id20732448_bozu', 'C>3Gmt-4_2h3Fp)/');
$base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$base->exec("SET CHARACTER SET utf8");

// Prepare and execute the query
$sql = 'INSERT INTO client (nom, prenom, contact, adresse, email, codeAccess) VALUES (:nom, :prenom, :contact, :adresse, :email, :codeAcces)';
$stmt = $base->prepare($sql);
$stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
$stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
$stmt->bindParam(':contact', $contact, PDO::PARAM_STR);
$stmt->bindParam(':adresse', $adresse, PDO::PARAM_STR);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->bindParam(':codeAcces', $codeAcces, PDO::PARAM_STR);
$stmt->execute();

header('Location: connection.html');
?>

</br><a href="index.html">Retour à la page principale</a>
</body>
</html>
