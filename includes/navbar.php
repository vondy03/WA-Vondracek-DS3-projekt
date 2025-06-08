<link rel="stylesheet" href="/WA-Vondracek-DS3-projekt/public/assets/style.css">
<nav style="background-color: #222; padding: 10px 20px;">
    <ul style="list-style: none; display: flex; margin: 0; padding: 0;">
        <li style="margin-right: 20px;">
            <a href="../lists/index.php">Domů</a>
        </li>
        <li style="margin-right: 20px;">
            <a href="../lists/boss_list.php">Seznam bossů</a>
        </li>
        <li style="margin-right: 20px;">
            <a href="../lists/leaderboard.php">Žebříček</a>
        </li>
        <li class="spacer"></li>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li style="margin-right: 20px;">
                <a href="../../controllers/logout.php">Odhlásit se</a>
            </li>
            <li style="color: #aaa;">
                Přihlášen jako: <?php echo htmlspecialchars($_SESSION['username']); ?>
            </li>
        <?php else: ?>
            <li style="margin-right: 20px;">
                <a href="../authentication/login.php">Přihlášení</a>
            </li>
            <li>
                <a href="../authentication/register.php">Registrace</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>