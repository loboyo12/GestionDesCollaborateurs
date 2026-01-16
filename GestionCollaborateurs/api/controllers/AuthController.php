<?php
/**
 * AuthController
 * Gestion de l'authentification (JWT)
 * LRC Group
 */

use Firebase\JWT\JWT;

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/jwt.php';

class AuthController
{
    public static function login()
    {
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->email, $data->password)) {
            http_response_code(400);
            exit(json_encode(["error" => "Email ou mot de passe manquant"]));
        }

        $db = Database::connect();

        $stmt = $db->prepare("SELECT id, email, password, role FROM users WHERE email = ?");
        $stmt->execute([$data->email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($data->password, $user['password'])) {
            http_response_code(401);
            exit(json_encode(["error" => "Identifiants incorrects"]));
        }

        $payload = [
            "iss" => JWT_ISSUER,
            "aud" => JWT_AUDIENCE,
            "iat" => time(),
            "exp" => time() + JWT_EXPIRE_TIME,
            "data" => [
                "id"   => $user['id'],
                "role" => $user['role']
            ]
        ];

        $token = JWT::encode($payload, JWT_SECRET, JWT_ALGO);

        echo json_encode([
            "token" => $token,
            "role"  => $user['role']
        ]);
    }
}