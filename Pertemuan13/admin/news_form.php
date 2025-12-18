<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';

auth_require_login();

$id = require_int($_GET['id'] ?? 0, 0);

$cats = $pdo->query("SELECT id, name FROM categories ORDER BY name ASC")->fetchAll();

$news = null;
if ($id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM news WHERE id = ? LIMIT 1");
    $stmt->execute([$id]);
    $news = $stmt->fetch();
    if (!$news) {
        redirect('/admin/news_list.php');
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
    <title><?= $news ? 'Edit' : 'Add' ?> News</title>
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
                <a href="/admin/news_list.php" class="btn btn-ghost">Back</a>
                <a href="/admin/logout.php" class="btn btn-primary">Logout</a>
            </div>
        </div>
    </div>
</header>

<main class="main">
    <div class="container" style="max-width: 860px;">
        <div class="card">
            <div class="card-pad">
                <div class="kicker"><?= $news ? 'Edit' : 'Add' ?></div>
                <h1 class="title" style="margin-top: 10px;">News</h1>

                <form class="form" method="post" action="/admin/news_save.php" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $id ?>">

                    <div class="field">
                        <label>Title</label>
                        <input id="title" name="title" required value="<?= e(v($news ?? [], 'title')) ?>">
                    </div>

                    <div class="field">
                        <label>Slug</label>
                        <input name="slug" data-auto-slug="#title" value="<?= e(v($news ?? [], 'slug')) ?>" placeholder="auto" required>
                    </div>

                    <div class="field">
                        <label>Category</label>
                        <select name="category_id" required>
                            <?php foreach ($cats as $c): ?>
                                <option value="<?= (int)$c['id'] ?>" <?= $news && (int)$news['category_id'] === (int)$c['id'] ? 'selected' : '' ?>>
                                    <?= e($c['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="field">
                        <label>Status</label>
                        <select name="status" required>
                            <option value="draft" <?= !$news || v($news, 'status') === 'draft' ? 'selected' : '' ?>>draft</option>
                            <option value="published" <?= $news && v($news, 'status') === 'published' ? 'selected' : '' ?>>published</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Content</label>
                        <textarea name="content" required><?= e(v($news ?? [], 'content')) ?></textarea>
                    </div>

                    <div class="field">
                        <label>Featured Image (jpg/png/webp, max 2MB)</label>
                        <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp">
                        <?php if ($news && !empty($news['image'])): ?>
                            <p class="muted" style="margin: 8px 0 0;">Current: /uploads/<?= e((string)$news['image']) ?></p>
                        <?php endif; ?>
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
