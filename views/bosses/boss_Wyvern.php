<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /WA-Vondracek-DS3-projekt/views/authentication/login.php');
    exit;
}
require_once __DIR__ . '/../../models/bosses.php';
require_once __DIR__ . '/../../models/votes.php';
require_once __DIR__ . '/../../models/comments.php';
require_once __DIR__ . '/../../includes/navbar.php';

$bossName = 'Wyvern'; // ← změň podle jména bosse
$boss = Boss::getByName($bossName);
$bossId = $boss['id'];

// Získání komentářů
$comments = Comment::getByBossId($bossId);

// Kontrola, zda uživatel hlasoval
$hasVoted = false;
if (isset($_SESSION['user_id'])) {
    $hasVoted = Vote::hasUserVoted($_SESSION['user_id'], $bossId);
}

// Hlasování
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['vote'])) {
    if (!$hasVoted) {
        Vote::recordVote($_SESSION['user_id'], $bossId);
        Boss::incrementVote($bossId); // ← aktualizace počtu hlasů v tabulce bosses
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Přidání komentáře
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    if (isset($_SESSION['user_id']) && !empty(trim($_POST['content']))) {
        Comment::add($_SESSION['user_id'], $bossId, trim($_POST['content']));
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
}
?>

<html>
    <title><?= htmlspecialchars($boss['name']) ?></title>
    <link rel="stylesheet" href="/WA-Vondracek-DS3-projekt/public/assets/style.css">
<body class="backdrop-body">
<main class="main-wrapper">
    <div class="content-box">
    <h2>Ancient Wyvern</h2>

    <h3>Lokace: Archdragon Peak</h3>
    <div>
        <p>Ancient Wyvern je posledním žijícím drakem z dávných časů. Archdragon Peak byl kdysi domovem mnoha mocných draků, kteří určovali osud světa, avšak lidé později draky svhli a většina z nich vymřela. Ancient Wyvern je tedy posledním z draků a také ztrážcem Archdragon Peaku.</p>
        <p>Ancient Wyvern je jedním z mála "puzzle" bossů, při kterém hráč musí draka oběhnout, dostat se na hradby a z nich poté seskočit na draka. Pokud se to hráči povede, tak provede devastující útok, který draka instantně skolí.</p>
    </div>

    <div class="vote-section">
        <p>Počet hlasů: <strong><?= $boss['vote_count'] ?></strong></p>

        <?php if (isset($_SESSION['user_id'])): ?>
            <?php if (!$hasVoted): ?>
                <form method="POST">
                    <button type="submit" name="vote">Hlasuj</button>
                </form>
            <?php else: ?>
                <p class="info-text"><strong>Už jsi hlasoval.</strong></p>
            <?php endif; ?>
        <?php else: ?>
            <p><a href="../authentication/login.php">Přihlas se</a>, abys mohl hlasovat.</p>
        <?php endif; ?>
    </div>

    <section class="comment-section">
        <h3>Komentáře</h3>

        <?php if (count($comments) === 0): ?>
            <p class="info-text">Zatím žádné komentáře.</p>
        <?php endif; ?>

        <?php foreach ($comments as $comment): ?>
            <div class="comment">

                <strong><?= htmlspecialchars($comment['username']) ?></strong>

                <time datetime="<?= htmlspecialchars($comment['created_at']) ?>">
                    (<?= date('d.m.Y H:i', strtotime($comment['created_at'])) ?>)
                </time>

                <p><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
                <?php if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == $comment['user_id'] || ($_SESSION['role'] ?? '') === 'admin')): ?>
                    <form method="POST" action="../../controllers/delete_comment.php" onsubmit="return confirm('Opravdu chceš smazat tento komentář?');" style="display:inline;">
                    <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
                    <input type="hidden" name="boss_id" value="<?= $boss['id'] ?>">
                    <button type="submit" class="delete-button">Smazat</button>
                </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <?php if (isset($_SESSION['user_id'])): ?>
            <form method="POST">
                <textarea name="content" rows="4" placeholder="Tvůj komentář..." required></textarea><br>
                <button type="submit" name="comment">Přidat komentář</button>
            </form>
        <?php else: ?>
            <p><a href="../authentication/login.php">Přihlas se</a>, abys mohl komentovat.</p>
        <?php endif; ?>
    </section>
    </div>
    </main>
</body>
</html>

