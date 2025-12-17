<?php
$server = "sql310.infinityfree.com";
$user   = "if0_40687055";
$pass   = "lovens174";
$dbname = "if0_40687055_laundry_crafty";

$db = new mysqli($server, $user, $pass, $dbname);
if ($db->connect_error) {
    die("Koneksi gagal: " . $db->connect_error);
}

$db->set_charset("utf8mb4");
