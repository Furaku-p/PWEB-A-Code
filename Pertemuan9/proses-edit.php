<?php
require_once "config.php";

if (!isset($_POST['simpan'])) {
    header("Location: list-siswa.php?msg=error");
    exit;
}

$id            = (int)($_POST['id'] ?? 0);
$nama          = trim($_POST['nama'] ?? "");
$alamat        = trim($_POST['alamat'] ?? "");
$jenis_kelamin = trim($_POST['jenis_kelamin'] ?? "");
$agama         = trim($_POST['agama'] ?? "");
$sekolah_asal  = trim($_POST['sekolah_asal'] ?? "");

if ($id <= 0 || $nama === "" || $alamat === "" || $jenis_kelamin === "" || $agama === "" || $sekolah_asal === "") {
    header("Location: list-siswa.php?msg=error");
    exit;
}

$stmt = $db->prepare("UPDATE siswa SET nama=?, alamat=?, jenis_kelamin=?, agama=?, sekolah_asal=? WHERE id=?");
if (!$stmt) { header("Location: list-siswa.php?msg=error"); exit; }

$stmt->bind_param("sssssi", $nama, $alamat, $jenis_kelamin, $agama, $sekolah_asal, $id);
$ok = $stmt->execute();
$stmt->close();

header("Location: list-siswa.php?msg=" . ($ok ? "updated" : "error"));
