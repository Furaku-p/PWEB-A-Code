<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';

auth_require_login();
if (!auth_is_admin()) {
    redirect('/admin/index.php');
}

$id = require_int($_GET['id'] ?? 0, 0);
if ($id <= 0) {
    redirect('/admin/users_list.php');
}

$me = auth_user();
if ($me && (int)$me['id'] === $id) {
    flash_set('ok', 'Cannot delete self.');
    redirect('/admin/users_list.php');
}

$cntStmt = $pdo->prepare("SELECT COUNT(*) AS c FROM news WHERE author_id = ?");
$cntStmt->execute([$id]);
$cnt = (int)($cntStmt->fetch()['c'] ?? 0);
if ($cnt > 0) {
    flash_set('ok', 'User has news.');
    redirect('/admin/users_list.php');
}

$del = $pdo->prepare("DELETE FROM users WHERE id = ?");
$del->execute([$id]);

flash_set('ok', 'Deleted.');
redirect('/admin/users_list.php');
