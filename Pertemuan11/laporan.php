<?php
include 'cek_login.php';
include 'config.php';
include 'layout.php';

$dari   = $_GET['dari'] ?? date('Y-m-01');
$sampai = $_GET['sampai'] ?? date('Y-m-d');

$data = $db->query(
    "SELECT tanggal, SUM(total) total
     FROM transaksi
     WHERE tanggal BETWEEN '$dari' AND '$sampai'
     GROUP BY tanggal
     ORDER BY tanggal ASC"
);

$grand = $db->query(
    "SELECT SUM(total) total
     FROM transaksi
     WHERE tanggal BETWEEN '$dari' AND '$sampai'"
)->fetch_assoc();
?>

<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h4 class="mb-0 fw-semibold">Laporan</h4>
        <div class="text-secondary">Rekap pendapatan berdasarkan tanggal</div>
    </div>
</div>

<div class="card border border-primary-subtle shadow-sm rounded-3">
    <div class="card-body p-4">
        <form class="row g-2 align-items-end mb-3">
            <div class="col-md-4">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" class="form-control" name="dari" value="<?= $dari ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" class="form-control" name="sampai" value="<?= $sampai ?>">
            </div>
            <div class="col-md-4">
                <button class="btn btn-primary w-100">
                    <i class="bi bi-funnel me-1"></i>Filter Laporan
                </button>
            </div>
        </form>

        <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="fw-semibold"><i class="bi bi-table me-2"></i>Hasil</div>
            <div class="fw-semibold text-primary">
                Total: Rp <?= number_format($grand['total'] ?? 0) ?>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($data->num_rows == 0): ?>
                        <tr><td colspan="2" class="text-center text-secondary py-4">Tidak ada data pada rentang ini</td></tr>
                    <?php endif ?>

                    <?php while ($r = $data->fetch_assoc()): ?>
                    <tr>
                        <td><?= $r['tanggal'] ?></td>
                        <td class="text-end">Rp <?= number_format($r['total']) ?></td>
                    </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
