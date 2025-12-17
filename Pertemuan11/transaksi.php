<?php
include 'cek_login.php';
include 'config.php';
include 'layout.php';

if (isset($_POST['buat'])) {
    $pel = (int)$_POST['pelanggan'];
    $lay = (int)$_POST['layanan'];
    $ber = (float)$_POST['berat'];

    $h = $db->query("SELECT harga_per_kg FROM layanan WHERE id_layanan='$lay'")->fetch_assoc();
    $total = ($h['harga_per_kg'] ?? 0) * $ber;

    $db->query("INSERT INTO transaksi VALUES (NULL,'$pel','$lay',CURDATE(),'$ber','$total','Proses')");
    header('Location: transaksi.php?ok=1');
    exit;
}

if (isset($_GET['ambil'])) {
    $db->query("UPDATE transaksi SET status='Sudah Diambil' WHERE id_transaksi='$_GET[ambil]'");
    header('Location: transaksi.php?ok=2');
    exit;
}

if (isset($_GET['selesai'])) {
    $db->query("UPDATE transaksi SET status='Selesai' WHERE id_transaksi='$_GET[selesai]'");
    header('Location: transaksi.php?ok=3');
    exit;
}

$pelanggan = $db->query("SELECT * FROM pelanggan ORDER BY nama ASC");
$layanan   = $db->query("SELECT * FROM layanan ORDER BY nama_layanan ASC");

$data = $db->query(
    "SELECT t.*, p.nama, l.nama_layanan, l.harga_per_kg
     FROM transaksi t
     JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
     JOIN layanan l ON t.id_layanan = l.id_layanan
     ORDER BY id_transaksi DESC"
);
?>

<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h4 class="mb-0 fw-semibold">Transaksi</h4>
        <div class="text-secondary">Input transaksi dan update status</div>
    </div>
</div>

<?php if (isset($_GET['ok']) && $_GET['ok'] == 1): ?>
    <div class="alert alert-success border-0 shadow-sm">Transaksi berhasil dibuat</div>
<?php endif ?>
<?php if (isset($_GET['ok']) && $_GET['ok'] == 2): ?>
    <div class="alert alert-success border-0 shadow-sm">Status diubah: Sudah Diambil</div>
<?php endif ?>
<?php if (isset($_GET['ok']) && $_GET['ok'] == 3): ?>
    <div class="alert alert-success border-0 shadow-sm">Status diubah: Selesai</div>
<?php endif ?>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card border border-primary-subtle shadow-sm rounded-3">
            <div class="card-body p-4">
                <h5 class="fw-semibold mb-3"><i class="bi bi-receipt-cutoff me-2"></i>Buat Transaksi</h5>

                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Pelanggan</label>
                        <select class="form-select" name="pelanggan" required>
                            <?php while ($p = $pelanggan->fetch_assoc()): ?>
                                <option value="<?= $p['id_pelanggan'] ?>"><?= $p['nama'] ?></option>
                            <?php endwhile ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Layanan</label>
                        <select class="form-select" name="layanan" required>
                            <?php while ($l = $layanan->fetch_assoc()): ?>
                                <option value="<?= $l['id_layanan'] ?>">
                                    <?= $l['nama_layanan'] ?> (Rp <?= number_format($l['harga_per_kg']) ?>/Kg)
                                </option>
                            <?php endwhile ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Berat (Kg)</label>
                        <input type="number" step="0.1" class="form-control" name="berat" placeholder="Contoh: 2.5" required>
                    </div>

                    <button name="buat" class="btn btn-primary w-100">
                        <i class="bi bi-plus-circle me-1"></i>Buat Transaksi
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card border border-primary-subtle shadow-sm rounded-3">
            <div class="card-body p-0">
                <div class="p-3 border-bottom bg-white rounded-top-3">
                    <div class="fw-semibold"><i class="bi bi-list-ul me-2"></i>Daftar Transaksi</div>
                </div>

                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Layanan</th>
                                <th>Berat</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th width="150"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($data->num_rows == 0): ?>
                                <tr><td colspan="7" class="text-center text-secondary py-4">Belum ada transaksi</td></tr>
                            <?php endif ?>

                            <?php while ($t = $data->fetch_assoc()): ?>
                            <tr>
                                <td><?= $t['tanggal'] ?></td>
                                <td><?= $t['nama'] ?></td>
                                <td><?= $t['nama_layanan'] ?></td>
                                <td><?= $t['berat'] ?> Kg</td>
                                <td>Rp <?= number_format($t['total']) ?></td>
                                <td>
                                    <?php if ($t['status'] == 'Proses'): ?>
                                        <span class="badge text-bg-warning">Proses</span>
                                    <?php elseif ($t['status'] == 'Selesai'): ?>
                                        <span class="badge text-bg-primary">Selesai</span>
                                    <?php else: ?>
                                        <span class="badge text-bg-success">Sudah Diambil</span>
                                    <?php endif ?>
                                </td>
                                <td class="text-end">
                                    <a class="btn btn-sm btn-outline-primary"
                                       href="?selesai=<?= $t['id_transaksi'] ?>">
                                        <i class="bi bi-check2"></i>
                                    </a>
                                    <a class="btn btn-sm btn-outline-success"
                                       href="?ambil=<?= $t['id_transaksi'] ?>">
                                        <i class="bi bi-bag-check"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile ?>
                        </tbody>
                    </table>
                </div>

                <div class="p-3 text-secondary small">
                    Tombol <i class="bi bi-check2"></i> = Selesai, tombol <i class="bi bi-bag-check"></i> = Sudah Diambil
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
