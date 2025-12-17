<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>LaundryCrafty</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg bg-white border-bottom">
    <div class="container">
        <a class="navbar-brand fw-semibold text-primary" href="index.php">
            <i class="bi bi-droplet-half me-1"></i>LaundryCrafty
        </a>

        <?php if (isset($_SESSION['login'])): ?>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="pelanggan.php"><i class="bi bi-people me-1"></i>Pelanggan</a></li>
                <li class="nav-item"><a class="nav-link" href="layanan.php"><i class="bi bi-tags me-1"></i>Layanan</a></li>
                <li class="nav-item"><a class="nav-link" href="transaksi.php"><i class="bi bi-receipt me-1"></i>Transaksi</a></li>
                <li class="nav-item"><a class="nav-link" href="laporan.php"><i class="bi bi-graph-up me-1"></i>Laporan</a></li>
                <li class="nav-item"><a class="nav-link text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-1"></i>Logout</a></li>
            </ul>
        <?php endif ?>
    </div>
</nav>

<div class="container py-4">
