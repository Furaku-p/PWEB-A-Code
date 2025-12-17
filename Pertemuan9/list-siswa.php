<?php
require_once "config.php";
require_once "layout.php";

$result = $db->query("SELECT * FROM siswa ORDER BY id DESC");

header_ui("Daftar Siswa");
flash();
?>
<div class="card p-3 p-lg-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <h4 class="fw-bold mb-0">Daftar Siswa</h4>
            <div class="text-secondary small">Data pendaftaran siswa</div>
        </div>
        <a class="btn btn-primary" href="form-daftar.php">Tambah</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width:70px;">#</th>
                    <th>Nama</th>
                    <th>JK</th>
                    <th>Agama</th>
                    <th>Sekolah Asal</th>
                    <th style="width:180px;" class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <div class="fw-semibold"><?= e($row["nama"]) ?></div>
                                <div class="text-secondary small text-truncate" style="max-width: 520px;">
                                    <?= e($row["alamat"]) ?>
                                </div>
                            </td>
                            <td><?= e($row["jenis_kelamin"]) ?></td>
                            <td><?= e($row["agama"]) ?></td>
                            <td><?= e($row["sekolah_asal"]) ?></td>
                            <td class="text-end">
                                <a class="btn btn-outline-secondary btn-sm" href="form-edit.php?id=<?= (int)$row["id"] ?>">Edit</a>
                                <a class="btn btn-outline-danger btn-sm"
                                href="hapus.php?id=<?= (int)$row["id"] ?>"
                                onclick="return confirm('Hapus data?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-secondary">
                            Belum ada data.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php footer_ui(); ?>
