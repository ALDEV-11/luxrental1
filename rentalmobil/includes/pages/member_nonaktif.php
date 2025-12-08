<?php
// Cek apakah user sudah login dan memiliki akses
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'petugas')) {
    header("Location: ../auth/login.php");
    exit;
}

// Koneksi database
$koneksi = new mysqli("localhost", "root", "root", "luxrental");

// Cek koneksi
if ($koneksi->connect_errno) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

// Pagination
$limit = 5; // Batas data per halaman
$page = isset($_GET['pg']) ? (int)$_GET['pg'] : 1;
$offset = ($page - 1) * $limit;

// Hitung total data
$total_query = "SELECT COUNT(*) as total FROM tbl_member WHERE is_active = 0";
$total_result = $koneksi->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_data = $total_row['total'];
$total_pages = ceil($total_data / $limit);

// Ambil data member nonaktif dengan limit
$query = "SELECT * FROM tbl_member WHERE is_active = 0 ORDER BY nik DESC LIMIT $limit OFFSET $offset";
$result = $koneksi->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Nonaktif - LuxRental</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png">
    <style>
        :root {
            --luxury-black: #0a0a0a;
            --luxury-gray: #1a1a1a;
            --luxury-gold: #d4af37;
            --luxury-gold-light: #f7e98e;
            --luxury-silver: #c0c0c0;
            --luxury-white: #ffffff;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
            color: var(--luxury-silver);
            line-height: 1.6;
            padding: 20px;
            min-height: 100vh;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: rgba(26, 26, 26, 0.95);
            border: 2px solid var(--luxury-gold);
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(212, 175, 55, 0.2);
            backdrop-filter: blur(10px);
            overflow: hidden;
            padding: 40px;
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }
        
        .page-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            font-weight: 700;
            color: var(--luxury-gold);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            text-shadow: 0 2px 20px rgba(212, 175, 55, 0.4);
        }
        
        .page-header h2 i {
            font-size: 2.5rem;
            color: var(--luxury-gold-light);
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .page-header p {
            font-size: 1.1rem;
            color: var(--luxury-silver);
            margin: 0;
            line-height: 1.5;
        }
        
        .table-container {
            background-color: rgba(10, 10, 10, 0.5);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            overflow-x: auto;
            margin-top: 20px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background: transparent;
            min-width: 1000px;
        }
        
        thead {
            background: linear-gradient(135deg, var(--luxury-black) 0%, var(--luxury-gray) 100%);
            border-bottom: 3px solid var(--luxury-gold);
        }
        
        th {
            padding: 18px 15px;
            text-align: left;
            color: var(--luxury-gold);
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            white-space: nowrap;
        }
        
        td {
            padding: 15px;
            border-bottom: 1px solid rgba(212, 175, 55, 0.1);
            color: var(--luxury-silver);
            font-size: 0.95rem;
            white-space: nowrap;
        }
        
        tr:hover {
            background-color: rgba(212, 175, 55, 0.05);
            transition: all 0.3s ease;
            transform: translateX(5px);
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            text-align: center;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn.aktifkan {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: var(--luxury-black);
            font-weight: 700;
            border: 2px solid transparent;
        }
        
        .btn.aktifkan:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.5);
            border-color: #20c997;
        }
        
        .foto-member {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--luxury-gold);
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
            transition: all 0.3s ease;
        }
        
        .foto-member:hover {
            transform: scale(2);
            z-index: 100;
            position: relative;
            border-color: var(--luxury-gold-light);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.5);
        }
        
        .tidak-ada {
            color: var(--luxury-silver);
            font-style: italic;
            font-size: 0.9rem;
            opacity: 0.6;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: var(--luxury-silver);
            font-size: 1.1rem;
            font-style: italic;
        }
        
        .back-button {
            text-align: center;
            margin-top: 30px;
        }
        
        .back-button .btn {
            background: linear-gradient(135deg, var(--luxury-gold) 0%, #c9a532 100%);
            color: var(--luxury-black);
            padding: 12px 30px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }
        
        .back-button .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.5);
        }
        
        /* Pagination Styles */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            margin-top: 30px;
            padding: 20px 0;
        }
        
        .pagination a,
        .pagination span {
            padding: 10px 18px;
            border: 2px solid var(--luxury-gold);
            border-radius: 8px;
            text-decoration: none;
            color: var(--luxury-gold);
            font-weight: 600;
            transition: all 0.3s ease;
            background: transparent;
        }
        
        .pagination a:hover {
            background: var(--luxury-gold);
            color: var(--luxury-black);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
        }
        
        .pagination .active {
            background: linear-gradient(135deg, var(--luxury-gold) 0%, #c9a532 100%);
            color: var(--luxury-black);
            border-color: var(--luxury-gold);
        }
        
        .pagination .disabled {
            opacity: 0.3;
            cursor: not-allowed;
            pointer-events: none;
        }
        
        .page-info {
            color: var(--luxury-silver);
            margin: 20px 0;
            text-align: center;
            font-size: 0.95rem;
        }
        
        .page-info strong {
            color: var(--luxury-gold);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                margin: 10px;
                padding: 20px;
            }
            
            .page-header h2 {
                font-size: 2rem;
                flex-direction: column;
                gap: 8px;
            }
            
            .page-header h2 i {
                font-size: 2rem;
            }
            
            .page-header p {
                font-size: 1rem;
                padding: 0 10px;
            }
            
            th, td {
                padding: 10px 8px;
                font-size: 0.85rem;
            }
            
            table {
                min-width: 1000px;
            }
            
            .pagination {
                flex-wrap: wrap;
            }
            
            .pagination a,
            .pagination span {
                padding: 8px 12px;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h2><i class="fas fa-user-slash"></i> Daftar Member Nonaktif <i class="fas fa-ban"></i></h2>
            <p>Member yang tidak dapat login tetapi riwayat transaksinya tetap tersimpan</p>
        </div>
        
        <div class="page-info">
            Menampilkan <strong><?= min($offset + 1, $total_data); ?> - <?= min($offset + $limit, $total_data); ?></strong> dari <strong><?= $total_data; ?></strong> member nonaktif
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Username</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = $offset + 1;
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row['nik']; ?></td>
                                <td><strong style="color: var(--luxury-gold-light);"><?= $row['nama']; ?></strong></td>
                                <td><?= $row['jk'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
                                <td><?= $row['telp']; ?></td>
                                <td><?= $row['alamat']; ?></td>
                                <td><strong><?= $row['user']; ?></strong></td>
                                <td style="text-align: center;">
                                    <?php if(!empty($row['foto'])) { ?>
                                        <img src="uploads/<?= $row['foto']; ?>" alt="Foto Member" class="foto-member">
                                    <?php } else { ?>
                                        <span class="tidak-ada">Tidak ada</span>
                                    <?php } ?>
                                </td>
                                <td style="text-align: center;">
                                    <a href="aktifkan_member.php?nik=<?= $row['nik']; ?>" class="btn aktifkan" onclick="return confirm('Aktifkan member <?= $row['nama']; ?>?');">
                                        <i class="fas fa-user-check"></i> Aktifkan
                                    </a>
                                </td>
                            </tr>
                    <?php 
                        }
                    } else {
                        echo "<tr><td colspan='9' class='no-data'><i class='fas fa-info-circle' style='font-size: 3rem; color: var(--luxury-gold); opacity: 0.3; display: block; margin-bottom: 15px;'></i>Tidak ada member yang dinonaktifkan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if($total_pages > 1): ?>
        <div class="pagination">
            <?php if($page > 1): ?>
                <a href="?page=member_nonaktif&pg=1"><i class="fas fa-angle-double-left"></i></a>
                <a href="?page=member_nonaktif&pg=<?= $page - 1; ?>"><i class="fas fa-angle-left"></i> Prev</a>
            <?php else: ?>
                <span class="disabled"><i class="fas fa-angle-double-left"></i></span>
                <span class="disabled"><i class="fas fa-angle-left"></i> Prev</span>
            <?php endif; ?>
            
            <?php 
            // Tampilkan nomor halaman
            $start_page = max(1, $page - 2);
            $end_page = min($total_pages, $page + 2);
            
            for($i = $start_page; $i <= $end_page; $i++): 
            ?>
                <?php if($i == $page): ?>
                    <span class="active"><?= $i; ?></span>
                <?php else: ?>
                    <a href="?page=member_nonaktif&pg=<?= $i; ?>"><?= $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>
            
            <?php if($page < $total_pages): ?>
                <a href="?page=member_nonaktif&pg=<?= $page + 1; ?>">Next <i class="fas fa-angle-right"></i></a>
                <a href="?page=member_nonaktif&pg=<?= $total_pages; ?>"><i class="fas fa-angle-double-right"></i></a>
            <?php else: ?>
                <span class="disabled">Next <i class="fas fa-angle-right"></i></span>
                <span class="disabled"><i class="fas fa-angle-double-right"></i></span>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        
        <div class="back-button">
            <a href="index.php?page=member_sewa" class="btn"><i class="fas fa-arrow-left"></i> Kembali ke Member Aktif</a>
        </div>
    </div>
</body>
</html>
<?php
// Tutup koneksi
$koneksi->close();
?>