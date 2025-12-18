<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';

auth_require_login();

$id = require_int($_POST['id'] ?? 0, 0);
$name = trim((string)($_POST['name'] ?? ''));
$slug = trim((string)($_POST['slug'] ?? ''));
$desc = trim((string)($_POST['description'] ?? ''));

if ($name === '' || $slug === '') {
    flash_set('ok', 'Invalid input.');
    redirect($id > 0 ? "/admin/categories_form.php?id={$id}" : "/admin/categories_form.php");
}

$slug = slugify($slug);

$slugCheckSql = "SELECT id FROM categories WHERE slug = ? " . ($id > 0 ? "AND id <> ?" : "") . " LIMIT 1";
$slugStmt = $pdo->prepare($slugCheckSql);
$slugStmt->execute($id > 0 ? [$slug, $id] : [$slug]);
if ($slugStmt->fetch()) {
    $slug = $slug . '-' . time();
}

if ($id > 0) {
    $stmt = $pdo->prepare("UPDATE categories SET name = ?, slug = ?, description = ? WHERE id = ?");
    $stmt->execute([$name, $slug, $desc !== '' ? $desc : null, $id]);
    flash_set('ok', 'Saved.');
    redirect('/admin/categories_list.php');
}

$stmt = $pdo->prepare("INSERT INTO categories (name, slug, description) VALUES (?, ?, ?)");
$stmt->execute([$name, $slug, $desc !== '' ? $desc : null]);

flash_set('ok', 'Created.');
redirect('/admin/categories_list.php');
