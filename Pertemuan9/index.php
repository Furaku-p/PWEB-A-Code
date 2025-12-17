<?php
require_once "layout.php";
header_ui("Home • Pendaftaran Siswa");
?>
<div class="row g-4 align-items-stretch">
  <div class="col-lg-7">
    <div class="card p-4 p-lg-5 h-100">
      <div class="d-flex align-items-center gap-2 mb-2">
        <span class="badge badge-soft rounded-pill px-3 py-2">CRUD PHP + MySQL</span>
      </div>
      <h1 class="display-6 fw-bold mb-3">Aplikasi Pendaftaran Siswa</h1>
      <p class="text-secondary mb-4">
        Versi modern dari tugas CRUD: tampilan rapi, responsif, dan aman pakai prepared statements.
      </p>
      <div class="d-flex flex-wrap gap-2">
        <a class="btn btn-primary px-4" href="form-daftar.php">Tambah Siswa</a>
        <a class="btn btn-outline-secondary px-4" href="list-siswa.php">Lihat Daftar</a>
      </div>
      <hr class="my-4">
      <div class="row g-3 small text-secondary">
        <div class="col-md-6">✅ Create / Read / Update / Delete</div>
        <div class="col-md-6">✅ Bootstrap 5 UI</div>
        <div class="col-md-6">✅ Alert & konfirmasi hapus</div>
        <div class="col-md-6">✅ Prepared statements</div>
      </div>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="card p-4 h-100">
      <h5 class="fw-semibold mb-3">Menu Cepat</h5>
      <div class="list-group list-group-flush">
        <a class="list-group-item list-group-item-action py-3" href="form-daftar.php">➕ Form Pendaftaran</a>
        <a class="list-group-item list-group-item-action py-3" href="list-siswa.php">📋 List Siswa</a>
      </div>
      <div class="mt-4 p-3 bg-light rounded-3">
        <div class="fw-semibold">Catatan</div>
        <div class="text-secondary small">Import dulu <code>pendaftaran_siswa.sql</code> di phpMyAdmin.</div>
      </div>
    </div>
  </div>
</div>
<?php footer_ui(); ?>
