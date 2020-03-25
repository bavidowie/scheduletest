<?php
require_once('controllers/base_controller.php');
require_once('models/assignments_model.php');

class assignments_controller extends base_controller {

    public function __construct() {
        parent::__construct();
        $this->model = new assignments_model();
    }

    public function getAll() {
        return $this->model->getAll();
    }
    public function insertOne($fields) {
        return $this->model->insertOne($fields);
    }
    public function updateOne($fields) {
        return $this->model->updateOne($fields);
    }
}