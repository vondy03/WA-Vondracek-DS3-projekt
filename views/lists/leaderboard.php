<?php
session_start();
require_once __DIR__ . '/../../includes/navbar.php';
require_once __DIR__ . '/../../includes/header.php';
require_once __DIR__ . '/../../models/bosses.php';
$topBosses = Boss::getTopVoted();
?>
<head><title>Tabulka</title></head>
<link rel="stylesheet" href="/WA-Vondracek-DS3-projekt/public/assets/style.css">
<body class="backdrop-body">
<main class="main-wrapper">
    <div class="content-box">
    <h1>Nejtěžší Bossové</h1>
    <table>
        <thead>
            <tr>
                <th>Pořadí</th>
                <th>Jméno</th>
                <th>Počet hlasů</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($topBosses as $index => $boss): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($boss['name']) ?></td>
                    <td><?= $boss['vote_count'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</main>
</body>
</html>
