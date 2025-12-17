<?php
require_once "config.php";
require_once "layout.php";

$result = $db->query("SELECT * FROM siswa ORDER BY id DESC");

header_ui("Daftar Siswa");
flash();
?>
<div class="d-flex justify-content-center">
    <div class="card p-3 p-lg-4 border border-secondary-subtle" style="max-width: 1100px; width: 100%;">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <div>
                <h4 class="fw-bold mb-0">Daftar Siswa</h4>
                <div class="text-secondary small">Data siswa</div>
            </div>

            <a href="form-daftar.php" class="text-decoration-none">
                <div class="border rounded-3 px-4 py-3 bg-light text-center">
                    <div class="fw-semibold text-secondary">+ Tambah Siswa</div>
                </div>
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 70px;">#</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th style="width: 120px;">Foto</th>
                        <th style="width: 180px;" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= e($row["nis"]) ?></td>
                                <td class="fw-semibold"><?= e($row["nama"]) ?></td>
                                <td><?= e($row["jenis_kelamin"]) ?></td>
                                <td><?= e($row["telepon"]) ?></td>
                                <td class="text-truncate" style="max-width: 360px;"><?= e($row["alamat"]) ?></td>
                                <td>
                                    <?php if (!empty($row["foto"])): ?>
                                        <img src="uploads/<?= e($row["foto"]) ?>" alt="foto" style="width: 54px; height: 54px; object-fit: cover;" class="rounded border">
                                    <?php else: ?>
                                        <span class="text-secondary small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a class="btn btn-sm btn-primary" href="form-edit.php?id=<?= (int)$row["id"] ?>">Edit</a>
                                    <a class="btn btn-sm btn-outline-danger"
                                    href="hapus.php?id=<?= (int)$row["id"] ?>"
                                    onclick="return confirm('Hapus data?');">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-secondary">
                                Belum ada data.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php footer_ui(); ?>
