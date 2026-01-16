<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthMiddleware {
    public static function check() {
        $headers = getallheaders();
        if (!isset($headers['Authorization'])) {
            Response::json(['error'=>'Token manquant'], 401);
        }

        $token = explode(' ', $headers['Authorization'])[1];

        try {
            return JWT::decode($token, new Key(JWT_SECRET, 'HS256'));
        } catch (Exception $e) {
            Response::json(['error'=>'Token invalide'], 401);
        }
    }
}