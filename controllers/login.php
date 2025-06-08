<?php
session_start();
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../config/constant.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $user = User::getByUsername($username);

    if (!$user || !password_verify($password, $user['password_hash'])) {
        $errors[] = 'Neplatné uživatelské jméno nebo heslo.';
    } else {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location: " . BASE_URL . "views/lists/index.php");
        exit;
    }
}