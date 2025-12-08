<?php
// Cek session
if(!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'petugas')) {
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
$total_query = "SELECT COUNT(*) as total FROM tbl_member WHERE is_active = 1";
$total_result = $koneksi->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_data = $total_row['total'];
$total_pages = ceil($total_data / $limit);

// Ambil data member aktif dengan limit
$query = "SELECT * FROM tbl_member WHERE is_active = 1 ORDER BY nik DESC LIMIT $limit OFFSET $offset";
$result = $koneksi->query($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Member - LuxRental</title>
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
        
        .page-header h1 {
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
        
        .page-header h1 i {
            font-size: 2.5rem;
            color: var(--luxury-gold-light);
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(5deg); }
        }
        
        .page-header p {
            font-size: 1.1rem;
            color: var(--luxury-silver);
        }
        
        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .header-text {
            flex: 1;
            min-width: 300px;
        }
        
        .header h2 {
            margin: 0 0 8px 0;
            font-size: 1.8em;
            font-weight: 600;
            letter-spacing: 0.5px;
            line-height: 1.3;
            align-items: center;
            color: black;
        }
        
        .header-icon {
            font-size: 2.5em;
            opacity: 0.9;
        }
        
        .info-box {
            background: rgba(212, 175, 55, 0.1);
            border: 2px solid rgba(212, 175, 55, 0.3);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            color: var(--luxury-gold-light);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.1);
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .info-box i {
            font-size: 1.5rem;
            color: var(--luxury-gold);
        }
        
        .info-box strong {
            color: var(--luxury-gold);
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
            min-width: 1000px;
        }
        
        thead {
            background: linear-gradient(135deg, var(--luxury-black) 0%, var(--luxury-gray) 100%);
            border-bottom: 3px solid var(--luxury-gold);
        }
        
        th {
            padding: 18px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--luxury-gold);
        }
        
        tbody tr {
            border-bottom: 1px solid rgba(212, 175, 55, 0.1);
            transition: all 0.3s ease;
        }
        
        tbody tr:hover {
            background-color: rgba(212, 175, 55, 0.05);
            transform: translateX(5px);
        }
        
        td {
            padding: 15px;
            font-size: 0.95rem;
            color: var(--luxury-silver);
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: var(--luxury-silver);
            font-style: italic;
            font-size: 1.1rem;
        }
        
        .foto-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .foto-member {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--luxury-gold);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
        }
        
        .foto-member:hover {
            transform: scale(2);
            z-index: 100;
            position: relative;
            border-color: var(--luxury-gold-light);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.5);
        }
        
        .btn {
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            border: none;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn.nonaktif {
            background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
            color: var(--luxury-black);
            border: 2px solid transparent;
        }
        
        .btn.nonaktif:hover {
            background: linear-gradient(135deg, #f7931e 0%, #ff6b35 100%);
            border-color: #ff6b35;
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.4);
            transform: translateY(-3px);
        }
        
        .btn.btn-tambah {
            background: linear-gradient(135deg, var(--luxury-gold) 0%, #c9a532 100%);
            color: var(--luxury-black);
            border: 2px solid transparent;
            padding: 12px 25px;
            font-size: 1rem;
        }
        
        .btn.btn-tambah:hover {
            background: linear-gradient(135deg, #c9a532 0%, var(--luxury-gold) 100%);
            border-color: var(--luxury-gold);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
            transform: translateY(-3px);
        }
        
        .tidak-ada {
            color: var(--luxury-silver);
            font-style: italic;
            opacity: 0.6;
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
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
        }
        
        .modal-content {
            background: linear-gradient(135deg, var(--luxury-black) 0%, var(--luxury-gray) 100%);
            margin: 3% auto;
            padding: 40px;
            border: 2px solid var(--luxury-gold);
            border-radius: 20px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 15px 50px rgba(212, 175, 55, 0.3);
        }
        
        .modal-content h3 {
            font-family: 'Playfair Display', serif;
            color: var(--luxury-gold);
            font-size: 2rem;
            margin-bottom: 25px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .modal-content label {
            display: block;
            margin-top: 15px;
            margin-bottom: 8px;
            color: var(--luxury-gold);
            font-weight: 600;
            font-size: 0.95rem;
        }
        
        .modal-content input[type="text"],
        .modal-content input[type="password"],
        .modal-content input[type="file"],
        .modal-content select,
        .modal-content textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid rgba(212, 175, 55, 0.3);
            border-radius: 10px;
            background: rgba(26, 26, 26, 0.7);
            color: var(--luxury-silver);
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .modal-content input:focus,
        .modal-content select:focus,
        .modal-content textarea:focus {
            outline: none;
            border-color: var(--luxury-gold);
            background: rgba(26, 26, 26, 0.9);
            box-shadow: 0 0 15px rgba(212, 175, 55, 0.2);
        }
        
        .modal-content select option {
            background: var(--luxury-black);
            color: var(--luxury-silver);
        }
        
        .modal-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            justify-content: center;
        }
        
        .modal-buttons .btn {
            flex: 1;
            max-width: 200px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--luxury-gold) 0%, #c9a532 100%);
            color: var(--luxury-black);
            border: 2px solid transparent;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #c9a532 0%, var(--luxury-gold) 100%);
            border-color: var(--luxury-gold);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            color: var(--luxury-white);
            border: 2px solid transparent;
        }
        
        .btn-danger:hover {
            background: linear-gradient(135deg, #991b1b 0%, #dc2626 100%);
            border-color: #dc2626;
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            .page-header h1 {
                font-size: 2rem;
                flex-direction: column;
            }
            
            .page-header h1 i {
                font-size: 2rem;
            }
            
            th, td {
                padding: 10px 8px;
                font-size: 0.85rem;
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
            <h1><i class="fas fa-users-cog"></i> Kelola Data Member <i class="fas fa-crown"></i></h1>
            <p>Daftar lengkap member aktif sistem rental premium</p>
        </div>
        
        <div class="info-box">
            <i class="fas fa-info-circle"></i>
            <div>
                <strong>Info:</strong> Anda dapat menambahkan member baru atau menonaktifkan member yang sudah ada.
            </div>
        </div>
        
        <!-- Tombol Tambah Member -->
        <div style="margin-bottom: 20px; text-align: right;">
            <button onclick="openTambahModal()" class="btn btn-tambah">
                <i class="fas fa-user-plus"></i> Tambah Member Baru
            </button>
        </div>
        
        <div class="page-info">
            Menampilkan <strong><?= min($offset + 1, $total_data); ?> - <?= min($offset + $limit, $total_data); ?></strong> dari <strong><?= $total_data; ?></strong> member
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
                                    <a href="nonaktifkan_member.php?nik=<?= $row['nik']; ?>" class="btn nonaktif" onclick="return confirm('Yakin mau menonaktifkan member <?= $row['nama']; ?>? Member tidak bisa login lagi.');">
                                        <i class="fas fa-user-slash"></i> Nonaktifkan
                                    </a>
                                </td>
                            </tr>
                    <?php 
                        }
                    } else {
                        echo "<tr><td colspan='9' class='no-data'><i class='fas fa-users-slash' style='font-size: 3rem; color: var(--luxury-gold); opacity: 0.3; display: block; margin-bottom: 15px;'></i>Belum ada data member aktif.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if($total_pages > 1): ?>
        <div class="pagination">
            <?php if($page > 1): ?>
                <a href="?page=member_sewa&pg=1"><i class="fas fa-angle-double-left"></i></a>
                <a href="?page=member_sewa&pg=<?= $page - 1; ?>"><i class="fas fa-angle-left"></i> Prev</a>
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
                    <a href="?page=member_sewa&pg=<?= $i; ?>"><?= $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>
            
            <?php if($page < $total_pages): ?>
                <a href="?page=member_sewa&pg=<?= $page + 1; ?>">Next <i class="fas fa-angle-right"></i></a>
                <a href="?page=member_sewa&pg=<?= $total_pages; ?>"><i class="fas fa-angle-double-right"></i></a>
            <?php else: ?>
                <span class="disabled">Next <i class="fas fa-angle-right"></i></span>
                <span class="disabled"><i class="fas fa-angle-double-right"></i></span>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Modal Tambah Member -->
    <div id="modalTambahMember" class="modal">
        <div class="modal-content">
            <h3><i class="fas fa-user-plus"></i> Tambah Member Baru</h3>
            <form action="proses_tambah_member.php" method="POST" enctype="multipart/form-data">
                <label>NIK <span style="color: red;">*</span></label>
                <input type="text" name="nik" pattern="[0-9]{16}" title="NIK harus 16 digit angka" required placeholder="Contoh: 3201234567890123">
                
                <label>Nama Lengkap <span style="color: red;">*</span></label>
                <input type="text" name="nama" required placeholder="Masukkan nama lengkap">
                
                <label>Jenis Kelamin <span style="color: red;">*</span></label>
                <select name="jk" required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
                
                <label>Nomor Telepon <span style="color: red;">*</span></label>
                <input type="text" name="telp" pattern="[0-9]{10,15}" title="Nomor telepon harus 10-15 digit angka" required placeholder="Contoh: 081234567890">
                
                <label>Alamat <span style="color: red;">*</span></label>
                <textarea name="alamat" rows="3" required placeholder="Masukkan alamat lengkap"></textarea>
                
                <label>Username <span style="color: red;">*</span></label>
                <input type="text" name="user" pattern="[a-zA-Z0-9_]{4,20}" title="Username 4-20 karakter, hanya huruf, angka, dan underscore" required placeholder="Username untuk login">
                
                <label>Password <span style="color: red;">*</span></label>
                <input type="password" name="pass" minlength="6" required placeholder="Minimal 6 karakter">
                
                <label>Foto Profil (Opsional)</label>
                <input type="file" name="foto" accept="image/*">
                
                <div class="modal-buttons">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Member
                    </button>
                    <button type="button" class="btn btn-danger" onclick="closeTambahModal()">
                        <i class="fas fa-times"></i> Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function openTambahModal() {
            document.getElementById("modalTambahMember").style.display = "block";
        }
        
        function closeTambahModal() {
            document.getElementById("modalTambahMember").style.display = "none";
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById("modalTambahMember");
            if (event.target == modal) {
                closeTambahModal();
            }
        }
    </script>
</body>
</html>
<?php
// Tutup koneksi
$koneksi->close();
?>