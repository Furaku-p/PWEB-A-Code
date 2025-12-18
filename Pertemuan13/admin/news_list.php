<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';

auth_require_login();

$page = max(1, require_int($_GET['page'] ?? 1, 1));
$perPage = 10;
$offset = ($page - 1) * $perPage;

$count = (int)$pdo->query("SELECT COUNT(*) AS c FROM news")->fetch()['c'];
$pages = max(1, (int)ceil($count / $perPage));

$stmt = $pdo->query("
    SELECT n.id, n.title, n.status, n.published_at, c.name AS category_name, u.fullname AS author
    FROM news n
    JOIN categories c ON c.id = n.category_id
    JOIN users u ON u.id = n.author_id
    ORDER BY n.created_at DESC
    LIMIT {$perPage} OFFSET {$offset}
");
$rows = $stmt->fetchAll();

$msg = flash_get('ok');
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>News</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<header class="navbar">
    <div class="container">
        <div class="row">
            <a class="brand" href="/admin/index.php">Admin<span>Panel</span></a>

            <div class="nav">
                <a href="/admin/news_list.php">News</a>
                <a href="/admin/categories_list.php">Categories</a>
                <?php if (auth_is_admin()): ?>
                    <a href="/admin/users_list.php">Users</a>
                <?php endif; ?>
            </div>

            <div class="nav-right">
                <a href="/admin/logout.php" class="btn btn-ghost nav-admin">Logout</a>
            </div>
        </div>
    </div>
</header>

<main class="main">
    <div class="container">
        <?php if ($msg): ?>
            <div class="alert alert-success"><?= e($msg) ?></div>
        <?php endif; ?>

        <div class="card" style="margin-top: 12px;">
            <div class="card-pad">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Published</th>
                            <th style="width: 160px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $r): ?>
                            <tr>
                                <td><?= e($r['title']) ?></td>
                                <td><?= e($r['category_name']) ?></td>
                                <td><?= e($r['author']) ?></td>
                                <td><?= e($r['status']) ?></td>
                                <td><?= $r['published_at'] ? e(date('d M Y H:i', strtotime((string)$r['published_at']))) : '-' ?></td>
                                <td>
                                    <a class="btn btn-ghost" href="/admin/news_form.php?id=<?= (int)$r['id'] ?>">Edit</a>
                                    <a class="link-danger" href="/admin/news_delete.php?id=<?= (int)$r['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="row" style="margin-top: 12px; justify-content: center;">
                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                        <a class="btn <?= $i === $page ? 'btn-primary' : 'btn-ghost' ?>" href="/admin/news_list.php?page=<?= $i ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<a href="/admin/news_form.php" class="fab" title="Add News">+</a>

<footer class="footer">
    <div class="container">© <?= e(date('Y')) ?> NewsPortal</div>
</footer>
</body>
</html>
