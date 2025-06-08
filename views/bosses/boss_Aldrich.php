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

$bossName = 'Aldrich'; 
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
        Boss::incrementVote($bossId);
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
    <h2>Aldrich, Devourer of Gods</h2>

    
    <h3>Lokace: Anor Londo</h3>
    <div>
        <p>Aldrich byl kdysi obyčejný člověk, jenž se stal neukojitelným požíračem lidí. Při jeho přeměně v Lorda of Cinder byl „uctíván“ a obětován kvůli své moci. Po smrti se vrátil znovu k životu jako zkažená bytost, která nejenže požírala těla, ale i sny a duše. Jeho pozdější oběť – Gwyndolin, poslední potomek Gwynova rodu – se stala součástí jeho těla, čímž Aldrich získal moc nad jeho kouzly i tělem. Tato zvrácená symbióza se odráží i v samotném boss fightu.</p>
        <p>Fáze 1: Boj začíná střelbou Soul Arrows, ohnivými koulemi a masivním mečem z magie. Aldrich se pomalu pohybuje, teleportuje se po aréně a jeho hlavní silou je velký rozsah útoků a AoE.</p>
        <p>Fáze 2: Když Aldrich přijde asi o polovinu životů, začne používat černé magické šípy ve stylu soul rain, který trvá několik vteřin a nutí hráče se neustále hýbat. V této fázi se zvyšuje agresivita, přidává více teleportací a jeho útoky působí větší magické i fyzické poškození. Mimo to zůstává aréna statická, což klade důraz na rychlé uhýbání.</p>
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

