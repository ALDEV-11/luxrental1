<?php
require __DIR__ . '/../../config/koneksi.php'; // file koneksi PDO kamu

if (isset($_POST['nik'])) {
    $nik = trim($_POST['nik']);

    $stmt = $pdo->prepare("SELECT * FROM tbl_member WHERE nik = :nik");
    $stmt->execute(['nik' => $nik]);

    if ($stmt->rowCount() > 0) {
        echo "<span class='text-red-400'><i class='fas fa-times-circle mr-1'></i>NIK sudah terpakai</span>";
    } else {
        echo "<span class='text-green-400'><i class='fas fa-check-circle mr-1'></i>NIK tersedia</span>";
    }
}
