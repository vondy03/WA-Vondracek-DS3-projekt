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

$bossName = 'Vordt'; // ← změň podle jména bosse
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
    <h2>Vordt of the Boreal Valley</h2>

    <h3>Lokace: High Wall of Lothric</h3>
    <div>
        <p>Vordt byl kdysi jedním z rytířů Boreal Valley. Když byla oblast zasažena prokletím nemrtvých a temnotou Abyssu, Vordt a jeho druhové padli pod její vliv. Vordt sám byl zkažen a stal se bestií táhnoucí ledem a šílenstvím. Ve svém znetvořeném stavu zůstává strážcem cesty do Undead Settlement, kterého nelze obejít bez souboje.</p>
        <p>Fáze 1: Vordt útočí ledovými údery a svou obrovskou sekerou. Jeho pohyby jsou pomalé, ale silné – zahrnují horizontální seky a dvojité skokové údery. Občas se zastaví, aby seslal ledový výbuch pod hráče (AoE zóna ledu).

</p>
        <p>Fáze 2: Jakmile přijde o přibližně 60 % zdraví, jeho tělo se pokryje ledovým pláštěm a reaguje rychleji na poškození. Útoky získají větší dosah a ledová magie se objevuje častěji. V této fázi je třeba pokračovat v agresivním útočném stylu, vyhýbat se širokým švihům a bleskově reagovat na náhlé ledové výbuchy.</p>
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

