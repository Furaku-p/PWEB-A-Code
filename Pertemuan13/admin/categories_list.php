<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';

auth_require_login();

$msg = flash_get('ok');

$rows = $pdo->query("
    SELECT c.id, c.name, c.slug,
           (SELECT COUNT(*) FROM news n WHERE n.category_id = c.id) AS news_count
    FROM categories c
    ORDER BY c.name ASC
")->fetchAll();
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Categories</title>
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
                            <th>Name</th>
                            <th>Slug</th>
                            <th>News</th>
                            <th style="width: 160px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $r): ?>
                            <tr>
                                <td><?= e($r['name']) ?></td>
                                <td><?= e($r['slug']) ?></td>
                                <td><?= e((string)$r['news_count']) ?></td>
                                <td>
                                    <a class="btn btn-ghost" href="/admin/categories_form.php?id=<?= (int)$r['id'] ?>">Edit</a>
                                    <a class="link-danger" href="/admin/categories_delete.php?id=<?= (int)$r['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<a href="/admin/categories_form.php" class="fab" title="Add Category">+</a>

<footer class="footer">
    <div class="container">© <?= e(date('Y')) ?> NewsPortal</div>
</footer>
</body>
</html>
