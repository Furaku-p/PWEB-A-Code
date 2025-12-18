<?php
declare(strict_types=1);

require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/config/helpers.php';

$cats = $pdo->query("SELECT id, name, slug FROM categories ORDER BY name ASC")->fetchAll();

$headline = $pdo->query("
    SELECT n.id, n.title, n.slug, n.image, n.published_at, c.name AS category_name, c.slug AS category_slug, u.fullname AS author
    FROM news n
    JOIN categories c ON c.id = n.category_id
    JOIN users u ON u.id = n.author_id
    WHERE n.status = 'published'
    ORDER BY n.published_at DESC
    LIMIT 1
")->fetch();

$latest = $pdo->query("
    SELECT n.id, n.title, n.slug, n.image, n.published_at, c.name AS category_name, c.slug AS category_slug, u.fullname AS author
    FROM news n
    JOIN categories c ON c.id = n.category_id
    JOIN users u ON u.id = n.author_id
    WHERE n.status = 'published'
    ORDER BY n.published_at DESC
    LIMIT 9
")->fetchAll();
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NewsPortal</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<header class="navbar">
    <div class="container">
        <div class="row" style="padding: 14px 0;">
            <a class="brand" href="/">News<span>Portal</span></a>
            <div class="nav">
                <?php foreach ($cats as $c): ?>
                    <a href="/category.php?slug=<?= e($c['slug']) ?>"><?= e($c['name']) ?></a>
                <?php endforeach; ?>
            </div>
            <div class="nav-right">
                <form class="searchbar" method="get" action="/search.php">
                    <input class="input" type="search" name="q" placeholder="Cari berita..." required>
                    <button class="btn btn-primary" type="submit">Cari</button>
                </form>

                <a href="/admin/login.php" class="btn btn-ghost nav-admin">Admin</a>
            </div>
        </div>
    </div>
</header>

<main class="main">
    <div class="container grid grid-2">
        <section class="hero">
            <?php if ($headline): ?>
                <div class="kicker">Headline</div>
                <h2 class="title"><?= e($headline['title']) ?></h2>
                <p class="muted">
                    <?= e(date('d M Y, H:i', strtotime((string) $headline['published_at']))) ?>
                    • <?= e($headline['author']) ?>
                    • <a href="/category.php?slug=<?= e($headline['category_slug']) ?>" class="badge" style="margin-left: 8px;"><?= e($headline['category_name']) ?></a>
                </p>
                <div class="card" style="margin-top: 14px;">
                    <?php if (!empty($headline['image'])): ?>
                        <img class="thumb" src="/uploads/<?= e($headline['image']) ?>" alt="">
                    <?php else: ?>
                        <div class="thumb"></div>
                    <?php endif; ?>
                    <div class="card-pad">
                        <a class="btn btn-primary" href="/news.php?slug=<?= e($headline['slug']) ?>">Baca</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="kicker">Belum ada berita</div>
                <h2 class="title">Publish berita pertama dari dashboard</h2>
                <p class="muted">Masuk: /admin/login.php</p>
            <?php endif; ?>
        </section>

        <aside class="card">
            <div class="card-pad">
                <div class="kicker">Kategori</div>
                <div style="display: grid; gap: 10px; margin-top: 12px;">
                    <?php foreach ($cats as $c): ?>
                        <a class="row" href="/category.php?slug=<?= e($c['slug']) ?>">
                            <span style="font-weight: 900;"><?= e($c['name']) ?></span>
                            <span class="muted">→</span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </aside>
    </div>

    <div class="container" style="margin-top: 18px;">
        <div class="row" style="margin-bottom: 10px;">
            <h3 class="title" style="font-size: 18px; margin: 0;">Terbaru</h3>
            <a class="btn btn-ghost" href="/search.php?q=">Lihat semua</a>
        </div>

        <section class="news-grid">
            <?php foreach ($latest as $n): ?>
                <article class="card">
                    <?php if (!empty($n['image'])): ?>
                        <img class="thumb" src="/uploads/<?= e($n['image']) ?>" alt="">
                    <?php else: ?>
                        <div class="thumb"></div>
                    <?php endif; ?>
                    <div class="card-pad">
                        <a class="badge" href="/category.php?slug=<?= e($n['category_slug']) ?>"><?= e($n['category_name']) ?></a>
                        <div class="h3"><a href="/news.php?slug=<?= e($n['slug']) ?>"><?= e($n['title']) ?></a></div>
                        <div class="muted" style="font-size: 13px;">
                            <?= e(date('d M Y, H:i', strtotime((string) $n['published_at']))) ?> • <?= e($n['author']) ?>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
    </div>
</main>

<footer class="footer">
    <div class="container">© <?= e(date('Y')) ?> NewsPortal</div>
</footer>

<script src="/assets/js/app.js"></script>
</body>
</html>
