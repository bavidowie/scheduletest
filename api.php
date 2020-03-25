<?php
require_once('controllers/assignments_controller.php');
require_once('controllers/users_controller.php');



$assignments = new assignments_controller();
$users_controller = new users_controller();

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $datatable_response = new stdClass();
    $datatable_response->data = $assignments->getAll();
    echo json_encode($datatable_response);
} else if ($method === 'POST') {
    $content = trim(file_get_contents("php://input"));
    $decoded = json_decode($content, true);
    $action = $decoded['action'];
    $fields = [];
    if ($action === 'add') {
        $fields['username'] = $decoded['username'];
        $fields['email'] = $decoded['email'];
        $fields['details'] = $decoded['details'];
        if ($assignments->insertOne($fields)) {
            echo json_encode(['message' => 'Задача успешно добавлена']);
        }
    } else if ($action === 'status') {
        if ($users_controller->isAuthorised()) {
            $fields['id'] = $decoded['assignment_id'];
            $fields['status'] = $decoded['status'];
            $assignments->updateOne($fields);
        }
    } else if ($action === 'details') {
        if ($users_controller->isAuthorised()) {
            $fields['id'] = $decoded['id'];
            $fields['details'] = $decoded['details'];
            $assignments->updateOne($fields);
            echo json_encode(['message' => 'Задача успешно обновлена' . $users_controller->isAuthorised()]);
        } else {
            echo json_encode(['message' => 'Нужно авторизироваться', 'error' => '1']);
        }
    }
}