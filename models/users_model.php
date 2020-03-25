<?php
require_once('models/base_model.php');

class users_model extends base_model {
    public function __construct() {
        parent::__construct();
    }

    public function auth($fields) {
        $stmt = $this->db->prepare("SELECT login FROM users WHERE login = ? AND password = ?");
        $stmt->bind_param('ss', $fields['login'], $fields['password']);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        return $row['login'];
    }
}