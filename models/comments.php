<?php
// models/comments.php
require_once __DIR__ . '/../config/database.php';

class Comment {
    public static function getByBossId($bossId) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT comments.*, users.username FROM comments JOIN users ON comments.user_id = users.id WHERE boss_id = ? ORDER BY created_at DESC");
        $stmt->execute([$bossId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function add($userId, $bossId, $content) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO comments (user_id, boss_id, content) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $bossId, $content]);
    }

    public static function getById($commentId) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM comments WHERE id = ?");
        $stmt->execute([$commentId]);
        return $stmt->fetch();
    }
    
    public static function delete($commentId) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM comments WHERE id = ?");
        $stmt->execute([$commentId]);
    }
    
}