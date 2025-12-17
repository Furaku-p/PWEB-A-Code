<?php
require_once "config.php";
require_once "layout.php";

$id = (int)($_GET["id"] ?? 0);
$stmt = $db->prepare("SELECT * FROM siswa WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$data = $res->fetch_assoc();
$stmt->close();

if (!$data) {
    header("Location: list-siswa.php?msg=notfound");
    exit;
}

header_ui("Edit Siswa");
?>
<div class="card p-3 p-lg-4">
    <h4 class="fw-bold mb-3">Edit Data Siswa</h4>

    <form action="proses-edit.php" method="post" class="row g-3">
        <input type="hidden" name="id" value="<?= (int)$data["id"] ?>">

        <div class="col-md-6">
            <label class="form-label">Nama</label>
            <input required name="nama" class="form-control" value="<?= e($data["nama"]) ?>" placeholder="Nama siswa">
        </div>

        <div class="col-md-6">
            <label class="form-label">Sekolah Asal</label>
            <input required name="sekolah_asal" class="form-control" value="<?= e($data["sekolah_asal"]) ?>" placeholder="Sekolah asal">
        </div>

        <div class="col-12">
            <label class="form-label">Alamat</label>
            <textarea required name="alamat" class="form-control" rows="3" placeholder="Alamat"><?= e($data["alamat"]) ?></textarea>
        </div>

        <div class="col-md-4">
            <label class="form-label">Jenis Kelamin</label>
            <select required name="jenis_kelamin" class="form-select">
                <option value="Laki-laki" <?= $data["jenis_kelamin"] === "Laki-laki" ? "selected" : "" ?>>Laki-laki</option>
                <option value="Perempuan" <?= $data["jenis_kelamin"] === "Perempuan" ? "selected" : "" ?>>Perempuan</option>
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">Agama</label>
            <select required name="agama" class="form-select">
                <option value="Islam" <?= $data["agama"] === "Islam" ? "selected" : "" ?>>Islam</option>
                <option value="Kristen" <?= $data["agama"] === "Kristen" ? "selected" : "" ?>>Kristen</option>
                <option value="Katolik" <?= $data["agama"] === "Katolik" ? "selected" : "" ?>>Katolik</option>
                <option value="Hindu" <?= $data["agama"] === "Hindu" ? "selected" : "" ?>>Hindu</option>
                <option value="Buddha" <?= $data["agama"] === "Buddha" ? "selected" : "" ?>>Buddha</option>
                <option value="Konghucu" <?= $data["agama"] === "Konghucu" ? "selected" : "" ?>>Konghucu</option>
                <option value="Lainnya" <?= $data["agama"] === "Lainnya" ? "selected" : "" ?>>Lainnya</option>
            </select>
        </div>

        <div class="col-12 d-flex flex-wrap gap-2 mt-3">
            <button class="btn btn-primary px-4" type="submit" name="simpan">
                Simpan
            </button>
            <a class="btn btn-outline-secondary px-4" href="list-siswa.php">
                Batal
            </a>
        </div>
    </form>
</div>
<?php footer_ui(); ?>
