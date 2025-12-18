<?php
declare(strict_types=1);

require_once __DIR__ . '/helpers.php';

function auth_require_login(): void
{
    session_start_safe();
    if (empty($_SESSION['user'])) {
        redirect('/admin/login.php');
    }
}

function auth_user(): ?array
{
    session_start_safe();
    return $_SESSION['user'] ?? null;
}

function auth_is_admin(): bool
{
    $u = auth_user();
    return $u && ($u['role'] ?? '') === 'admin';
}
