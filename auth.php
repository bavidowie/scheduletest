<?php
require_once('controllers/users_controller.php');

$users_controller = new users_controller();
session_start();

$content = trim(file_get_contents("php://input"));
$decoded = json_decode($content, true);
$action = $decoded['action'];

if ($action === 'login') {
    $fields = [];
    $fields['login'] = $decoded['login'];
    $fields['password'] = $decoded['password'];
    $login_result = $users_controller->auth($fields);
    if ($login_result !== null) {
        $_SESSION['username'] = $login_result;
    }
    echo json_encode(['logged_in' => $login_result]);
} else if ($action === 'logout') {
    session_destroy();
}