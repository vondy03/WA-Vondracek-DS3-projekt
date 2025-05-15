<?php
require_once __DIR__ . '/../models/boss_database.php';

// Zobraz seznam bossů
function showBossList(PDO $pdo) {
    $bosses = getAllBosses($pdo);
    require __DIR__ . '/../views/boss_list.php'; // view pro výpis seznamu
}

// Zobraz detail bosse
function showBossDetail(PDO $pdo, int $id) {
    $boss = getBossById($pdo, $id);
    $votes = getVoteCount($pdo, $id);

    if (!$boss) {
        echo "Boss nenalezen.";
        return;
    }

    require __DIR__ . '/../views/bosses/boss_detail.php'; // detail view
}
