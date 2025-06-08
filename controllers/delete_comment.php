<?php
session_start();
require_once __DIR__ . '/../models/comments.php';
require_once __DIR__ . '/../config/constant.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_id'])) {
    $commentId = (int)$_POST['comment_id'];
    $bossId = intval($_POST['boss_id']);

    $stmt = $pdo->prepare("SELECT * FROM comments WHERE id = ?");
    $stmt->execute([$commentId]);
    $comment = $stmt->fetch();

    if (!$comment) {
        http_response_code(404);
        echo "Komentář nebyl nalezen.";
        exit;
    }

    if (
        isset($_SESSION['user_id']) &&
        ($_SESSION['role'] === 'admin' || $_SESSION['user_id'] == $comment['user_id'])
    ) {
        $stmt = $pdo->prepare("DELETE FROM comments WHERE id = ?");
        $stmt->execute([$commentId]);

        header("Location: ../views/lists/boss_list.php");
        exit;
    } else {
        http_response_code(403);
        echo "Nemáš oprávnění smazat tento komentář.";
        exit;
    }

} else {
    http_response_code(403);
    echo "Přístup odepřen.";
    exit;
}
