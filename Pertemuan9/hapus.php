<?php
require_once "config.php";

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header("Location: list-siswa.php?msg=error"); exit; }

$stmt = $db->prepare("DELETE FROM siswa WHERE id=?");
$stmt->bind_param("i", $id);
$ok = $stmt->execute();
$stmt->close();

header("Location: list-siswa.php?msg=" . ($ok ? "deleted" : "error"));
