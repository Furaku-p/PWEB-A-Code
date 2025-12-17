<?php
require_once "config.php";

$nis = trim($_POST["nis"] ?? "");
$nama = trim($_POST["nama"] ?? "");
$jk = trim($_POST["jenis_kelamin"] ?? "");
$telp = trim($_POST["telepon"] ?? "");
$alamat = trim($_POST["alamat"] ?? "");

$foto = "";

if (!empty($_FILES["foto"]["name"])) {
    $tmp = $_FILES["foto"]["tmp_name"];
    $err = $_FILES["foto"]["error"];

    if ($err === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
        $allow = ["jpg", "jpeg", "png", "webp"];

        if (in_array($ext, $allow, true)) {
            if (!is_dir("uploads")) {
                mkdir("uploads", 0777, true);
            }

            $foto = uniqid("foto_", true) . "." . $ext;
            move_uploaded_file($tmp, "uploads/" . $foto);
        }
    }
}

$stmt = $db->prepare("INSERT INTO siswa (nis, nama, jenis_kelamin, telepon, alamat, foto) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $nis, $nama, $jk, $telp, $alamat, $foto);
$ok = $stmt->execute();
$stmt->close();

header("Location: list-siswa.php?msg=" . ($ok ? "created" : "error"));
