<?php
function e($str)
{
    return htmlspecialchars($str ?? "", ENT_QUOTES, "UTF-8");
}

function flash()
{
    if (!isset($_GET["msg"])) {
        return;
    }

    $map = [
        "created" => ["success", "Data berhasil ditambahkan."],
        "updated" => ["success", "Data berhasil diperbarui."],
        "deleted" => ["success", "Data berhasil dihapus."],
        "error" => ["danger", "Terjadi kesalahan."],
        "notfound" => ["warning", "Data tidak ditemukan."],
    ];

    $key = $_GET["msg"];
    if (!isset($map[$key])) {
        return;
    }

    [$type, $text] = $map[$key];

    echo "<div class='alert alert-$type alert-dismissible fade show' role='alert'>"
        . e($text)
        . "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>"
        . "</div>";
}

function header_ui($title = "Data Siswa")
{ ?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .card {
            border-radius: 12px;
        }
        .btn,
        .form-control,
        .form-select {
            border-radius: 10px;
        }
        .form-control,
        .form-select {
            background-color: #f1f3f5;
        }
        .table {
            vertical-align: middle;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white border-bottom">
    <div class="container py-2">
        <a class="navbar-brand fw-bold text-primary" href="index.php">Data Siswa</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto gap-1">
                <li class="nav-item">
                    <a class="nav-link" href="list-siswa.php">Daftar Siswa</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary btn-sm px-3" href="form-daftar.php">Tambah</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4 py-lg-5">
<?php }

function footer_ui()
{ ?>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php } ?>
