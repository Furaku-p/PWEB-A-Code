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
<div class="d-flex justify-content-center">
    <div class="card p-3 p-lg-4 border border-secondary-subtle" style="max-width: 720px; width: 100%;">
        <h4 class="fw-bold mb-3">Edit Siswa</h4>

        <form action="proses-edit.php" method="post" class="row g-3" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= (int)$data["id"] ?>">

            <div class="col-md-6">
                <label class="form-label">NIS</label>
                <input required name="nis" class="form-control" value="<?= e($data["nis"]) ?>">
            </div>

            <div class="col-md-6">
                <label class="form-label">Nama</label>
                <input required name="nama" class="form-control" value="<?= e($data["nama"]) ?>">
            </div>

            <div class="col-md-6">
                <label class="form-label">Jenis Kelamin</label>
                <select required name="jenis_kelamin" class="form-select">
                    <option value="Laki-laki" <?= $data["jenis_kelamin"] === "Laki-laki" ? "selected" : "" ?>>Laki-laki</option>
                    <option value="Perempuan" <?= $data["jenis_kelamin"] === "Perempuan" ? "selected" : "" ?>>Perempuan</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Telepon</label>
                <input name="telepon" class="form-control" value="<?= e($data["telepon"]) ?>">
            </div>

            <div class="col-12">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="3"><?= e($data["alamat"]) ?></textarea>
            </div>

            <div class="col-12">
                <label class="form-label">Foto</label>
                <?php if (!empty($data["foto"])): ?>
                    <div class="mb-2">
                        <img src="uploads/<?= e($data["foto"]) ?>" alt="foto" style="width: 90px; height: 90px; object-fit: cover;" class="rounded border">
                    </div>
                <?php endif; ?>
                <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                <div class="form-text">Kosongkan kalau tidak ganti foto.</div>
            </div>

            <div class="col-12 d-flex flex-wrap gap-2 mt-3">
                <button class="btn btn-primary px-4" type="submit" name="simpan">Simpan</button>
                <a class="btn btn-outline-secondary px-4" href="list-siswa.php">Batal</a>
            </div>
        </form>
    </div>
</div>
<?php footer_ui(); ?>
