<?php
include 'cek_login.php';
include 'config.php';
include 'layout.php';

if (isset($_POST['tambah'])) {
    $nama  = trim($_POST['nama']);
    $harga = (int)$_POST['harga'];

    $db->query("INSERT INTO layanan VALUES (NULL,'$nama','$harga')");
    header('Location: layanan.php?ok=1');
    exit;
}

if (isset($_GET['hapus'])) {
    $db->query("DELETE FROM layanan WHERE id_layanan='$_GET[hapus]'");
    header('Location: layanan.php?ok=2');
    exit;
}

$data = $db->query("SELECT * FROM layanan ORDER BY id_layanan DESC");
?>

<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h4 class="mb-0 fw-semibold">Layanan</h4>
        <div class="text-secondary">Kelola jenis layanan dan harga</div>
    </div>
</div>

<?php if (isset($_GET['ok']) && $_GET['ok'] == 1): ?>
    <div class="alert alert-success border-0 shadow-sm">Layanan berhasil ditambahkan</div>
<?php endif ?>
<?php if (isset($_GET['ok']) && $_GET['ok'] == 2): ?>
    <div class="alert alert-success border-0 shadow-sm">Layanan berhasil dihapus</div>
<?php endif ?>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card border border-primary-subtle shadow-sm rounded-3">
            <div class="card-body p-4">
                <h5 class="fw-semibold mb-3"><i class="bi bi-tag me-2"></i>Tambah Layanan</h5>

                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Nama Layanan</label>
                        <input class="form-control" name="nama" placeholder="Contoh: Cuci Kering" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga / Kg</label>
                        <input type="number" class="form-control" name="harga" placeholder="Contoh: 7000" required>
                        <div class="form-text">Masukkan angka tanpa titik/koma.</div>
                    </div>

                    <button name="tambah" class="btn btn-primary w-100">
                        <i class="bi bi-check2-circle me-1"></i>Simpan Layanan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card border border-primary-subtle shadow-sm rounded-3">
            <div class="card-body p-0">
                <div class="p-3 border-bottom bg-white rounded-top-3">
                    <div class="fw-semibold"><i class="bi bi-list-ul me-2"></i>Daftar Layanan</div>
                </div>

                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Layanan</th>
                            <th>Harga / Kg</th>
                            <th width="90"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($data->num_rows == 0): ?>
                            <tr><td colspan="3" class="text-center text-secondary py-4">Belum ada data</td></tr>
                        <?php endif ?>

                        <?php while ($l = $data->fetch_assoc()): ?>
                        <tr>
                            <td><?= $l['nama_layanan'] ?></td>
                            <td>Rp <?= number_format($l['harga_per_kg']) ?></td>
                            <td>
                                <a class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Hapus layanan ini?')"
                                href="?hapus=<?= $l['id_layanan'] ?>">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
