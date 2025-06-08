<?php
require_once __DIR__ . '/../../includes/navbar.php';
require_once __DIR__ . '/../../controllers/login.php';
require_once __DIR__ . '/../../includes/header.php';
?>
<head><title>Přihlášení</title></head>
<link rel="stylesheet" href="/WA-Vondracek-DS3-projekt/public/assets/style.css">
<body>
    <main style="display: flex; min-height: 50vh; padding: 2rem; justify-content: center;">
    <div style="background-color: rgba(0, 0, 0, 0.7); padding: 2rem; border-radius: 10px; max-width: 1200px; text-align: center; box-shadow: 0 0 10px rgba(0, 0, 0, 0.8);">
        <h2 style="color: rgb(255, 94, 19); font-family: 'Cinzel', serif; font-size: 2.2rem; margin-bottom: 1rem;">Přihlášení</h2>
        
        <?php if (!empty($errors)): ?>
            <ul class="error-list">
                <?php foreach ($errors as $error): ?>
                    <li style="font-family: 'IM Fell English', serif; color: crimson;"><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="username" style="display: block; text-align: left; margin: 1rem 0 0.3rem; font-family: 'IM Fell English', serif; font-size: 1.1rem;">Uživatelské jméno</label>
            <input type="text" id="username" name="username" required style="width: 100%; padding: 0.7rem; font-size: 1rem; border: none; border-radius: 5px; margin-bottom: 1rem; background-color: #fdfdfd; color: #000;">

            <label for="password" style="display: block; text-align: left; margin: 1rem 0 0.3rem; font-family: 'IM Fell English', serif; font-size: 1.1rem;">Heslo</label>
            <input type="password" id="password" name="password" required style="width: 100%; padding: 0.7rem; font-size: 1rem; border: none; border-radius: 5px; margin-bottom: 1rem; background-color: #fdfdfd; color: #000;">

            <button type="submit" style="width: 100%; padding: 0.8rem; background-color: rgb(255, 94, 19); border: none; border-radius: 5px; font-size: 1.2rem; font-family: 'Cinzel', serif; color: #fff; cursor: pointer; transition: background-color 0.3s ease;" >Přihlásit se</button>
        </form>
    </div>
    </main>
</body>