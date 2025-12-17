<?php
require_once "layout.php";
header_ui("Home • Data Siswa");
?>
<div class="d-flex justify-content-center">
    <div class="card p-4 p-lg-5 border border-secondary-subtle" style="max-width: 720px; width: 100%;">
        <h4 class="fw-bold mb-2">Data Siswa</h4>
        <div class="text-secondary mb-4">Kelola data siswa (CRUD)</div>

        <div class="d-flex flex-wrap gap-2">
            <a class="btn btn-primary px-4" href="form-daftar.php">Tambah Siswa</a>
            <a class="btn btn-outline-secondary px-4" href="list-siswa.php">Daftar Siswa</a>
        </div>
    </div>
</div>
<?php footer_ui(); ?>
