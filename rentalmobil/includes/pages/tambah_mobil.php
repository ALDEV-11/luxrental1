<?php

// --- Contoh session role saat login ---
// $_SESSION['role'] = 'admin';   // untuk admin
// $_SESSION['role'] = 'petugas'; // untuk petugas

// koneksi ke database
$koneksi = new mysqli("localhost", "root", "root", "luxrental");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Variabel untuk pesan
$pesan = '';
$tipe_pesan = ''; // success, danger, warning

// Simpan data mobil (hanya jika role = petugas)
if (isset($_POST['simpan']) && $_SESSION['role'] == 'petugas') {
    $nopol   = $_POST['nopol'];
    $brand   = $_POST['brand'];
    $type    = $_POST['type'];
    $tahun   = $_POST['tahun'];
    $harga   = $_POST['harga'];
    $foto    = $_FILES['foto']['name'];
    $status  = $_POST['status'];

    // Cek apakah nopol sudah ada
    $cek_sql = $koneksi->prepare("SELECT nopol, brand, type FROM tbl_mobil WHERE nopol = ?");
    $cek_sql->bind_param("s", $nopol);
    $cek_sql->execute();
    $cek_result = $cek_sql->get_result();
    
    if ($cek_result->num_rows > 0) {
        // Nopol sudah ada
        $mobil_terdaftar = $cek_result->fetch_assoc();
        $pesan = "❌ Nomor polisi <strong>'$nopol'</strong> sudah digunakan oleh mobil <strong>" . 
                 htmlspecialchars($mobil_terdaftar['brand']) . " - " . 
                 htmlspecialchars($mobil_terdaftar['type']) . "</strong>";
        $tipe_pesan = 'danger';
    } else {
        // Nopol belum ada, lanjutkan proses upload dan simpan
        $target_dir = "uploads/mobil/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($foto);

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
            $sql = $koneksi->prepare("INSERT INTO tbl_mobil (nopol, brand, type, tahun, harga, foto, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $sql->bind_param("ssssiss", $nopol, $brand, $type, $tahun, $harga, $foto, $status);
            
            if ($sql->execute()) {
                $pesan = "✅ Mobil <strong>" . htmlspecialchars($brand) . " - " . htmlspecialchars($type) . "</strong> berhasil ditambahkan!";
                $tipe_pesan = 'success';
                
                // Reset form values
                echo "<script>
                    setTimeout(function() {
                        document.querySelector('form').reset();
                    }, 100);
                </script>";
            } else {
                $pesan = "❌ Gagal menambahkan mobil: " . $koneksi->error;
                $tipe_pesan = 'danger';
            }
        } else {
            $pesan = "❌ Gagal mengupload foto!";
            $tipe_pesan = 'danger';
        }
    }
}

