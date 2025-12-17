<?php
require_once "layout.php";
header_ui("Home • Pendaftaran Siswa");
?>
<div class="row g-4 align-items-stretch">
    <div class="col-lg-7">
        <div class="card p-4 p-lg-5 h-100">
            <h1 class="h4 fw-bold mb-3">Aplikasi Pendaftaran Siswa</h1>

            <p class="text-secondary mb-4">
                Aplikasi sederhana untuk mengelola data pendaftaran siswa.
            </p>

            <div class="d-flex flex-wrap gap-2">
                <a class="btn btn-primary px-4" href="form-daftar.php">
                    Tambah Siswa
                </a>
                <a class="btn btn-outline-secondary px-4" href="list-siswa.php">
                    Lihat Daftar
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card p-4 h-100">
            <h5 class="fw-semibold mb-3">Menu</h5>

            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action py-3" href="form-daftar.php">
                    Form Pendaftaran
                </a>
                <a class="list-group-item list-group-item-action py-3" href="list-siswa.php">
                    Daftar Siswa
                </a>
            </div>
        </div>
    </div>
</div>
<?php footer_ui(); ?>
