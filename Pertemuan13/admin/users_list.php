<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';

auth_require_login();
if (!auth_is_admin()) {
    redirect('/admin/index.php');
}

$msg = flash_get('ok');

$rows = $pdo->query("SELECT id, username, fullname, role, created_at FROM users ORDER BY created_at DESC")->fetchAll();
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Users</title>
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
                <a href="/admin/users_list.php">Users</a>
            </div>
            <div class="nav">
                <a href="/admin/users_form.php" class="btn btn-primary">Add</a>
                <a href="/admin/logout.php" class="btn btn-ghost">Logout</a>
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
                            <th>Username</th>
                            <th>Fullname</th>
                            <th>Role</th>
                            <th>Created</th>
                            <th style="width: 160px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $r): ?>
                            <tr>
                                <td><?= e($r['username']) ?></td>
                                <td><?= e($r['fullname']) ?></td>
                                <td><?= e($r['role']) ?></td>
                                <td><?= e(date('d M Y H:i', strtotime((string)$r['created_at']))) ?></td>
                                <td>
                                    <a class="btn btn-ghost" href="/admin/users_form.php?id=<?= (int)$r['id'] ?>">Edit</a>
                                    <a class="link-danger" href="/admin/users_delete.php?id=<?= (int)$r['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<footer class="footer">
    <div class="container">© <?= e(date('Y')) ?> NewsPortal</div>
</footer>
</body>
</html>
