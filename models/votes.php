<?php
// models/votes.php
require_once __DIR__ . '/../config/database.php';

class Vote {
    public static function hasUserVoted($userId, $bossId) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT id FROM votes WHERE user_id = ? AND boss_id = ?");
        $stmt->execute([$userId, $bossId]);
        return $stmt->fetch() !== false;
    }

    public static function recordVote($userId, $bossId) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO votes (user_id, boss_id) VALUES (?, ?)");
        $stmt->execute([$userId, $bossId]);
    }
}