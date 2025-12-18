<?php
declare(strict_types=1);

require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/config/helpers.php';

$q = trim((string)($_GET['q'] ?? ''));
$page = max(1, require_int($_GET['page'] ?? 1, 1));
$perPage = 9;
$offset = ($page - 1) * $perPage;

$cats = $pdo->query("SELECT name, slug FROM categories ORDER BY name ASC")->fetchAll();

$where = "n.status = 'published'";
$params = [];

if ($q !== '') {
    $where .= " AND (n.title LIKE ? OR n.content LIKE ?)";
    $params[] = "%{$q}%";
    $params[] = "%{$q}%";
}

$countStmt = $pdo->prepare("
    SELECT COUNT(*) AS c
    FROM news n
    WHERE {$where}
");
$countStmt->execute($params);
$total = (int)($countStmt->fetch()['c'] ?? 0);
$pages = max(1, (int)ceil($total / $perPage));

$listStmt = $pdo->prepare("
    SELECT n.title, n.slug, n.image, n.published_at, c.name AS category_name, c.slug AS category_slug, u.fullname AS author
    FROM news n
    JOIN categories c ON c.id = n.category_id
    JOIN users u ON u.id = n.author_id
    WHERE {$where}
    ORDER BY n.published_at DESC
    LIMIT {$perPage} OFFSET {$offset}
");
$listStmt->execute($params);
$items = $listStmt->fetchAll();
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cari: <?= e($q) ?> - NewsPortal</title>
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
    <div class="container">
        <div class="hero">
            <div class="kicker">Pencarian</div>
            <h1 class="title"><?= $q === '' ? 'Semua Berita' : 'Hasil: ' . e($q) ?></h1>
            <p class="muted" style="margin: 6px 0 0;"><?= e((string)$total) ?> item</p>
        </div>

        <section class="news-grid" style="margin-top: 16px;">
            <?php foreach ($items as $n): ?>
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
                            <?= e(date('d M Y, H:i', strtotime((string)$n['published_at']))) ?> • <?= e($n['author']) ?>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>

        <div class="row" style="margin-top: 16px; justify-content: center;">
            <?php for ($i = 1; $i <= $pages; $i++): ?>
                <a class="btn <?= $i === $page ? 'btn-primary' : 'btn-ghost' ?>" href="/search.php?q=<?= urlencode($q) ?>&page=<?= $i ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    </div>
</main>

<footer class="footer">
    <div class="container">© <?= e(date('Y')) ?> NewsPortal</div>
</footer>
</body>
</html>
