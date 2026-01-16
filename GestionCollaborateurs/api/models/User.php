<?php
class User {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data) {
        $sql = "INSERT INTO users (name,email,password,role)
                VALUES (:name,:email,:password,:role)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function all() {
        return $this->db->query("SELECT id,name,email,role FROM users")->fetchAll();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT id,name,email,role FROM users WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id=?");
        return $stmt->execute([$id]);
    }
}
