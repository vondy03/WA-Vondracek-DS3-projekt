<?php
require_once __DIR__ . '/../config/database.php';

class User {
    /*vyhledá uživatele podle id*/
    public static function getById($id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /*vyhledá uživatele podle jeho username*/
    public static function getByUsername($username) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /*vytvoří novou položku v tabulce users*/
    public static function create($username, $passwordHash, $email = null) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO users (username, password_hash, email) VALUES (?, ?, ?)");
        $stmt->execute([$username, $passwordHash, $email]);
    }
}