// Ambil data mobil
$sql = "SELECT * FROM tbl_mobil ORDER BY nopol DESC";
$result = $koneksi->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>LuxRental - Manajemen Armada</title>
<link rel="icon" type="image/png" href="assets/img/favicon.png">
<link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
    /* LuxRental Luxury Theme */
    :root {
        --luxury-black: #0a0a0a;
        --luxury-gray: #1a1a1a;
        --luxury-gold: #d4af37;
        --luxury-gold-light: #f7e98e;
        --luxury-gold-dark: #b8941f;
        --luxury-silver: #c0c0c0;
    }
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, var(--luxury-black) 0%, var(--luxury-gray) 100%);
        color: var(--luxury-silver);
        min-height: 100vh;
        padding-bottom: 50px;
        position: relative;
    }
    
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
            radial-gradient(circle at 20% 50%, rgba(212, 175, 55, 0.05) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(212, 175, 55, 0.05) 0%, transparent 50%);
        pointer-events: none;
        z-index: 0;
    }
    
    .container {
        max-width: 1400px;
        position: relative;
        z-index: 1;
    }
    
    h1, h2, h3, h4, h5 {
        font-family: 'Playfair Display', serif;
    }
    
    /* Styling untuk Header Premium */
    .page-header {
        text-align: center;
        margin-bottom: 50px;
        padding: 60px 30px;
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.95) 0%, rgba(247, 233, 142, 0.95) 100%);
        border-radius: 25px;
        box-shadow: 0 20px 40px rgba(212, 175, 55, 0.3);
        position: relative;
        overflow: hidden;
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
        border-radius: 50%;
    }
    
    .page-header h1 {
        font-size: 48px;
        font-weight: 700;
        color: var(--luxury-black);
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        position: relative;
        z-index: 1;
    }
    
    .page-header h1 i {
        font-size: 42px;
        color: var(--luxury-black);
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    .page-header p {
        font-size: 18px;
        color: var(--luxury-black);
        opacity: 0.85;
        position: relative;
        z-index: 1;
    }
    
    /* Styling untuk h2 yang lebih premium */
    h2 {
        color: var(--luxury-gold) !important;
        position: relative;
        display: inline-block;
        font-weight: 800;
        font-size: 2rem;
        margin-bottom: 1.5rem;
        font-family: 'Playfair Display', serif;
    }
    
    h2:after {
        content: '';
        position: absolute;
        bottom: -12px;
        left: 0;
        width: 60px;
        height: 5px;
        background: linear-gradient(90deg, var(--luxury-gold), var(--luxury-gold-light));
        border-radius: 3px;
    }
    
    .card {
        border: 2px solid var(--luxury-gold) !important;
        border-radius: 25px !important;
        transition: all 0.3s ease;
        overflow: hidden;
        background: rgba(10, 10, 10, 0.6) !important;
        backdrop-filter: blur(10px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3) !important;
        position: relative;
    }
    
    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(to right, var(--luxury-gold), var(--luxury-gold-light));
        z-index: 1;
    }
    
    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(212, 175, 55, 0.4) !important;
        border-color: var(--luxury-gold-light) !important;
        background: rgba(26, 26, 26, 0.8) !important;
    }
    
    .card-img-top {
        transition: transform 0.5s ease;
        height: 200px;
        object-fit: cover;
        position: relative;
        z-index: 0;
    }
    
    .card:hover .card-img-top {
        transform: scale(1.08);
    }
    
    .card-body {
        padding: 1.5rem;
        position: relative;
        z-index: 2;
        background: transparent !important;
    }
    
    .card-title {
        color: var(--luxury-gold) !important;
        font-weight: 700;
        margin-bottom: 0.75rem;
        font-size: 1.3rem;
        font-family: 'Playfair Display', serif;
    }
    
    .card-text {
        color: var(--luxury-silver) !important;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
    
    .card-text strong {
        color: var(--luxury-gold) !important;
    }
    
    /* Price styling */
    .card-text.price {
        color: var(--luxury-gold) !important;
        font-weight: 700;
        font-size: 1.1rem;
        font-family: 'Playfair Display', serif;
    }
    
    .badge {
        font-size: 0.8rem;
        padding: 0.5rem 0.9rem;
        border-radius: 25px;
        font-weight: 600;
    }
    
    .badge.bg-success {
        background: linear-gradient(45deg, var(--luxury-gold), var(--luxury-gold-light)) !important;
        color: var(--luxury-black);
    }
    
    .badge.bg-danger {
        background: linear-gradient(45deg, #dc2626, #f87171) !important;
        color: white;
    }
    
    .card-footer {
        background: rgba(212, 175, 55, 0.1);
        border-top: 1px solid rgba(212, 175, 55, 0.3);
        padding: 1rem 1.5rem;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--luxury-gold), var(--luxury-gold-light));
        border: 2px solid var(--luxury-gold);
        border-radius: 50px;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(212, 175, 55, 0.4);
        color: var(--luxury-black);
    }
    
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 30px rgba(212, 175, 55, 0.5);
        background: linear-gradient(135deg, var(--luxury-black), var(--luxury-gray));
        color: var(--luxury-gold);
    }
    
    .btn-sm {
        border-radius: 25px;
        padding: 0.5rem 1.2rem;
        font-size: 0.85rem;
        font-weight: 600;
    }
    
    .btn-warning {
        background: linear-gradient(45deg, var(--luxury-gold), var(--luxury-gold-light));
        border: none;
        color: var(--luxury-black);
    }
    
    .btn-warning:hover {
        background: linear-gradient(45deg, var(--luxury-gold-light), var(--luxury-gold));
        color: var(--luxury-black);
        transform: translateY(-2px);
    }
    
    .btn-danger {
        background: linear-gradient(45deg, #dc2626, #f87171);
        border: none;
        color: white;
    }
    
    .btn-danger:hover {
        background: linear-gradient(45deg, #b91c1c, #dc2626);
        transform: translateY(-2px);
    }
    
    .btn-secondary {
        background: transparent;
        border: 2px solid var(--luxury-gold);
        color: var(--luxury-gold);
        border-radius: 50px;
    }
    
    .btn-secondary:hover {
        background: var(--luxury-gold);
        color: var(--luxury-black);
    }
    
    .form-control, .form-select {
        border-radius: 12px;
        border: 2px solid var(--luxury-gold);
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        background: rgba(10, 10, 10, 0.6);
        color: var(--luxury-silver);
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--luxury-gold-light);
        box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.25);
        background: rgba(26, 26, 26, 0.8);
        color: var(--luxury-gold);
    }
    
    .form-control::placeholder {
        color: rgba(192, 192, 192, 0.5);
    }
    
    .form-select option {
        background: var(--luxury-gray);
        color: var(--luxury-silver);
    }
    
    .form-label {
        color: var(--luxury-gold);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .form-text {
        color: var(--luxury-silver);
        opacity: 0.7;
    }
    
    .modal-header {
        border-radius: 25px 25px 0 0;
        background: linear-gradient(135deg, var(--luxury-gold), var(--luxury-gold-light));
        color: var(--luxury-black);
        padding: 1.5rem;
        border-bottom: none;
    }
    
    .modal-content {
        border-radius: 25px;
        border: 2px solid var(--luxury-gold);
        box-shadow: 0 20px 40px rgba(212, 175, 55, 0.3);
        overflow: hidden;
        background: rgba(26, 26, 26, 0.98);
        backdrop-filter: blur(10px);
    }
    
    .modal-body {
        background: rgba(26, 26, 26, 0.98);
        padding: 2rem;
    }
    
    .modal-footer {
        background: rgba(26, 26, 26, 0.98);
        border-top: 1px solid rgba(212, 175, 55, 0.3);
        padding: 1.5rem;
    }
    
    .modal-title {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
    }
    
    .btn-close {
        filter: brightness(0) invert(1);
    }
    
    /* Modal Z-index Fix */
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.7) !important;
        z-index: 1040 !important;
        pointer-events: auto !important;
    }
    
    .modal {
        z-index: 1055 !important;
        pointer-events: auto !important;
    }
    
    .modal-dialog {
        z-index: 1056 !important;
        pointer-events: auto !important;
    }
    
    .modal-content {
        z-index: 1057 !important;
        pointer-events: auto !important;
    }
    
    .modal-body,
    .modal-header,
    .modal-footer {
        pointer-events: auto !important;
    }
    
    .modal input,
    .modal select,
    .modal button,
    .modal textarea {
        pointer-events: auto !important;
    }
    
    .form-control,
    .form-select,
    .btn {
        pointer-events: auto !important;
        position: relative;
        z-index: 1;
    }
    
    .modal .btn-close {
        pointer-events: auto !important;
        z-index: 1060 !important;
    }
    
    .modal label,
    .modal .form-label,
    .modal .form-text {
        pointer-events: auto !important;
    }
    
    /* Pastikan tidak ada elemen yang menghalangi */
    .modal * {
        cursor: default;
    }
    
    .modal input,
    .modal select,
    .modal button,
    .modal a {
        cursor: pointer !important;
    }
    
    /* Animasi untuk kartu mobil */
    @keyframes fadeInUp {
        from { 
            opacity: 0; 
            transform: translateY(30px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }
    
    .mobil-card {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }
    
    /* Delay animasi untuk setiap kartu */
    .mobil-card:nth-child(1) { animation-delay: 0.1s; }
    .mobil-card:nth-child(2) { animation-delay: 0.2s; }
    .mobil-card:nth-child(3) { animation-delay: 0.3s; }
    .mobil-card:nth-child(4) { animation-delay: 0.4s; }
    .mobil-card:nth-child(5) { animation-delay: 0.5s; }
    .mobil-card:nth-child(6) { animation-delay: 0.6s; }
    
    /* Style untuk alert */
    .alert {
        border-radius: 15px;
        border: none;
        font-weight: 500;
        padding: 1rem 1.25rem;
    }
    
    .alert-success {
        background: linear-gradient(135deg, rgba(212, 175, 55, 0.2), rgba(247, 233, 142, 0.2));
        color: var(--luxury-gold);
        border-left: 4px solid var(--luxury-gold);
    }
    
    .alert-danger {
        background: linear-gradient(135deg, rgba(220, 38, 38, 0.2), rgba(248, 113, 113, 0.2));
        color: #fca5a5;
        border-left: 4px solid #dc2626;
    }
    
    .alert .btn-close {
        filter: brightness(0) invert(1);
    }
    
    /* Search bar styling */
    #searchInput {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23d4af37' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: 15px center;
        background-size: 20px;
        padding-left: 45px;
        background-color: rgba(10, 10, 10, 0.6);
        border: 2px solid var(--luxury-gold);
        color: var(--luxury-silver);
    }
    
    #searchInput:focus {
        background-color: rgba(26, 26, 26, 0.8);
        border-color: var(--luxury-gold-light);
        color: var(--luxury-gold);
    }
    
    #searchInput::placeholder {
        color: rgba(192, 192, 192, 0.5);
    }
    
    /* Scrollbar Styling */
    ::-webkit-scrollbar {
        width: 12px;
    }
    
    ::-webkit-scrollbar-track {
        background: var(--luxury-gray);
    }
    
    ::-webkit-scrollbar-thumb {
        background: linear-gradient(180deg, var(--luxury-gold) 0%, var(--luxury-gold-dark) 100%);
        border-radius: 10px;
        border: 2px solid var(--luxury-gray);
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(180deg, var(--luxury-gold-light) 0%, var(--luxury-gold) 100%);
    }
    
    /* Responsif untuk perangkat HP/mobile */
    @media (max-width: 768px) {
        .page-header {
            padding: 40px 20px;
        }
        
        .page-header h1 {
            font-size: 32px;
            flex-direction: column;
            gap: 8px;
        }
        
        .page-header h1 i {
            font-size: 28px;
        }
        
        .page-header p {
            font-size: 16px;
            padding: 0 15px;
        }
        
        h2 {
            font-size: 1.5rem;
            text-align: center;
            width: 100%;
        }
        
        h2:after {
            left: 50%;
            transform: translateX(-50%);
        }
        
        .card-img-top {
            height: 180px !important;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        .btn-sm {
            padding: 0.4rem 0.9rem;
            font-size: 0.8rem;
        }
        
        .container {
            padding: 0 15px;
        }
        
        /* Mobile-specific improvements */
        .mobil-card {
            margin-bottom: 20px;
        }
        
        .card-footer {
            padding: 0.75rem 1rem;
        }
        
        .btn-primary {
            width: 100%;
            margin-bottom: 10px;
        }
        
        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }
        
        .modal-dialog {
            margin: 10px;
        }
        
        .modal-body .row.g-3 {
            margin: 0 -5px;
        }
        
        .modal-body .col-md-6 {
            padding: 0 5px;
        }
    }
    
    /* Additional mobile optimizations for very small screens */
    @media (max-width: 576px) {
        .page-header {
            margin-bottom: 25px;
        }
        
        .page-header h1 {
            font-size: 28px;
        }
        
        .card-title {
            font-size: 1.1rem;
        }
        
        .card-text {
            font-size: 0.85rem;
        }
        
        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .btn-group .btn {
            width: 100%;
        }
    }
