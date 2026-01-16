<?php
session_start();
require_once '../api/config/database.php';
require_once '../api/controllers/AuthController.php';
require_once '../api/utils/logger.php';
require_once '../api/utils/logger.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $db = Database::connect();
    $stmt = $db->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'role' => $user['role']
        ];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Identifiants invalides";
        Logger::log("Login échoué : $email");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Optionnel : Bootstrap JS + Popper (pour dropdowns, modals...) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <title>Login - LRC Group</title>
</head>
<body>
<h2>Collaborateurs</h2>
<form method="POST">
    <div class="container">
  <form>
  <div class="mb-3 row">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="email" class="form-control" id="exampleInputPassword1" name="email">
  </div>
  <div class="mb-3 row">
    <input type="password" class="form-control" id="exampleCheck1" name="password">
  </div>
  <button type="submit" class="btn btn-primary">Connexion</button>
  </form>
    </div>
  
<?php if($error) echo "<p style='color:red'>$error</p>"; ?>
</body>
</html>
