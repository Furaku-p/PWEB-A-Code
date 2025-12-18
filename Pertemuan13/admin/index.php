<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';

auth_require_login();

$u = auth_user();

$stats = [
    'news' => (int)$pdo->query("SELECT COUNT(*) AS c FROM news")->fetch()['c'],
    'published' => (int)$pdo->query("SELECT COUNT(*) AS c FROM news WHERE status = 'published'")->fetch()['c'],
    'categories' => (int)$pdo->query("SELECT COUNT(*) AS c FROM categories")->fetch()['c'],
    'users' => (int)$pdo->query("SELECT COUNT(*) AS c FROM users")->fetch()['c'],
];
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<header class="navbar">
    <div class="container">
        <div class="row" style="padding: 14px 0;">
            <a class="brand" href="/admin/index.php">Admin<span>Panel</span></a>
            <div class="nav">
                <a href="/admin/news_list.php">News</a>
                <a href="/admin/categories_list.php">Categories</a>
                <?php if (auth_is_admin()): ?>
                    <a href="/admin/users_list.php">Users</a>
                <?php endif; ?>
            </div>
            <div class="nav">
                <a href="/" class="btn btn-ghost">View</a>
                <a href="/admin/logout.php" class="btn btn-primary">Logout</a>
            </div>
        </div>
    </div>
</header>

<main class="main">
    <div class="container">
        <div class="hero">
            <div class="kicker">Dashboard</div>
            <h1 class="title">Hi, <?= e((string)$u['fullname']) ?></h1>
            <p class="muted" style="margin: 6px 0 0;">Role: <?= e((string)$u['role']) ?></p>
        </div>

        <div class="news-grid" style="margin-top: 16px;">
            <div class="card"><div class="card-pad"><div class="kicker">News</div><div class="title" style="font-size: 26px;"><?= e((string)$stats['news']) ?></div></div></div>
            <div class="card"><div class="card-pad"><div class="kicker">Published</div><div class="title" style="font-size: 26px;"><?= e((string)$stats['published']) ?></div></div></div>
            <div class="card"><div class="card-pad"><div class="kicker">Categories</div><div class="title" style="font-size: 26px;"><?= e((string)$stats['categories']) ?></div></div></div>
        </div>
    </div>
</main>

<footer class="footer">
    <div class="container">© <?= e(date('Y')) ?> NewsPortal</div>
</footer>
</body>
</html>
