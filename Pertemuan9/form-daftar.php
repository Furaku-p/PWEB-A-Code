<?php
require_once "layout.php";
header_ui("Tambah Siswa");
?>
<div class="card p-3 p-lg-4">
    <h4 class="fw-bold mb-3">Form Pendaftaran</h4>

    <form action="proses-pendaftaran.php" method="post" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Nama</label>
            <input required name="nama" class="form-control" placeholder="Nama siswa">
        </div>

        <div class="col-md-6">
            <label class="form-label">Sekolah Asal</label>
            <input required name="sekolah_asal" class="form-control" placeholder="Sekolah asal">
        </div>

        <div class="col-12">
            <label class="form-label">Alamat</label>
            <textarea required name="alamat" class="form-control" rows="3" placeholder="Alamat"></textarea>
        </div>

        <div class="col-md-4">
            <label class="form-label">Jenis Kelamin</label>
            <select required name="jenis_kelamin" class="form-select">
                <option value="" selected>Pilih</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">Agama</label>
            <select required name="agama" class="form-select">
                <option value="" selected>Pilih</option>
                <option value="Islam">Islam</option>
                <option value="Kristen">Kristen</option>
                <option value="Katolik">Katolik</option>
                <option value="Hindu">Hindu</option>
                <option value="Buddha">Buddha</option>
                <option value="Konghucu">Konghucu</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>

        <div class="col-12 d-flex flex-wrap gap-2 mt-3">
            <button class="btn btn-primary px-4" type="submit" name="daftar">
                Simpan
            </button>
            <a class="btn btn-outline-secondary px-4" href="list-siswa.php">
                Batal
            </a>
        </div>
    </form>
</div>
<?php footer_ui(); ?>
