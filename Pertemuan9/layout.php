<?php
function e($str) { return htmlspecialchars($str ?? "", ENT_QUOTES, "UTF-8"); }

function flash() {
  if (!isset($_GET['msg'])) return;
  $map = [
    "created" => ["success", "Data berhasil ditambahkan."],
    "updated" => ["success", "Data berhasil diperbarui."],
    "deleted" => ["success", "Data berhasil dihapus."],
    "error"   => ["danger",  "Terjadi kesalahan. Coba lagi."],
    "notfound"=> ["warning", "Data tidak ditemukan."],
  ];
  $key = $_GET['msg'];
  if (!isset($map[$key])) return;
  [$type, $text] = $map[$key];
  echo "<div class='alert alert-$type alert-dismissible fade show' role='alert'>"
     . e($text)
     . "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>"
     . "</div>";
}

function header_ui($title = "Pendaftaran Siswa") { ?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($title) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root { --bs-body-font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; }
    body { background: radial-gradient(1200px 600px at 10% 10%, rgba(13,110,253,.10), transparent 60%),
                  radial-gradient(900px 500px at 90% 20%, rgba(25,135,84,.10), transparent 60%),
                  #f8fafc; }
    .card { border: 0; border-radius: 16px; box-shadow: 0 10px 30px rgba(2, 8, 23, .08); }
    .navbar { backdrop-filter: blur(10px); }
    .badge-soft { background: rgba(13,110,253,.12); color: #0d6efd; border: 1px solid rgba(13,110,253,.18); }
    .btn { border-radius: 12px; }
    .form-control, .form-select { border-radius: 12px; }
    .table { vertical-align: middle; }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg sticky-top bg-white bg-opacity-75 border-bottom">
  <div class="container py-2">
    <a class="navbar-brand fw-bold" href="index.php">📚 Pendaftaran Siswa</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto gap-1">
        <li class="nav-item"><a class="nav-link" href="list-siswa.php">Daftar Siswa</a></li>
        <li class="nav-item"><a class="btn btn-primary btn-sm px-3" href="form-daftar.php">+ Tambah</a></li>
      </ul>
    </div>
  </div>
</nav>

<main class="container py-4 py-lg-5">
<?php }

function footer_ui() { ?>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php } ?>
