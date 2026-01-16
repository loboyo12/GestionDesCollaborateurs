<?php
class RoleMiddleware {
    public static function allow($role, $userRole) {
        if ($role !== $userRole) {
            Response::json(['error'=>'Accès refusé'], 403);
        }
    }

    public static function allowMultiple($roles, $userRole) {
        if (!in_array($userRole, $roles)) {
            Response::json(['error'=>'Accès refusé'], 403);
        }
    }
}