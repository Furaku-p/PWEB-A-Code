<?php
require_once "config.php";

$id = (int)($_POST["id"] ?? 0);
$nis = trim($_POST["nis"] ?? "");
$nama = trim($_POST["nama"] ?? "");
$jk = trim($_POST["jenis_kelamin"] ?? "");
$telp = trim($_POST["telepon"] ?? "");
$alamat = trim($_POST["alamat"] ?? "");

$stmt = $db->prepare("SELECT foto FROM siswa WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$old = $res->fetch_assoc();
$stmt->close();

if (!$old) {
    header("Location: list-siswa.php?msg=notfound");
    exit;
}

$foto = $old["foto"] ?? "";

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

            $new = uniqid("foto_", true) . "." . $ext;
            if (move_uploaded_file($tmp, "uploads/" . $new)) {
                if (!empty($foto) && file_exists("uploads/" . $foto)) {
                    unlink("uploads/" . $foto);
                }
                $foto = $new;
            }
        }
    }
}

$stmt = $db->prepare("UPDATE siswa SET nis=?, nama=?, jenis_kelamin=?, telepon=?, alamat=?, foto=? WHERE id=?");
$stmt->bind_param("ssssssi", $nis, $nama, $jk, $telp, $alamat, $foto, $id);
$ok = $stmt->execute();
$stmt->close();

header("Location: list-siswa.php?msg=" . ($ok ? "updated" : "error"));
