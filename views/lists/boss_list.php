<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Dark Souls 3 Bossové</title>
    <link rel="stylesheet" href="public/style.css"> <!-- cesta k tvému CSS -->
    <style>
        body {
            font-family: sans-serif;
            background-color: #1e1e1e;
            color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 40px;
        }

        .boss-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .boss-card {
            background-color: #2e2e2e;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
        }

        .boss-card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .boss-card a {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #cc9933;
            color: #000;
            text-decoration: none;
            border-radius: 5px;
        }

        .boss-card a:hover {
            background-color: #ffcc00;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bossové ze hry Dark Souls III</h1>

        <div class="boss-grid">
            <?php foreach ($bosses as $boss): ?>
                <div class="boss-card">
                    <?php if (!empty($boss['image'])): ?>
                        <img src="public/images/<?php echo htmlspecialchars($boss['image']); ?>" alt="<?php echo htmlspecialchars($boss['name']); ?>">
                    <?php endif; ?>

                    <h2><?php echo htmlspecialchars($boss['name']); ?></h2>
                    <p><?php echo mb_strimwidth(strip_tags($boss['description']), 0, 100, '...'); ?></p>
                    <a href="index.php?id=<?php echo $boss['id']; ?>">Detail</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
