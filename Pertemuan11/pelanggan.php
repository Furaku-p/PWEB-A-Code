<?php
include 'cek_login.php';
include 'config.php';
include 'layout.php';

if (isset($_POST['tambah'])) {
    $nama   = trim($_POST['nama']);
    $alamat = trim($_POST['alamat']);
    $hp     = trim($_POST['hp']);

    $db->query("INSERT INTO pelanggan VALUES (NULL,'$nama','$alamat','$hp')");
    header('Location: pelanggan.php?ok=1');
    exit;
}

if (isset($_GET['hapus'])) {
    $db->query("DELETE FROM pelanggan WHERE id_pelanggan='$_GET[hapus]'");
    header('Location: pelanggan.php?ok=2');
    exit;
}

$data = $db->query("SELECT * FROM pelanggan ORDER BY id_pelanggan DESC");
?>

<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h4 class="mb-0 fw-semibold">Pelanggan</h4>
        <div class="text-secondary">Tambah dan kelola pelanggan</div>
    </div>
</div>

<?php if (isset($_GET['ok']) && $_GET['ok'] == 1): ?>
    <div class="alert alert-success border-0 shadow-sm">Pelanggan berhasil ditambahkan</div>
<?php endif ?>
<?php if (isset($_GET['ok']) && $_GET['ok'] == 2): ?>
    <div class="alert alert-success border-0 shadow-sm">Pelanggan berhasil dihapus</div>
<?php endif ?>

<div class="row g-3">
    <div class="col-md-4">
        <div class="card border border-primary-subtle shadow-sm rounded-3">
            <div class="card-body p-4">
                <h5 class="fw-semibold mb-3"><i class="bi bi-person-plus me-2"></i>Tambah Pelanggan</h5>

                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input class="form-control" name="nama" placeholder="Contoh: Budi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" rows="3" placeholder="Contoh: Jl. Melati No. 10"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No HP</label>
                        <input class="form-control" name="hp" placeholder="Contoh: 08xxxxxxxxxx">
                    </div>

                    <button name="tambah" class="btn btn-primary w-100">
                        <i class="bi bi-check2-circle me-1"></i>Simpan Pelanggan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card border border-primary-subtle shadow-sm rounded-3">
            <div class="card-body p-0">
                <div class="p-3 border-bottom bg-white rounded-top-3">
                    <div class="fw-semibold"><i class="bi bi-list-ul me-2"></i>Daftar Pelanggan</div>
                </div>

                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th width="90"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($data->num_rows == 0): ?>
                            <tr><td colspan="4" class="text-center text-secondary py-4">Belum ada data</td></tr>
                        <?php endif ?>

                        <?php while ($p = $data->fetch_assoc()): ?>
                        <tr>
                            <td><?= $p['nama'] ?></td>
                            <td><?= $p['no_hp'] ?></td>
                            <td><?= $p['alamat'] ?></td>
                            <td>
                                <a class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Hapus pelanggan ini?')"
                                href="?hapus=<?= $p['id_pelanggan'] ?>">
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
