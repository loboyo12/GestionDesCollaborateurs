<?php
session_start();
if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['ADMIN','RH'])) {
    header("Location: index.php");
    exit;
}

require_once '../backend/config/database.php';
require_once '../backend/models/Collaborator.php';
require_once '../backend/utils/Logger.php';

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        $_POST['matricule'],
        $_POST['first_name'],
        $_POST['last_name'],
        $_POST['email'],
        $_POST['phone'],
        $_POST['position'],
        $_POST['department'],
        $_SESSION['user']['id']
    ];

    $db = Database::connect();
    (new Collaborator($db))->create($data);
    Logger::log("Collaborateur créé : ".$_POST['matricule']);
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter Collaborateur</title>
</head>
<body>
<h2>Ajouter Collaborateur</h2>
<form method="POST">
    <input name="matricule" placeholder="Matricule" required><br>
    <input name="first_name" placeholder="Prénom"><br>
    <input name="last_name" placeholder="Nom"><br>
    <input name="email" placeholder="Email"><br>
    <input name="phone" placeholder="Téléphone"><br>
    <input name="position" placeholder="Poste"><br>
    <input name="department" placeholder="Département"><br>
    <button type="submit">Ajouter</button>
</form>
<a href="dashboard.php">Retour</a>
</body>
</html>
