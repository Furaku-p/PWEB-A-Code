<?php
require_once "layout.php";
header_ui("Tambah Siswa");
?>
<div class="card p-3 p-lg-4">
  <h4 class="fw-bold mb-1">Form Pendaftaran</h4>
  <div class="text-secondary mb-4">Masukkan data siswa baru.</div>

  <form action="proses-pendaftaran.php" method="post" class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Nama</label>
      <input required name="nama" class="form-control" placeholder="Contoh: Budi Santoso">
    </div>

    <div class="col-md-6">
      <label class="form-label">Sekolah Asal</label>
      <input required name="sekolah_asal" class="form-control" placeholder="Contoh: SMPN 1 Jakarta">
    </div>

    <div class="col-12">
      <label class="form-label">Alamat</label>
      <textarea required name="alamat" class="form-control" rows="3" placeholder="Alamat lengkap"></textarea>
    </div>

    <div class="col-md-4">
      <label class="form-label">Jenis Kelamin</label>
      <select required name="jenis_kelamin" class="form-select">
        <option value="" selected disabled>Pilih…</option>
        <option>Laki-laki</option>
        <option>Perempuan</option>
      </select>
    </div>

    <div class="col-md-4">
      <label class="form-label">Agama</label>
      <select required name="agama" class="form-select">
        <option value="" selected disabled>Pilih…</option>
        <option>Islam</option>
        <option>Kristen</option>
        <option>Katolik</option>
        <option>Hindu</option>
        <option>Buddha</option>
        <option>Konghucu</option>
        <option>Lainnya</option>
      </select>
    </div>

    <div class="col-12 d-flex gap-2 mt-2">
      <button class="btn btn-primary px-4" type="submit" name="daftar">Simpan</button>
      <a class="btn btn-outline-secondary px-4" href="list-siswa.php">Batal</a>
    </div>
  </form>
</div>
<?php footer_ui(); ?>
