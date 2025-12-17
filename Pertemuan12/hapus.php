<?php
require_once "config.php";

$id = (int)($_GET["id"] ?? 0);
if ($id <= 0) {
    header("Location: list-siswa.php?msg=error");
    exit;
}

$stmt = $db->prepare("SELECT foto FROM siswa WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$stmt->close();

$stmt = $db->prepare("DELETE FROM siswa WHERE id=?");
$stmt->bind_param("i", $id);
$ok = $stmt->execute();
$stmt->close();

if ($ok && $row && !empty($row["foto"])) {
    $path = "uploads/" . $row["foto"];
    if (file_exists($path)) {
        unlink($path);
    }
}

header("Location: list-siswa.php?msg=" . ($ok ? "deleted" : "error"));
