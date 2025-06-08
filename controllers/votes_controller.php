<?php
session_start();
require_once __DIR__ . '/../models/votes.php';
require_once __DIR__ . '/../models/bosses.php';
require_once __DIR__ . '/../config/constant.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['boss_id'])) {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../views/authentication/login.php');
        exit;
    }

    $bossId = intval($_POST['boss_id']);
    $userId = $_SESSION['user_id'];

    if (!Vote::hasUserVoted($userId, $bossId)) {
        Vote::recordVote($userId, $bossId);
        Boss::incrementVote($bossId);
    }

    header("Location: ../views/bosses/boss_$bossId.php");
    exit;
}
