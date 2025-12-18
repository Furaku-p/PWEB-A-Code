<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';

auth_require_login();

session_start_safe();
$me = auth_user();
$authorId = (int)($me['id'] ?? 0);

$id = require_int($_POST['id'] ?? 0, 0);
$title = trim((string)($_POST['title'] ?? ''));
$slug = trim((string)($_POST['slug'] ?? ''));
$categoryId = require_int($_POST['category_id'] ?? 0, 0);
$status = (string)($_POST['status'] ?? 'draft');
$content = trim((string)($_POST['content'] ?? ''));

if ($title === '' || $slug === '' || $categoryId <= 0 || $content === '') {
    flash_set('ok', 'Invalid input.');
    redirect($id > 0 ? "/admin/news_form.php?id={$id}" : "/admin/news_form.php");
}

$slug = slugify($slug);

$slugCheckSql = "SELECT id FROM news WHERE slug = ? " . ($id > 0 ? "AND id <> ?" : "") . " LIMIT 1";
$slugStmt = $pdo->prepare($slugCheckSql);
$slugStmt->execute($id > 0 ? [$slug, $id] : [$slug]);
if ($slugStmt->fetch()) {
    $slug = $slug . '-' . time();
}

$imageName = null;

if (!empty($_FILES['image']['name'])) {
    $file = $_FILES['image'];

    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        flash_set('ok', 'Upload error.');
        redirect($id > 0 ? "/admin/news_form.php?id={$id}" : "/admin/news_form.php");
    }

    $max = 2 * 1024 * 1024;
    if (($file['size'] ?? 0) > $max) {
        flash_set('ok', 'File too large.');
        redirect($id > 0 ? "/admin/news_form.php?id={$id}" : "/admin/news_form.php");
    }

    $ext = strtolower(pathinfo((string)$file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
    if (!in_array($ext, $allowed, true)) {
        flash_set('ok', 'Invalid extension.');
        redirect($id > 0 ? "/admin/news_form.php?id={$id}" : "/admin/news_form.php");
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file((string)$file['tmp_name']);
    $allowedMime = ['image/jpeg', 'image/png', 'image/webp'];
    if (!in_array((string)$mime, $allowedMime, true)) {
        flash_set('ok', 'Invalid file type.');
        redirect($id > 0 ? "/admin/news_form.php?id={$id}" : "/admin/news_form.php");
    }

    $imageName = $slug . '-' . bin2hex(random_bytes(6)) . '.' . ($ext === 'jpeg' ? 'jpg' : $ext);
    $destDir = __DIR__ . '/../uploads';
    if (!is_dir($destDir)) {
        mkdir($destDir, 0755, true);
    }

    $dest = $destDir . '/' . $imageName;
    if (!move_uploaded_file((string)$file['tmp_name'], $dest)) {
        flash_set('ok', 'Failed to save file.');
        redirect($id > 0 ? "/admin/news_form.php?id={$id}" : "/admin/news_form.php");
    }
}

$publishedAt = null;
if ($status === 'published') {
    $publishedAt = date('Y-m-d H:i:s');
}

if ($id > 0) {
    $oldStmt = $pdo->prepare("SELECT image FROM news WHERE id = ? LIMIT 1");
    $oldStmt->execute([$id]);
    $old = $oldStmt->fetch();

    if ($imageName === null) {
        $stmt = $pdo->prepare("
            UPDATE news
            SET category_id = ?, title = ?, slug = ?, content = ?, author_id = ?, status = ?,
                published_at = CASE WHEN ? = 'published' AND published_at IS NULL THEN ? ELSE published_at END
            WHERE id = ?
        ");
        $stmt->execute([$categoryId, $title, $slug, $content, $authorId, $status, $status, $publishedAt, $id]);
    } else {
        $stmt = $pdo->prepare("
            UPDATE news
            SET category_id = ?, title = ?, slug = ?, content = ?, image = ?, author_id = ?, status = ?,
                published_at = CASE WHEN ? = 'published' AND published_at IS NULL THEN ? ELSE published_at END
            WHERE id = ?
        ");
        $stmt->execute([$categoryId, $title, $slug, $content, $imageName, $authorId, $status, $status, $publishedAt, $id]);

        if ($old && !empty($old['image'])) {
            $p = __DIR__ . '/../uploads/' . (string)$old['image'];
            if (is_file($p)) {
                @unlink($p);
            }
        }
    }

    flash_set('ok', 'Saved.');
    redirect('/admin/news_list.php');
}

$stmt = $pdo->prepare("
    INSERT INTO news (category_id, title, slug, content, image, author_id, published_at, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");
$stmt->execute([
    $categoryId,
    $title,
    $slug,
    $content,
    $imageName,
    $authorId,
    $publishedAt,
    $status
]);

flash_set('ok', 'Created.');
redirect('/admin/news_list.php');
