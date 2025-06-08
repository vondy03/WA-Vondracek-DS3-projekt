<?php
session_start();
require_once __DIR__ . '/../models/comments.php';
require_once __DIR__ . '/../config/constant.php';
/**/
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'], $_GET['boss_id'])) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../views/authentication/login.php');
        exit;
    }

    $commentId = intval($_GET['id']);
    $bossId = intval($_GET['boss_id']);
    $userId = $_SESSION['user_id'];
    $userRole = $_SESSION['role'] ?? 'user';

    $comment = Comment::getById($commentId);

    if ($comment && ($userRole === 'admin' || $comment['user_id'] == $userId)) {
        Comment::delete($commentId);
    }

    header("Location: ../views/bosses/boss_$bossId.php");
    exit;
}
