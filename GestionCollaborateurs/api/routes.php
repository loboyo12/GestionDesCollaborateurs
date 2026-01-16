<?php
$db = Database::connect();
$uri = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
$method = $_SERVER['REQUEST_METHOD'];

// ------------------- AUTH -------------------
if ($uri[0] === 'api' && isset($uri[1]) && $uri[1] === 'login' && $method === 'POST') {
    AuthController::login($db);
    exit;
}

// Vérifier token JWT pour toutes les autres routes
$user = AuthMiddleware::check();

// ------------------- UTILISATEURS -------------------
if ($uri[0] === 'api' && isset($uri[1]) && $uri[1] === 'users') {
    if ($method === 'GET') UserController::index($db); // Liste utilisateurs
    if ($method === 'POST') UserController::create($db, $user->role); // Créer utilisateur
    if ($method === 'DELETE' && isset($uri[2])) UserController::delete($db, $uri[2], $user->role); // Supprimer utilisateur
    exit;
}

// ------------------- COLLABORATEURS -------------------
if ($uri[0] === 'api' && isset($uri[1]) && $uri[1] === 'collaborators') {
    if ($method === 'GET' && !isset($uri[2])) CollaboratorController::index($db); // Liste collaborateurs
    if ($method === 'POST') CollaboratorController::create($db, $user); // Créer collaborateur
    if ($method === 'DELETE' && isset($uri[2])) CollaboratorController::delete($db, $uri[2], $user); // Supprimer collaborateur
    exit;
}

// Route non trouvée
Response::json(['error'=>'Route non trouvée'], 404);
