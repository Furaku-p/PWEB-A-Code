<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';

auth_require_login();
if (!auth_is_admin()) {
    redirect('/admin/index.php');
}

$id = require_int($_POST['id'] ?? 0, 0);
$username = trim((string)($_POST['username'] ?? ''));
$fullname = trim((string)($_POST['fullname'] ?? ''));
$role = (string)($_POST['role'] ?? 'editor');
$password = (string)($_POST['password'] ?? '');

if ($username === '' || $fullname === '' || !in_array($role, ['admin', 'editor'], true)) {
    flash_set('ok', 'Invalid input.');
    redirect($id > 0 ? "/admin/users_form.php?id={$id}" : "/admin/users_form.php");
}

if ($id > 0) {
    $exists = $pdo->prepare("SELECT id FROM users WHERE username = ? AND id <> ? LIMIT 1");
    $exists->execute([$username, $id]);
    if ($exists->fetch()) {
        flash_set('ok', 'Username taken.');
        redirect("/admin/users_form.php?id={$id}");
    }

    if ($password !== '') {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("UPDATE users SET username = ?, fullname = ?, role = ?, password = ? WHERE id = ?");
        $stmt->execute([$username, $fullname, $role, $hash, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE users SET username = ?, fullname = ?, role = ? WHERE id = ?");
        $stmt->execute([$username, $fullname, $role, $id]);
    }

    flash_set('ok', 'Saved.');
    redirect('/admin/users_list.php');
}

$exists = $pdo->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
$exists->execute([$username]);
if ($exists->fetch()) {
    flash_set('ok', 'Username taken.');
    redirect("/admin/users_form.php");
}

$hash = password_hash($password, PASSWORD_BCRYPT);

$stmt = $pdo->prepare("INSERT INTO users (username, password, fullname, role) VALUES (?, ?, ?, ?)");
$stmt->execute([$username, $hash, $fullname, $role]);

flash_set('ok', 'Created.');
redirect('/admin/users_list.php');
