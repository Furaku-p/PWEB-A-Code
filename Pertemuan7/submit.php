<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

function respond(bool $ok, string $message, int $code = 200): void {
    http_response_code($code);
    echo json_encode(["ok" => $ok, "message" => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    respond(false, "Method not allowed", 405);
}

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$message = trim($_POST["message"] ?? "");

if ($name === "") respond(false, "Nama wajib diisi.", 422);
if ($email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) respond(false, "Email tidak valid.", 422);
if ($message === "") respond(false, "Pesan wajib diisi.", 422);

$line = date("c")." | $name | $email | ".preg_replace("/\s+/", " ", $message).PHP_EOL;
@file_put_contents(__DIR__ . "/messages.log", $line, FILE_APPEND);

respond(true, "Pesan Kamu Sudah Terkirim");
