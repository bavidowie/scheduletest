<?php
require_once('models/base_model.php');

class assignments_model extends base_model {
    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        $stmt = $this->db->prepare("
            SELECT *
            FROM assignments");
        $stmt->execute();
        $res = $stmt->get_result();
        $response = [];
        while ($row = $res->fetch_assoc()) {
            $response[] = $row;
        }
        return $response;
    }
    public function insertOne($fields) {
        $stmt = $this->db->prepare("INSERT INTO assignments (username, email, details) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $fields['username'], $fields['email'], $fields['details']);
        return $stmt->execute();
    }
    public function updateOne($fields) {
        if (array_key_exists('status', $fields)) {
            $stmt = $this->db->prepare("UPDATE assignments SET status = ? WHERE id = ?");
            $stmt->bind_param('ii', $fields['status'], $fields['id']);
            $stmt->execute();
        } else if (array_key_exists('details', $fields)) {
            $stmt = $this->db->prepare("UPDATE assignments SET details = ?, edited = 1 WHERE id = ?");
            $stmt->bind_param('si', $fields['details'], $fields['id']);
            $stmt->execute();
        }
    }
}