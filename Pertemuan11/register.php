<?php
session_start();
include 'config.php';

$err = '';
$ok  = '';

if (isset($_POST['daftar'])) {
    $u  = trim($_POST['username']);
    $p1 = $_POST['password'];
    $p2 = $_POST['password2'];

    if ($u == '' || $p1 == '' || $p2 == '') {
        $err = 'Lengkapi data';
    } elseif ($p1 !== $p2) {
        $err = 'Password tidak sama';
    } else {
        $cek = $db->query("SELECT id FROM users WHERE username='$u'");
        if ($cek && $cek->num_rows > 0) {
            $err = 'Username sudah dipakai';
        } else {
            $hash = password_hash($p1, PASSWORD_DEFAULT);
            $db->query("INSERT INTO users (username, password) VALUES ('$u', '$hash')");
            $ok = 'Berhasil daftar, silakan login';
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center vh-100">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card border border-primary-subtle shadow-sm rounded-3">
                <div class="card-body p-4">
                    <h4 class="fw-semibold text-center text-primary mb-1">LaundryCrafty</h4>
                    <p class="text-center text-secondary mb-4">Registrasi Admin</p>

                    <?php if ($err): ?>
                        <div class="alert alert-danger"><?= $err ?></div>
                    <?php endif ?>

                    <?php if ($ok): ?>
                        <div class="alert alert-success"><?= $ok ?></div>
                    <?php endif ?>

                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input class="form-control" name="username" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ulangi Password</label>
                            <input type="password" class="form-control" name="password2" required>
                        </div>

                        <button name="daftar" class="btn btn-primary w-100">Daftar</button>
                        <a class="btn btn-link w-100 mt-2" href="login.php">Sudah punya akun? Login</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
