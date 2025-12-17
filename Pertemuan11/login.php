<?php
session_start();
include 'config.php';

$error = '';

if (isset($_POST['login'])) {
    $u = $_POST['username'];
    $p = $_POST['password'];

    $q = $db->query("SELECT * FROM users WHERE username='$u'");
    $d = $q->fetch_assoc();

    if ($d && password_verify($p, $d['password'])) {
        $_SESSION['login'] = true;
        header('Location: index.php');
        exit;
    }

    $error = 'Login gagal';
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center vh-100">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card border border-primary-subtle shadow-sm rounded-3">
                <div class="card-body p-4">
                    <h4 class="fw-semibold text-center text-primary mb-1">
                        LaundryCrafty
                    </h4>
                    <p class="text-center text-secondary mb-4">
                        Login Admin
                    </p>

                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif ?>

                    <form method="post">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input class="form-control" name="username" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <div class="input-group">
                                <input
                                    type="password"
                                    class="form-control"
                                    name="password"
                                    id="password"
                                    required
                                >
                                <button
                                    class="btn btn-outline-primary"
                                    type="button"
                                    onclick="togglePassword()"
                                >
                                    <i id="eyeIcon" class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <button name="login" class="btn btn-primary w-100">
                            Login
                        </button>

                        <div class="text-center mt-3">
                            <span class="text-secondary">Belum punya akun?</span>
                            <a href="register.php" class="text-primary fw-semibold text-decoration-none">
                                Daftar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('eyeIcon');

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}
</script>

</body>
</html>
