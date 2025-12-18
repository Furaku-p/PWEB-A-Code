<?php
declare(strict_types=1);

$DB_HOST = 'sql310.infinityfree.com';
$DB_NAME = 'if0_40687055_news_portal';
$DB_USER = 'if0_40687055';
$DB_PASS = 'lovens174';

$dsn = "mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, $options);
} catch (Throwable $e) {
    http_response_code(500);
    echo 'DB error';
    exit;
}
