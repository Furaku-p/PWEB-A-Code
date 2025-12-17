<?php
require_once "layout.php";
header_ui("Tambah Siswa");
?>
<div class="d-flex justify-content-center">
    <div class="card p-3 p-lg-4 border border-secondary-subtle" style="max-width: 720px; width: 100%;">
        <h4 class="fw-bold mb-3">Tambah Siswa</h4>

        <form action="proses-pendaftaran.php" method="post" class="row g-3" enctype="multipart/form-data">
            <div class="col-md-6">
                <label class="form-label">NIS</label>
                <input required name="nis" class="form-control" placeholder="NIS">
            </div>

            <div class="col-md-6">
                <label class="form-label">Nama</label>
                <input required name="nama" class="form-control" placeholder="Nama siswa">
            </div>

            <div class="col-md-6">
                <label class="form-label">Jenis Kelamin</label>
                <select required name="jenis_kelamin" class="form-select">
                    <option value="" selected>Pilih</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Telepon</label>
                <input name="telepon" class="form-control" placeholder="08xxxx">
            </div>

            <div class="col-12">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat"></textarea>
            </div>

            <div class="col-12">
                <label class="form-label">Foto</label>
                <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                <div class="form-text">JPG/PNG/WEBP. Boleh kosong.</div>
            </div>

            <div class="col-12 d-flex flex-wrap gap-2 mt-3">
                <button class="btn btn-primary px-4" type="submit" name="daftar">Simpan</button>
                <a class="btn btn-outline-secondary px-4" href="list-siswa.php">Batal</a>
            </div>
        </form>
    </div>
</div>
<?php footer_ui(); ?>
