<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';

auth_require_login();

$id = require_int($_GET['id'] ?? 0, 0);

$row = null;
if ($id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ? LIMIT 1");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if (!$row) {
        redirect('/admin/categories_list.php');
    }
}

function v(array $a, string $k, string $d = ''): string
{
    return isset($a[$k]) ? (string)$a[$k] : $d;
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $row ? 'Edit' : 'Add' ?> Category</title>
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
            </div>
            <div class="nav">
                <a href="/admin/categories_list.php" class="btn btn-ghost">Back</a>
                <a href="/admin/logout.php" class="btn btn-primary">Logout</a>
            </div>
        </div>
    </div>
</header>

<main class="main">
    <div class="container" style="max-width: 720px;">
        <div class="card">
            <div class="card-pad">
                <div class="kicker"><?= $row ? 'Edit' : 'Add' ?></div>
                <h1 class="title" style="margin-top: 10px;">Category</h1>

                <form class="form" method="post" action="/admin/categories_save.php">
                    <input type="hidden" name="id" value="<?= $id ?>">

                    <div class="field">
                        <label>Name</label>
                        <input id="cname" name="name" required value="<?= e(v($row ?? [], 'name')) ?>">
                    </div>

                    <div class="field">
                        <label>Slug</label>
                        <input name="slug" data-auto-slug="#cname" required value="<?= e(v($row ?? [], 'slug')) ?>">
                    </div>

                    <div class="field">
                        <label>Description</label>
                        <textarea name="description"><?= e(v($row ?? [], 'description')) ?></textarea>
                    </div>

                    <button class="btn btn-primary" type="submit">Save</button>
                </form>
            </div>
        </div>
    </div>
</main>

<footer class="footer">
    <div class="container">© <?= e(date('Y')) ?> NewsPortal</div>
</footer>

<script src="/assets/js/app.js"></script>
</body>
</html>
