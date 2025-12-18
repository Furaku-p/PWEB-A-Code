<?php
declare(strict_types=1);

require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/config/helpers.php';

$slug = (string)($_GET['slug'] ?? '');
if ($slug === '') {
    redirect('/');
}

$stmt = $pdo->prepare("SELECT id, name, slug, description FROM categories WHERE slug = ? LIMIT 1");
$stmt->execute([$slug]);
$cat = $stmt->fetch();
if (!$cat) {
    http_response_code(404);
    echo 'Not found';
    exit;
}

$page = max(1, require_int($_GET['page'] ?? 1, 1));
$perPage = 9;
$offset = ($page - 1) * $perPage;

$countStmt = $pdo->prepare("SELECT COUNT(*) AS c FROM news WHERE status = 'published' AND category_id = ?");
$countStmt->execute([(int)$cat['id']]);
$total = (int)($countStmt->fetch()['c'] ?? 0);
$pages = max(1, (int)ceil($total / $perPage));

$listStmt = $pdo->prepare("
    SELECT n.id, n.title, n.slug, n.image, n.published_at, u.fullname AS author
    FROM news n
    JOIN users u ON u.id = n.author_id
    WHERE n.status = 'published' AND n.category_id = ?
    ORDER BY n.published_at DESC
    LIMIT {$perPage} OFFSET {$offset}
");
$listStmt->execute([(int)$cat['id']]);
$items = $listStmt->fetchAll();

$cats = $pdo->query("SELECT name, slug FROM categories ORDER BY name ASC")->fetchAll();
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($cat['name']) ?> - NewsPortal</title>
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
    <div class="container">
        <div class="hero">
            <div class="kicker">Kategori</div>
            <h1 class="title"><?= e($cat['name']) ?></h1>
            <?php if (!empty($cat['description'])): ?>
                <p class="muted" style="margin: 6px 0 0;"><?= e($cat['description']) ?></p>
            <?php endif; ?>
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
                <a class="btn <?= $i === $page ? 'btn-primary' : 'btn-ghost' ?>" href="/category.php?slug=<?= e($cat['slug']) ?>&page=<?= $i ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    </div>
</main>

<footer class="footer">
    <div class="container">© <?= e(date('Y')) ?> NewsPortal</div>
</footer>
</body>
</html>
