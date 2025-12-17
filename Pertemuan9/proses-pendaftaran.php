<?php
require_once "config.php";

if (!isset($_POST['daftar'])) {
    header("Location: form-daftar.php?msg=error");
    exit;
}

$nama          = trim($_POST['nama'] ?? "");
$alamat        = trim($_POST['alamat'] ?? "");
$jenis_kelamin = trim($_POST['jenis_kelamin'] ?? "");
$agama         = trim($_POST['agama'] ?? "");
$sekolah_asal  = trim($_POST['sekolah_asal'] ?? "");

if ($nama === "" || $alamat === "" || $jenis_kelamin === "" || $agama === "" || $sekolah_asal === "") {
    header("Location: form-daftar.php?msg=error");
    exit;
}

$stmt = $db->prepare("INSERT INTO siswa (nama, alamat, jenis_kelamin, agama, sekolah_asal) VALUES (?,?,?,?,?)");
if (!$stmt) { header("Location: form-daftar.php?msg=error"); exit; }

$stmt->bind_param("sssss", $nama, $alamat, $jenis_kelamin, $agama, $sekolah_asal);
$ok = $stmt->execute();
$stmt->close();

header("Location: list-siswa.php?msg=" . ($ok ? "created" : "error"));
