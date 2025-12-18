<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Laporan PDF</title>
    <link rel="stylesheet" href="style.css">
</head>
    
<body>
    <div class="wrap">
        <div class="card">
            <div class="card-inner">
                <h1 class="title">
                    DAFTAR SISWA KELAS IX<br>
                    JURUSAN REKAYASA PERANGKAT LUNAK
                </h1>
                <p class="subtitle">Klik tombol di bawah untuk membuat laporan PDF.</p>

                <div class="actions">
                    <a href="laporan_siswa.php" target="_blank" class="btn">Cetak PDF</a>
                </div>
            </div>

            <div class="footer">
                <div>© <?php echo date('Y'); ?> Laporan Siswa</div>
            </div>
        </div>
    </div>
</body>
</html>
