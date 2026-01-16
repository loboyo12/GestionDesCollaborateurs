<?php
class Collaborator {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data) {
        $sql = "INSERT INTO collaborators
        (matricule,first_name,last_name,email,phone,position,department,created_by)
        VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function all() {
        return $this->db->query(
            "SELECT id,matricule,first_name,last_name,position,department,status
             FROM collaborators"
        )->fetchAll();
    }

    public function find($id) {
        $stmt = $this->db->prepare(
            "SELECT * FROM collaborators WHERE id=?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function update($id, $data) {
        $sql = "UPDATE collaborators SET
                first_name=?, last_name=?, email=?, phone=?,
                position=?, department=?, status=?
                WHERE id=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([...$data, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare(
            "DELETE FROM collaborators WHERE id=?"
        );
        return $stmt->execute([$id]);
    }
}
