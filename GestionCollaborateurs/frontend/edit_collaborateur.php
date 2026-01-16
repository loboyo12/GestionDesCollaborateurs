<?php
session_start();
require_once '../backend/init.php'; // Inclut DB, models, middleware, Logger, etc.

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

// Vérifier le rôle (ADMIN ou RH)
RoleMiddleware::allowMultiple(['ADMIN','RH'], $_SESSION['user']['role']);

$db = Database::connect();
$collaboratorModel = new Collaborator($db);

// Vérifier que l'ID est présent
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET['id'];
$collaborator = $collaboratorModel->find($id);

if (!$collaborator) {
    echo "Collaborateur introuvable";
    exit;
}

$error = "";

// Si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        $_POST['matricule'],
        $_POST['first_name'],
        $_POST['last_name'],
        $_POST['email'],
        $_POST['phone'],
        $_POST['position'],
        $_POST['department'],
        $id
    ];

    $collaboratorModel->update($data);
    Logger::log("Collaborateur modifié ID ".$id);
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier Collaborateur</title>
</head>
<body>
<h2>Modifier Collaborateur</h2>

<form method="POST">
    <input name="matricule" value="<?= htmlspecialchars($collaborator['matricule']) ?>" placeholder="Matricule" required><br>
    <input name="first_name" value="<?= htmlspecialchars($collaborator['first_name']) ?>" placeholder="Prénom"><br>
    <input name="last_name" value="<?= htmlspecialchars($collaborator['last_name']) ?>" placeholder="Nom"><br>
    <input name="email" value="<?= htmlspecialchars($collaborator['email']) ?>" placeholder="Email"><br>
    <input name="phone" value="<?= htmlspecialchars($collaborator['phone']) ?>" placeholder="Téléphone"><br>
    <input name="position" value="<?= htmlspecialchars($collaborator['position']) ?>" placeholder="Poste"><br>
    <input name="department" value="<?= htmlspecialchars($collaborator['department']) ?>" placeholder="Département"><br>
    <button type="submit">Modifier</button>
</form>

<a href="dashboard.php">Retour</a>

<?php if($error) echo "<p style='color:red'>$error</p>"; ?>
</body>
</html>
