<?php
include 'cek_login.php';
include 'config.php';
include 'layout.php';

$p = $db->query("SELECT COUNT(*) total FROM pelanggan")->fetch_assoc();
$t = $db->query("SELECT COUNT(*) total FROM transaksi")->fetch_assoc();
$u = $db->query("SELECT SUM(total) total FROM transaksi")->fetch_assoc();
?>

<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h4 class="mb-0 fw-semibold">Dashboard</h4>
        <div class="text-secondary">Ringkasan data laundry</div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card border border-primary-subtle shadow-sm rounded-3">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-secondary">Pelanggan</div>
                        <div class="fs-3 fw-semibold"><?= $p['total'] ?></div>
                    </div>
                    <div class="fs-3 text-primary"><i class="bi bi-people"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border border-primary-subtle shadow-sm rounded-3">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-secondary">Transaksi</div>
                        <div class="fs-3 fw-semibold"><?= $t['total'] ?></div>
                    </div>
                    <div class="fs-3 text-primary"><i class="bi bi-receipt"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border border-primary-subtle shadow-sm rounded-3">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-secondary">Pendapatan</div>
                        <div class="fs-3 fw-semibold">Rp <?= number_format($u['total'] ?? 0) ?></div>
                    </div>
                    <div class="fs-3 text-primary"><i class="bi bi-cash-stack"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
