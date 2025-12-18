<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/helpers.php';

session_start_safe();
unset($_SESSION['user']);
redirect('/admin/login.php');
