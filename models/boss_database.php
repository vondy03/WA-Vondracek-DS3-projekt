<?php
require_once __DIR__ . '/../config/database.php'; // připojení k DB

// Získání všech bossů
function getAllBosses(PDO $pdo): array {
    $stmt = $pdo->query("SELECT * FROM bosses ORDER BY id ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Získání jednoho bosse podle ID
function getBossById(PDO $pdo, int $id): ?array {
    $stmt = $pdo->prepare("SELECT * FROM bosses WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $boss = $stmt->fetch(PDO::FETCH_ASSOC);
    return $boss ?: null;
}

// Získání počtu hlasů pro daného bosse
function getVoteCount(PDO $pdo, int $boss_id): int {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM votes WHERE boss_id = :boss_id");
    $stmt->execute(['boss_id' => $boss_id]);
    return (int) $stmt->fetchColumn();
}
