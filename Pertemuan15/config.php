<?php
$server = "sql310.infinityfree.com";
$user   = "if0_40687055";
$pass   = "lovens174";
$dbname = "if0_40687055_tutorial";

$connect = mysqli_connect($server, $user, $pass, $dbname);

if (!$connect) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

mysqli_set_charset($connect, "utf8mb4");
