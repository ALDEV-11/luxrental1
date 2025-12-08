<?php
require __DIR__ . '/../../config/koneksi.php';

if (isset($_POST['user'])) {
    $username = trim($_POST['user']);

    try {
        $stmt = $pdo->prepare("SELECT * FROM tbl_member WHERE user = :user");
        $stmt->execute(['user' => $username]);

        if ($stmt->rowCount() > 0) {
            echo "<span class='text-red-400'><i class='fas fa-times-circle mr-1'></i>Username sudah terpakai</span>";
        } else {
            echo "<span class='text-green-400'><i class='fas fa-check-circle mr-1'></i>Username tersedia</span>";
        }
    } catch (PDOException $e) {
        echo "<span class='text-red-400'><i class='fas fa-exclamation-circle mr-1'></i>Error: " . htmlspecialchars($e->getMessage()) . "</span>";
    }
}
