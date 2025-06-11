<?php
session_start();
require_once __DIR__ . '/../models/comments.php';
require_once __DIR__ . '/../config/constant.php';
/*kontrola přihlášení a dalších věcí*/
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'], $_GET['boss_id'])) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../views/authentication/login.php');
        exit;
    }
    /*načítání potřebných dat*/
    $commentId = intval($_GET['id']);
    $bossId = intval($_GET['boss_id']);
    $userId = $_SESSION['user_id'];
    $userRole = $_SESSION['role'] ?? 'user';

    $comment = Comment::getById($commentId);
    /*oprávnění uživatele*/
    if ($comment && ($userRole === 'admin' || $comment['user_id'] == $userId)) {
        Comment::delete($commentId);
    }

    header("Location: ../views/bosses/boss_$bossId.php");
    exit;
}
