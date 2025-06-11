<?php
require_once __DIR__ . '/../config/database.php';

class Comment {
    /*načítá tabulku comments, roztřizuje ji podle bossId a zároveň propojuje user_id v comments s id v users, a řadí je sestupně podle doby vytvoření*/
    public static function getByBossId($bossId) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT comments.*, users.username FROM comments JOIN users ON comments.user_id = users.id WHERE boss_id = ? ORDER BY created_at DESC");
        $stmt->execute([$bossId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /*přidává nový komentář: id autora, id položky, které byl komentář vytvořen a samotný obsah*/
    public static function add($userId, $bossId, $content) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO comments (user_id, boss_id, content) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $bossId, $content]);
    }
    /*získá jeden komentář podle jeho id*/
    public static function getById($commentId) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM comments WHERE id = ?");
        $stmt->execute([$commentId]);
        return $stmt->fetch();
    }
    /*smaže jeden komentář podle jeho id*/
    public static function delete($commentId) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM comments WHERE id = ?");
        $stmt->execute([$commentId]);
    }
    
}