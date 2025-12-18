<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/helpers.php';

session_start_safe();
if (!empty($_SESSION['user'])) {
    redirect('/admin/index.php');
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string)($_POST['username'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = 'Username atau Password yang anda masukkan salah.';
    } else {
        $stmt = $pdo->prepare("SELECT id, username, password, fullname, role FROM users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $u = $stmt->fetch();

        if ($u && password_verify($password, (string)$u['password'])) {
            $_SESSION['user'] = [
                'id' => (int)$u['id'],
                'username' => (string)$u['username'],
                'fullname' => (string)$u['fullname'],
                'role' => (string)$u['role'],
            ];
            redirect('/admin/index.php');
        } else {
            $error = 'Username atau Password yang anda masukkan salah.';
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Admin</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<header class="navbar">
    <div class="container">
        <div class="row" style="padding: 14px 0;">
            <a class="brand" href="/">News<span>Portal</span></a>
            <div class="nav"></div>
            <div></div>
        </div>
    </div>
</header>

<main class="main">
    <div class="container" style="max-width: 520px;">
        <div class="card">
            <div class="card-pad">
                <div class="kicker">Admin / Editor</div>
                <h1 class="title" style="margin-top: 10px;">Login</h1>

                <?php if ($error): ?>
                    <div class="alert alert-danger" style="margin-top: 12px;"><?= e($error) ?></div>
                <?php endif; ?>

                <form class="form" method="post" style="margin-top: 14px;" novalidate>
                    <div class="field">
                        <label>Username</label>
                        <input name="username" required autocomplete="username">
                    </div>
                    <div class="field">
                        <label>Password</label>
                        <input type="password" name="password" required autocomplete="current-password">
                    </div>
                    <button class="btn btn-primary" type="submit">Masuk</button>
                    <a class="btn btn-ghost" href="/">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</main>

<footer class="footer">
    <div class="container">© <?= e(date('Y')) ?> NewsPortal</div>
</footer>
</body>
</html>
