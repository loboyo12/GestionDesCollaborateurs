<?php
class CollaboratorController {

    public static function index($db) {
        Response::json((new Collaborator($db))->all());
    }

    public static function create($db, $user) {
        RoleMiddleware::allowMultiple(['ADMIN','RH'], $user->role);

        $data = json_decode(file_get_contents("php://input"), true);
        $data['created_by'] = $user->id;

        (new Collaborator($db))->create([
            $data['matricule'],
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['phone'],
            $data['position'],
            $data['department'],
            $data['created_by']
        ]);

        Logger::log("Collaborateur créé : ".$data['matricule']);
        Response::json(['message'=>'Collaborateur ajouté']);
    }

    public static function delete($db, $id, $user) {
        RoleMiddleware::allow('ADMIN', $user->role);
        (new Collaborator($db))->delete($id);
        Logger::log("Collaborateur supprimé ID ".$id);
        Response::json(['message'=>'Collaborateur supprimé']);
    }
}
