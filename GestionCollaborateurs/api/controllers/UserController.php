<?php
class UserController {
    public static function create($db, $userRole) {
        RoleMiddleware::allow('ADMIN', $userRole);

        $data = json_decode(file_get_contents("php://input"), true);
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        $user = new User($db);
        $user->create($data);

        Logger::log("Utilisateur créé : ".$data['email']);
        Response::json(['message'=>'Utilisateur créé']);
    }

    public static function index($db) {
        Response::json((new User($db))->all());
    }

    public static function delete($db, $id, $userRole) {
        RoleMiddleware::allow('ADMIN', $userRole);
        (new User($db))->delete($id);
        Logger::log("Utilisateur supprimé ID ".$id);
        Response::json(['message'=>'Supprimé']);
    }
}
