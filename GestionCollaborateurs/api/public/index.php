<?php
// Headers sécurité
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Autoriser pré-vol OPTIONS pour CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Autoload et fichiers de configuration
require_once '../vendor/autoload.php';
require_once '../config/database.php';
require_once '../config/jwt.php';
require_once '../utils/Response.php';
require_once '../utils/Logger.php';
require_once '../middleware/AuthMiddleware.php';
require_once '../middleware/RoleMiddleware.php';
require_once '../models/User.php';
require_once '../models/Collaborator.php';
require_once '../controllers/AuthController.php';
require_once '../controllers/UserController.php';
require_once '../controllers/CollaboratorController.php';
require_once '../routes.php';