</style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-4">
    <div class="page-header">
        <h1><i class="fas fa-crown"></i> Manajemen Armada LuxRental</h1>
        <p>Kelola koleksi kendaraan mewah dengan mudah dan profesional</p>
    </div>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="fas fa-car-side"></i> Daftar Armada</h2>
        <?php if ($_SESSION['role'] == 'petugas') { ?>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahMobilModal">
                <i class="fas fa-plus-circle"></i> Tambah Mobil Baru
            </button>
        <?php } ?>
    </div>

    <!-- Alert Pesan -->
    <?php if (!empty($pesan)): ?>
        <div class="alert alert-<?php echo $tipe_pesan; ?> alert-dismissible fade show" role="alert">
            <?php echo $pesan; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Search Bar -->
    <div class="mb-4">
        <input type="text" id="searchInput" class="form-control" placeholder=" Cari mobil berdasarkan merk, type, atau nopol...">
    </div>

    <!-- Card Grid -->
    <div class="row" id="mobilList">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $statusBadge = $row['status'] == "tersedia" 
                    ? "<span class='badge bg-success'>Tersedia</span>" 
                    : "<span class='badge bg-danger'>Tidak Tersedia</span>";

                echo "
                <div class='col-md-4 mb-4 mobil-card'>
                    <div class='card h-100'>
                        <img src='uploads/mobil/" . htmlspecialchars($row['foto']) . "' class='card-img-top' alt='" . htmlspecialchars($row['brand']) . " " . htmlspecialchars($row['type']) . "'>
                        <div class='card-body'>
                            <h5 class='card-title'><i class='fas fa-car'></i> " . htmlspecialchars($row['brand']) . " - " . htmlspecialchars($row['type']) . "</h5>
                            <p class='card-text mb-1'><strong>No. Polisi:</strong> " . htmlspecialchars($row['nopol']) . "</p>
                            <p class='card-text mb-1'><strong>Tahun:</strong> " . htmlspecialchars($row['tahun']) . "</p>
                            <p class='card-text price mb-2'>Rp " . number_format($row['harga'], 0, ',', '.') . "/hari</p>
                            $statusBadge
                        </div>
                        <div class='card-footer text-end'>
                            <a class='btn btn-warning btn-sm' href='index.php?page=edit_mobil&id=" . $row['nopol'] . "'><i class='fas fa-edit'></i> Edit</a>
                            <a class='btn btn-danger btn-sm' href='hapus_mobil.php?id=" . $row['nopol'] . "' onclick=\"return confirm('Yakin hapus data ini?')\"><i class='fas fa-trash'></i> Hapus</a>
                        </div>
                    </div>
                </div>";
            }
        } else {
            echo "<p class='text-center'>Tidak ada data mobil</p>";
        }
        ?>
    </div>
