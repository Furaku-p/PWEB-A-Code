<?php
declare(strict_types=1);

function e(string $v): string
{
    return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void
{
    header("Location: {$path}");
    exit;
}

function slugify(string $text): string
{
    $text = mb_strtolower($text);
    $text = preg_replace('~[^\pL\pN]+~u', '-', $text) ?? '';
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text) ?? '';
    return $text !== '' ? $text : 'n-a';
}

function session_start_safe(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
}

function flash_set(string $key, string $msg): void
{
    session_start_safe();
    $_SESSION['flash'][$key] = $msg;
}

function flash_get(string $key): ?string
{
    session_start_safe();
    if (!isset($_SESSION['flash'][$key])) {
        return null;
    }
    $msg = (string) $_SESSION['flash'][$key];
    unset($_SESSION['flash'][$key]);
    return $msg;
}

function require_int($v, int $default = 0): int
{
    $n = filter_var($v, FILTER_VALIDATE_INT);
    return $n === false ? $default : (int) $n;
}
