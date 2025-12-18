<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';

auth_require_login();

$id = require_int($_GET['id'] ?? 0, 0);
if ($id <= 0) {
    redirect('/admin/news_list.php');
}

$stmt = $pdo->prepare("SELECT image FROM news WHERE id = ? LIMIT 1");
$stmt->execute([$id]);
$row = $stmt->fetch();

$del = $pdo->prepare("DELETE FROM news WHERE id = ?");
$del->execute([$id]);

if ($row && !empty($row['image'])) {
    $p = __DIR__ . '/../uploads/' . (string)$row['image'];
    if (is_file($p)) {
        @unlink($p);
    }
}

flash_set('ok', 'Deleted.');
redirect('/admin/news_list.php');