</div>

<?php if ($_SESSION['role'] == 'petugas') { ?>
<!-- Modal Tambah Mobil -->
<div class="modal fade" id="tambahMobilModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id="formTambahMobil">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-crown"></i> Tambah Mobil Mewah</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label class="form-label">No. Polisi <span class="text-danger">*</span></label>
                        <input type="text" name="nopol" class="form-control" required 
                               placeholder="Contoh: B 1234 ABC">
                        <div class="form-text">Nomor polisi harus unik</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Brand <span class="text-danger">*</span></label>
                        <input type="text" name="brand" class="form-control" required 
                               placeholder="Contoh: Toyota, Honda">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tipe Mobil <span class="text-danger">*</span></label>
                        <select name="type" class="form-select" required>
                            <option value="">-- Pilih Tipe Mobil --</option>
                            <option value="Sedan">Sedan</option>
                            <option value="SUV">SUV</option>
                            <option value="MPV">MPV</option>
                            <option value="Hatchback">Hatchback</option>
                            <option value="Sport">Sport</option>
                            <option value="Pickup">Pickup</option>
                            <option value="Van">Van</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tahun <span class="text-danger">*</span></label>
                        <input type="number" name="tahun" class="form-control" required 
                               min="1990" max="<?php echo date('Y') + 1; ?>" 
                               placeholder="Contoh: 2023">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Harga (Rp / Hari) <span class="text-danger">*</span></label>
                        <input type="number" name="harga" class="form-control" required 
                               min="0" step="0.01" placeholder="Contoh: 300000">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Foto <span class="text-danger">*</span></label>
                        <input type="file" name="foto" accept="image/*" class="form-control" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="tersedia">Tersedia</option>
                            <option value="tidak">Tidak Tersedia</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="simpan" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Data</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php } ?>

