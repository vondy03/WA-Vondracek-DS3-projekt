<?php
require_once __DIR__ . '/../config/database.php';

class Boss {
    public static function getAll() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM bosses");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM bosses WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getByName($name) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM bosses WHERE name = ?");
        $stmt->execute([$name]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public static function incrementVote($bossId) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE bosses SET vote_count = vote_count + 1 WHERE id = ?");
        $stmt->execute([$bossId]);
    }

    public static function getTopVoted($limit = 18) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM bosses ORDER BY vote_count DESC LIMIT ?");
        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
