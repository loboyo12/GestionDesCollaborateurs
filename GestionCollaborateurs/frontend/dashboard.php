<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

require_once '../backend/config/database.php';
require_once '../backend/models/Collaborator.php';

$db = Database::connect();
$collaborators = (new Collaborator($db))->all();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - LRC Group</title>
</head>
<body>
<h2>Bienvenue, <?php echo $_SESSION['user']['email']; ?></h2>
<a href="add_collaborator.php">Ajouter Collaborateur</a> | <a href="logout.php">Déconnexion</a>

<h3>Liste des collaborateurs</h3>
<table border="1">
    <tr>
        <th>Matricule</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Poste</th>
        <th>Département</th>
        <th>Status</th>
        <?php if($_SESSION['user']['role'] === 'ADMIN') echo "<th>Actions</th>"; ?>
    </tr>
    <?php foreach($collaborators as $c): ?>
        <tr>
            <td><?= $c['matricule'] ?></td>
            <td><?= $c['last_name'] ?></td>
            <td><?= $c['first_name'] ?></td>
            <td><?= $c['position'] ?></td>
            <td><?= $c['department'] ?></td>
            <td><?= $c['status'] ?></td>
            <?php if($_SESSION['user']['role'] === 'ADMIN'): ?>
                <td>
                    <a href="edit_collaborator.php?id=<?= $c['id'] ?>">Modifier</a> |
                    <a href="delete_collaborator.php?id=<?= $c['id'] ?>" onclick="return confirm('Supprimer ?')">Supprimer</a>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