<script>
// Search functionality
document.getElementById("searchInput").addEventListener("keyup", function() {
    let keyword = this.value.toLowerCase();
    let cards = document.querySelectorAll(".mobil-card");
    cards.forEach(card => {
        let text = card.innerText.toLowerCase();
        card.style.display = text.includes(keyword) ? "" : "none";
    });
});

// Fix modal interaction
document.addEventListener('DOMContentLoaded', function() {
    const modalElement = document.getElementById('tambahMobilModal');
    if (modalElement) {
        modalElement.addEventListener('shown.bs.modal', function () {
            // Pastikan semua elemen form bisa diklik
            const allInputs = modalElement.querySelectorAll('input, select, button, textarea');
            allInputs.forEach(el => {
                el.style.pointerEvents = 'auto';
                el.style.zIndex = '1';
            });
        });
    }
});

// Auto close modal setelah berhasil tambah data
<?php if ($tipe_pesan == 'success'): ?>
document.addEventListener('DOMContentLoaded', function() {
    var modal = bootstrap.Modal.getInstance(document.getElementById('tambahMobilModal'));
    if (modal) {
        modal.hide();
    }
});
<?php endif; ?>

// Validasi client-side untuk nopol (opsional)
document.getElementById('formTambahMobil')?.addEventListener('submit', function(e) {
    const nopol = document.querySelector('input[name="nopol"]').value.trim();
    if (nopol === '') {
        e.preventDefault();
        alert('Nomor polisi harus diisi!');
        return false;
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>