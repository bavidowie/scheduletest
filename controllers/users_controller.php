<?php
require_once('controllers/base_controller.php');
require_once('models/users_model.php');

class users_controller extends base_controller {

    public function __construct() {
        parent::__construct();
        $this->model = new users_model();
        session_start();
    }

    public function auth($fields) {
        $login_res = $this->model->auth($fields);
        $_SESSION['username'] = $login_res;
        return $login_res;
    }

    public function isAuthorised() {
        if (isset($_SESSION['username'])) {
            return $_SESSION['username'];
        } else {
            return false;
        }
    }
}